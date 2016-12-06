<?php

require_once('../private/commons.php');
require_once(__CLASS_ROOT__ . '/line-agent/reception.php');

\MyLocalLogger\Write::journal('------ START (' . basename(__FILE__) . ') ------');

try {
  $jsonSource = file_get_contents("php://input");
  $options = [
    'accessToken' => __LINE_CHANNEL_ACCESS_TOKEN__,
    'urlColorBox' => __URL_COLOR_BOX__,
    'dryRun' => false,
  ];

  \MyLocalLogger\Write::input('Received Data', $jsonSource);

  if (strlen($jsonSource) < 1) {
    $jsonSource = file_get_contents(__EXAMPLE_ROOT__ . '/text-message-en');
    $options['dryRun'] = true;

    \MyLocalLogger\Write::input('Test Data', $jsonSource);
  }

  $reception = new \LineAgent\Reception($jsonSource, $options);
  $reception->runEvents();
}
catch (Exception $ex) {
  \MyLocalLogger\Write::error('Something error', $ex);
}

\MyLocalLogger\Write::journal('------ END (' . basename(__FILE__) . ') ------');
