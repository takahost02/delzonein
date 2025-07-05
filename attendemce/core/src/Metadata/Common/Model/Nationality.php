<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 3:03 PM
 */

namespace Metadata\Common\Model;

use Classes\ModuleAccess;
use Classes\SettingsManager;
use Model\BaseModel;

class Nationality extends BaseModel
{
    public $table = 'Nationality';

    public function getAdminAccess()
    {
        return array("get","element","save","delete");
    }

    public function getAnonymousAccess()
    {
        return array("get","element");
    }

    public function getFieldMappingFinder()
    {
        return new class extends Nationality {
            // @codingStandardsIgnoreStart
            public function Find($whereOrderBy, $bindarr = false, $cache = false, $pkeysArr = false, $extra = array())
            {
                $allowedCountriesStr = SettingsManager::getInstance()->getSetting('System: Allowed Nationality');
                $allowedCountries = array();
                if (!empty($allowedCountriesStr)) {
                    $allowedCountries = json_decode($allowedCountriesStr, true);
                }

                if (!empty($allowedCountries)) {
                    $res = parent::Find("id in (".implode(",", $allowedCountries).")", array());
                    if (empty($res)) {
                        SettingsManager::getInstance()->setSetting('System: Allowed Nationality', '');
                    } else {
                        return $res;
                    }
                }

                return parent::Find($whereOrderBy, $bindarr, $pkeysArr, $extra);
            }
            // @codingStandardsIgnoreEnd
        };
    }

    public function getModuleAccess()
    {
        return [
            new ModuleAccess('metadata', 'admin'),
        ];
    }
}
