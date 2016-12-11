<?php

define('__PRIVATE_ROOT__', dirname(__FILE__));
define('__CLASS_ROOT__', __PRIVATE_ROOT__ . '/class');
define('__EXAMPLE_ROOT__', __PRIVATE_ROOT__ . '/example');

require_once(__PRIVATE_ROOT__ . '/lib/log4php/Logger.php');
require_once(__PRIVATE_ROOT__ . '/config.php');
require_once(__PRIVATE_ROOT__ . '/lib/MyLocalLogger/Configure.php');
require_once(__PRIVATE_ROOT__ . '/lib/MyLocalLogger/Write.php');

date_default_timezone_set('Asia/Tokyo');
mb_internal_encoding("UTF-8");

\MyLocalLogger\Configure::setLogDir(dirname(__FILE__) . '/log');

if (!file_exists(dirname(__FILE__) . '/DEBUG_MODE')) {
  \MyLocalLogger\Configure::setMockNames(['debug' , 'journal']);
}
