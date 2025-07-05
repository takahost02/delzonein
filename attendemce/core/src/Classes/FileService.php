<?php
namespace Classes;

use Documents\Common\Model\Document;
use Documents\Common\Model\EmployeeDocument;
use Model\File;
use Utils\LogManager;

class FileService
{

    private static $me = null;

    private $memcache;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (empty(self::$me)) {
            self::$me = new FileService();
        }

        return self::$me;
    }

    public function getFromCache($key)
    {
        try {
            $data = MemcacheService::getInstance()->get($key);

            if (!empty($data)) {
                return $data;
            }

            return null;
        } catch (\Exception $e) {
            LogManager::getInstance()->notifyException($e);
            return null;
        }
    }

    public function saveInCache($key, $data, $expire)
    {
        if (!class_exists('\\Memcached')) {
            return;
        }
        try {
            if (empty($this->memcache)) {
                $this->memcache = new \Memcached();
                $this->memcache->addServer(GLOB_MEMCACHE_SERVER, 11211);
            }
            $this->memcache->set($key, $data, $expire);
        } catch (\Exception $e) {
            LogManager::getInstance()->notifyException($e);
        }
    }

    public function saveEmployeeDocument($documentName, $documentDetails, $fileName, $extension, $employeeId, $docType, $visibleTo, $unique = false, $hidden = false)
    {

        $file = $this->saveFile($fileName, $extension, $unique, 'EmployeeDocument', $employeeId);

        $doc = new EmployeeDocument();
        //find employee document by attachment name
        if ($unique) {
            $doc->Load('employee = ? and attachment = ?', [$employeeId, $file->filename]);
        }
        if ($doc->attachment != $file->name) {
            $doc->name = $documentName;
            $doc->employee = $employeeId;
            $doc->document = $docType->id;
            $doc->status = 'Active';
            $doc->details = $documentDetails;
            $doc->attachment = $file->name;
            $doc->expire_notification_last = -1;
            $doc->visible_to = $visibleTo;
            if ($hidden) {
                $doc->hidden = 1;
            } else {
                $doc->hidden = 0;
            }
        }
        // if the document is already there only update the added date
        $doc->date_added = date("Y-m-d H:i:s");

        $doc->Save();

        return true;
    }

    public function checkAddSmallProfileImageS3($profileImage)
    {
        $file = new File();
        $file->Load('file_group = ? and employee = ?', array('profile_image_small', $profileImage->employee));

        if (empty($file->id)) {
            LogManager::getInstance()->info("Small profile image ".$profileImage->name."_small not found");

            $largeFileUrl = $this->getFileUrl($profileImage->name);

            $file->name = $profileImage->name."_small";
            $signInMappingField = SIGN_IN_ELEMENT_MAPPING_FIELD_NAME;
            $file->$signInMappingField = $profileImage->$signInMappingField;
            $file->filename = $file->name.str_replace($profileImage->name, "", $profileImage->filename);

            file_put_contents("/tmp/".$file->filename."_orig", file_get_contents($largeFileUrl));

            if (file_exists("/tmp/".$file->filename."_orig")) {
                //Resize image to 100

                try {
                    $img = new \Classes\SimpleImage("/tmp/" . $file->filename . "_orig");
                    $img->fitToWidth(140);
                    $img->save("/tmp/" . $file->filename);
                } catch (\Exception $e) {
                    LogManager::getInstance()->error($e->getTraceAsString());
                    return null;
                }

                $uploadFilesToS3Key = SettingsManager::getInstance()->getSetting(
                    "Files: Amazon S3 Key for File Upload"
                );
                $uploadFilesToS3Secret = SettingsManager::getInstance()->getSetting(
                    "Files: Amazon S3 Secret for File Upload"
                );
                $s3Bucket = SettingsManager::getInstance()->getSetting("Files: S3 Bucket");

                $uploadname = CLIENT_NAME."/".$file->filename;
                $localFile = "/tmp/".$file->filename;

                $s3FileSys = new S3FileSystem($uploadFilesToS3Key, $uploadFilesToS3Secret);
                $result = $s3FileSys->putObject($s3Bucket, $uploadname, $localFile, 'authenticated-read');

                $file->size = filesize($localFile);

                unlink("/tmp/".$file->filename);
                unlink("/tmp/".$file->filename."_orig");

                LogManager::getInstance()->info("Upload Result:".print_r($result, true));

                $file->employee = $profileImage->employee;
                $file->file_group = 'profile_image_small';
                $file->size_text = $this->getReadableSize($file->size);

                if (!empty($result)) {
                    $fileDelete = new File();
                    $fileDelete->Load('filename = ?', [$file->filename]);
                    if ($fileDelete->filename === $file->filename) {
                        $fileDelete->Delete();
                    }

                    $file->Save();
                }

                return $file;
            }

            return null;
        }

        return $file;
    }

    public function checkAddSmallProfileImage($profileImage)
    {
        $file = new File();
        $file->Load('file_group = ? and employee = ?', array('profile_image_small', $profileImage->employee));

        if (empty($file->id)) {
            LogManager::getInstance()->info("Small profile image ".$profileImage->name."_small not found");

            if (file_exists(BaseService::getInstance()->getDataDirectory().$profileImage->filename)) {
                //Resize image to 100

                $file->name = $profileImage->name."_small";
                $signInMappingField = SIGN_IN_ELEMENT_MAPPING_FIELD_NAME;
                $file->$signInMappingField = $profileImage->$signInMappingField;
                $file->filename = $file->name.str_replace($profileImage->name, "", $profileImage->filename);

                try {
                    $img = new \Classes\SimpleImage(
                        BaseService::getInstance()->getDataDirectory() . $profileImage->filename
                    );
                    $img->fitToWidth(140);
                    $img->save(BaseService::getInstance()->getDataDirectory() . $file->filename);
                    $file->employee = $profileImage->employee;
                    $file->file_group = 'profile_image_small';
                    $file->size = filesize(BaseService::getInstance()->getDataDirectory() . $file->filename);
                    $file->size_text = $this->getReadableSize($file->size);
                    $file->Save();
                } catch (\Exception $e) {
                    LogManager::getInstance()->error($e->getTraceAsString());
                    return null;
                }

                return $file;
            }

            return null;
        }

        return $file;
    }

    public function updateSmallProfileImage($profile)
    {
        $file = new File();
        $file->Load('file_group = ? and employee = ?', array('profile_image', $profile->id));

        if ($file->employee == $profile->id) {
            $uploadFilesToS3 = SettingsManager::getInstance()->getSetting("Files: Upload Files to S3");
            if ($uploadFilesToS3 == "1") {
                try {
                    $fileNew = $this->checkAddSmallProfileImageS3($file);
                    if (!empty($fileNew)) {
                        $file = $fileNew;
                    }

                    $uploadFilesToS3Key = SettingsManager::getInstance()->getSetting(
                        "Files: Amazon S3 Key for File Upload"
                    );
                    $uploadFilesToS3Secret = SettingsManager::getInstance()->getSetting(
                        "Files: Amazon S3 Secret for File Upload"
                    );
                    $s3FileSys = new S3FileSystem($uploadFilesToS3Key, $uploadFilesToS3Secret);
                    $s3WebUrl = SettingsManager::getInstance()->getSetting("Files: S3 Web Url");
                    $fileUrl = $s3WebUrl.CLIENT_NAME."/".$file->filename;

                    $expireUrl = $this->getFromCache($fileUrl);
                    if (empty($expireUrl)) {
                        $expireUrl = $s3FileSys->generateExpiringURL($fileUrl, 600);
                        $this->saveInCache($fileUrl, $expireUrl, 500);
                    }

                    $profile->image = $expireUrl;
                } catch (\Exception $e) {
                    LogManager::getInstance()->error("Error generating profile image: ".$e->getMessage());
                    LogManager::getInstance()->notifyException($e);
                    $profile->image = $this->generateProfileImage($profile->first_name, $profile->last_name);
                }
            } elseif (substr($file->filename, 0, 8) === 'https://') {
                $profile->image = $file->filename;
            } else {
                $fileNew = $this->checkAddSmallProfileImage($file);
                $profile->image = $this->getFileUrl($fileNew->filename);
            }
        } else {
            $profile->image = $this->generateProfileImage($profile->first_name, $profile->last_name);
        }

        return $profile;
    }

    public function updateProfileImage($profile)
    {
        $file = new File();
        $file->Load('file_group = ? and employee = ?', array('profile_image', $profile->id));

        if ($file->employee == $profile->id) {
            $uploadFilesToS3 = SettingsManager::getInstance()->getSetting("Files: Upload Files to S3");
            if ($uploadFilesToS3 == "1") {
                $uploadFilesToS3Key = SettingsManager::getInstance()->getSetting(
                    "Files: Amazon S3 Key for File Upload"
                );
                $uploadFilesToS3Secret = SettingsManager::getInstance()->getSetting(
                    "Files: Amazon S3 Secret for File Upload"
                );
                $s3FileSys = new S3FileSystem($uploadFilesToS3Key, $uploadFilesToS3Secret);
                $s3WebUrl = SettingsManager::getInstance()->getSetting("Files: S3 Web Url");
                $fileUrl = $s3WebUrl.CLIENT_NAME."/".$file->filename;

                $expireUrl = $this->getFromCache($fileUrl);
                if (empty($expireUrl)) {
                    $expireUrl = $s3FileSys->generateExpiringURL($fileUrl, 600);
                    $this->saveInCache($fileUrl, $expireUrl, 500);
                }

                $profile->image = $expireUrl;
            } elseif (substr($file->filename, 0, 8) === 'https://') {
                $profile->image = $file->filename;
            } else {
                $profile->image = $this->getLocalSecureUrl($file->filename);
            }
        } else {
            $profile->image = $this->generateProfileImage($profile->first_name, $profile->last_name);
        }

        return $profile;
    }

    public function getFileUrl($fileName, $isExpiring = true)
    {
        $file = new File();
        $file->Load('name = ?', array($fileName));

        if ($fileName !== $file->name) {
            $file->Load('filename = ?', array($fileName));
        }

        $uploadFilesToS3 = SettingsManager::getInstance()->getSetting("Files: Upload Files to S3");

        if ($uploadFilesToS3 == "1") {
            $uploadFilesToS3Key = SettingsManager::getInstance()->getSetting(
                "Files: Amazon S3 Key for File Upload"
            );
            $uploadFilesToS3Secret = SettingsManager::getInstance()->getSetting(
                "Files: Amazon S3 Secret for File Upload"
            );
            $s3FileSys = new S3FileSystem($uploadFilesToS3Key, $uploadFilesToS3Secret);
            $s3WebUrl = SettingsManager::getInstance()->getSetting("Files: S3 Web Url");
            $fileUrl = $s3WebUrl.CLIENT_NAME."/".$file->filename;

            $expireUrl = $this->getFromCache($fileUrl);
            if (empty($expireUrl)) {
                if (!$isExpiring) {
                    $expireUrl = $s3FileSys->generateExpiringURL($fileUrl, 8640000);
                    $this->saveInCache($fileUrl, $expireUrl, 8640000);
                } else {
                    $expireUrl = $s3FileSys->generateExpiringURL($fileUrl, 600);
                    $this->saveInCache($fileUrl, $expireUrl, 500);
                }
            }


            return $expireUrl;
        } else {
            return  $this->getLocalSecureUrl($file->filename);
        }
    }

    public function getLocalSecureUrl($fileName)
    {
        $file = new File();
        $file->Load('name = ?', array($fileName));

        if ($fileName !== $file->name) {
            $file->Load('filename = ?', array($fileName));
        }

        return CLIENT_BASE_URL.'service.php?a=download&file='.$file->filename.'&signature='.BaseService::getInstance()->createHash($file->filename);
    }

    public function deleteProfileImage($profileId)
    {
        $file = new File();
        $profilesImages = $file->Find('file_group = ? and employee = ?', array('profile_image', $profileId));
        foreach ($profilesImages as $file) {
            if ($file->employee == $profileId) {
                $ok = $file->Delete();
                if ($ok) {
                    $this->deleteFileFromDisk($file);
                } else {
                    return false;
                }
            }
        }

        $profilesImages = $file->Find('file_group = ? and employee = ?', array('profile_image_small', $profileId));
        foreach ($profilesImages as $file) {
            if ($file->employee == $profileId) {
                $ok = $file->Delete();
                if ($ok) {
                    $this->deleteFileFromDisk($file);
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    public function deleteFileFromDisk($file)
    {
        $uploadFilesToS3 = SettingsManager::getInstance()->getSetting("Files: Upload Files to S3");

        if ($uploadFilesToS3 == "1") {
            $uploadFilesToS3Key = SettingsManager::getInstance()->getSetting(
                "Files: Amazon S3 Key for File Upload"
            );
            $uploadFilesToS3Secret = SettingsManager::getInstance()->getSetting(
                "Files: Amazon S3 Secret for File Upload"
            );
            $s3Bucket = SettingsManager::getInstance()->getSetting("Files: S3 Bucket");

            $uploadname = CLIENT_NAME."/".$file->filename;
            LogManager::getInstance()->info("Delete from S3:".$uploadname);

            $s3FileSys = new S3FileSystem($uploadFilesToS3Key, $uploadFilesToS3Secret);
            $s3FileSys->deleteObject($s3Bucket, $uploadname);
        } else {
            LogManager::getInstance()->info("Delete:".BaseService::getInstance()->getDataDirectory().$file->filename);
            unlink(BaseService::getInstance()->getDataDirectory().$file->filename);
        }
    }

    public function deleteFileByField($value, $field)
    {
        LogManager::getInstance()->info("Delete file by field: $field / value: $value");
        $file = new File();
        $file->Load("$field = ?", array($value));
        if ($file->$field == $value) {
            $ok = $file->Delete();
            if ($ok) {
                $uploadFilesToS3 = SettingsManager::getInstance()->getSetting("Files: Upload Files to S3");

                if ($uploadFilesToS3 == "1") {
                    $uploadFilesToS3Key = SettingsManager::getInstance()->getSetting(
                        "Files: Amazon S3 Key for File Upload"
                    );
                    $uploadFilesToS3Secret = SettingsManager::getInstance()->getSetting(
                        "Files: Amazon S3 Secret for File Upload"
                    );
                    $s3Bucket = SettingsManager::getInstance()->getSetting("Files: S3 Bucket");

                    $uploadname = CLIENT_NAME."/".$file->filename;
                    LogManager::getInstance()->info("Delete from S3:".$uploadname);

                    $s3FileSys = new S3FileSystem($uploadFilesToS3Key, $uploadFilesToS3Secret);
                    $s3FileSys->deleteObject($s3Bucket, $uploadname);
                } else {
                    LogManager::getInstance()->info(
                        "Delete:".BaseService::getInstance()->getDataDirectory().$file->filename
                    );
                    unlink(BaseService::getInstance()->getDataDirectory().$file->filename);
                }
            } else {
                return false;
            }
        }
        return true;
    }

    public function getFileData($name)
    {
        $file = new File();
        $file->Load("name = ?", array($name));
        if (!empty($file->id)) {
            $arr = explode(".", $file->filename);
            $file->type = $arr[count($arr) - 1];
        } else {
            return null;
        }
        return $file;
    }

    public function getReadableSize($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'K', 'M', 'G', 'T');

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }

    public function generateProfileImage($first, $last)
    {
        $seed = substr($first, 0, 1);
        if (empty($last)) {
            $seed .= utf8_encode(substr($first, -1));
        } else {
            $seed .= utf8_encode(substr($last, 0, 1));
        }
        // TODO - remove code after chinese character issue is resolved
        //        if(strlen($seed) != mb_strlen($seed, 'utf-8')) {
        //            $char1 = substr($first, 0, 1);
        //            $char1 = chr($this->uniord($char1) % 26 + 65);
        //            if (empty($last)) {
        //                $char2 = substr($first, -1);
        //            } else {
        //                $char2 = substr($last, 0, 1);
        //            }
        //            $char2 = chr($this->uniord($char2) % 26 + 65);
        //            $seed = $char1.$char2;
        //        }

        $seed = substr($first, 0, 1);
        $seed .= substr($last, 0, 1);
        $seed .= md5($first.$last);

        $seed = utf8_encode($seed);

        return sprintf(
            'https://api.dicebear.com/7.x/initials/svg?seed=%s',
            $seed
        );
    }

    /**
     * @param $localFile
     * @param $fileName
     * @param $extension
     * @param bool       $unique
     * @param $employeeId
     * @return File
     */
    public function saveFile($fileName, $extension, bool $unique, $fileGroup, $employeeId = null)
    {
        $localFile = BaseService::getInstance()->getDataDirectory().$fileName.'.'.$extension;
        $uploadFilesToS3 = SettingsManager::getInstance()->getSetting("Files: Upload Files to S3");
        $uploadFilesToS3Key = SettingsManager::getInstance()->getSetting("Files: Amazon S3 Key for File Upload");
        $uploadFilesToS3Secret = SettingsManager::getInstance()->getSetting(
            "Files: Amazon S3 Secret for File Upload"
        );
        $s3Bucket = SettingsManager::getInstance()->getSetting("Files: S3 Bucket");
        $s3WebUrl = SettingsManager::getInstance()->getSetting("Files: S3 Web Url");

        $f_size = filesize($localFile);
        if ($uploadFilesToS3 . '' == '1' && !empty($uploadFilesToS3Key) && !empty($uploadFilesToS3Secret)
            && !empty($s3Bucket) && !empty($s3WebUrl)
        ) {
            $uploadname = CLIENT_NAME . "/" . $fileName . '.' . $extension;


            $s3FileSys = new \Classes\S3FileSystem($uploadFilesToS3Key, $uploadFilesToS3Secret);
            $res = $s3FileSys->putObject($s3Bucket, $uploadname, $localFile, 'authenticated-read');
            ;
            LogManager::getInstance()->info("Response from s3 file sys:" . print_r($res, true));
            unlink($localFile);
        }

        $file = new \Model\File();
        if ($unique && !empty($employeeId)) {
            $file->Load("name = ? and employee = ?", [$fileName, $employeeId]);
        }

        $file->name = $fileName;
        $file->filename = $fileName . '.' . $extension;
        $file->employee = $employeeId;
        $file->file_group = 'EmployeeDocument';
        $file->file_group = $fileGroup;
        $file->size = $f_size;
        $file->size_text = $this->getReadableSize($f_size);
        $file->Save();

        return $file;
    }

    private function uniord($u)
    {
        $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
        $k1 = ord(substr($k, 0, 1));
        $k2 = ord(substr($k, 1, 1));
        return $k2 * 256 + $k1;
    }
}
