<?php

define('__PRIVATE_ROOT__', dirname(__FILE__));
define('__CLASS_ROOT__', __PRIVATE_ROOT__ . '/class');
define('__EXAMPLE_ROOT__', __PRIVATE_ROOT__ . '/example');

require_once(__PRIVATE_ROOT__ . '/lib/log4php/Logger.php');
require_once(__PRIVATE_ROOT__ . '/config.php');

mb_internal_encoding("UTF-8");
