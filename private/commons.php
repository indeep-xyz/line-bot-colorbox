<?php

define('__PRIVATE_ROOT__', dirname(__FILE__));
define('__CLASS_ROOT__', __PRIVATE_ROOT__ . '/class');
define('__EXAMPLE_ROOT__', __PRIVATE_ROOT__ . '/example');

require_once(__PRIVATE_ROOT__ . '/lib/log4php/Logger.php');
require_once(__PRIVATE_ROOT__ . '/config.php');
require_once(__PRIVATE_ROOT__ . '/lib/MyLocalLogger/Write.php');
require_once(__PRIVATE_ROOT__ . '/lib/MyLocalLogger/LoggerAgent.php');

date_default_timezone_set('Asia/Tokyo');
mb_internal_encoding("UTF-8");

\MyLocalLogger\LoggerAgent::setLogDir(dirname(__FILE__) . '/log');
