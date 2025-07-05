<?php

use Classes\Common\IceContainer;
use Classes\LanguageManager;
use Utils\InputCleaner;

ini_set('display_errors', false);
error_reporting(E_ERROR);
require dirname(__FILE__).'/lib/composer/vendor/autoload.php';

//$whoops = new \Whoops\Run;
//$whoops->pushHandler(new \Whoops\Handler\PlainTextHandler);
//$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
//$whoops->register();

$container = new IceContainer();

function t($text)
{
	return LanguageManager::translateTnrText($text);
}

if(!defined('TAGS_TO_PRESERVE')){define('TAGS_TO_PRESERVE', '<b><i><span>');}
$jsVersion = defined('CACHE_VALUE')?CACHE_VALUE:"v".VERSION;
$cssVersion = defined('CACHE_VALUE')?CACHE_VALUE:"v".VERSION;

$_REQUEST = InputCleaner::cleanParameters($_REQUEST);
$_GET = InputCleaner::cleanParameters($_GET);
$_POST = InputCleaner::cleanParameters($_POST);

date_default_timezone_set('Asia/Colombo');
//Find timezone diff with GMT
$dateTimeZoneColombo = new DateTimeZone("Asia/Colombo");
$dateTimeColombo = new DateTime("now", $dateTimeZoneColombo);
$dateTimeColomboStr = $dateTimeColombo->format("Y-m-d H:i:s");
$dateTimeNow = date("Y-m-d H:i:s");

$diffHoursBetweenServerTimezoneWithGMT = (strtotime($dateTimeNow) - (strtotime($dateTimeColomboStr) - 5.5*60*60))/(60*60);
