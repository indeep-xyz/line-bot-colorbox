<?php

require_once('../private/commons.php');
require_once(__CLASS_ROOT__ . '/line-agent/reception.php');

try {
  $jsonSource = file_get_contents("php://input");
  $reception = new \LineAgent\Reception($jsonSource);
  $replier = $reception->getReplier();

  // file_put_contents("log", "jsonSource" . $jsonSource . "\n", FILE_APPEND);

  if ($replier === null) {
    $reception = new \LineAgent\Reception(file_get_contents(__EXAMPLE_ROOT__ . '/text-message-en'));
    $replier = $reception->getReplier();
    $replier->setDryRun(true);
  }

  if ($replier->hasReplyToken()) {
    $replier->send();
  }
  else {
    $replier->printBody();
  }

} catch (Exception $e) {
  // file_put_contents("log", $e->getTraceAsString() . "\n", FILE_APPEND);
}
