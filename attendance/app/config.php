<?php
ini_set('error_log', 'data/icehrm.log');

define('APP_NAME', 'Ice Hrm');
define('FB_URL', 'Ice Hrm');
define('TWITTER_URL', 'Ice Hrm');

define('CLIENT_NAME', 'app');
define('APP_BASE_PATH', '/home/delzone/public_html/attendemce/core/');
define('CLIENT_BASE_PATH', '/home/delzone/public_html/attendemce/app/');
define('BASE_URL','https://delzone.in/attendemce/web/');
define('CLIENT_BASE_URL','https://delzone.in/attendemce/app/');

define('APP_DB', 'delzone_iceh180');
define('APP_USERNAME', 'delzone_iceh180');
define('APP_PASSWORD', 'S3@7RS!!P@99)up1');
define('APP_HOST', 'localhost');
define('APP_CON_STR', 'mysqli://'.APP_USERNAME.':'.APP_PASSWORD.'@'.APP_HOST.'/'.APP_DB);

//file upload
define('FILE_TYPES', 'jpg,png,jpeg');
define('MAX_FILE_SIZE_KB', 10 * 1024);
