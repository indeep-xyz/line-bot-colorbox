<?php

require_once('../private/commons.php');
require_once(__CLASS_ROOT__ . '/line-agent/reception.php');

try {
  $jsonSource = file_get_contents("php://input");
  $options = [
    'accessToken' => __LINE_CHANNEL_ACCESS_TOKEN__,
    'urlColorBox' => __URL_COLOR_BOX__,
    'dryRun' => false,
  ];

  if (strlen($jsonSource) < 1) {
    $jsonSource = file_get_contents(__EXAMPLE_ROOT__ . '/text-message-en');
    $options['dryRun'] = true;
  }

  // file_put_contents("log", "jsonSource" . $jsonSource . "\n", FILE_APPEND);
  // echo $jsonSource;

  $reception = new \LineAgent\Reception($jsonSource, $options);
  $reception->runEvents();

} catch (Exception $e) {
  // file_put_contents("log", $e->getTraceAsString() . "\n", FILE_APPEND);
}
