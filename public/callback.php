<?php

require_once('../private/commons.php');
require_once(__CLASS_ROOT__ . '/line-agent/reception.php');

$jsonSource = file_get_contents("php://input");
$reception = new \LineAgent\Reception($jsonSource);
$replier = $reception->getReplier();

if ($replier === null) {
  $reception = new \LineAgent\Reception(file_get_contents(__EXAMPLE_ROOT__ . '/text-message-en'));
  $replier = $reception->getReplier();
  $replier->setDryRun(true);
}

if ($replier->hasFrom()) {
  $replier->send();
}
else {
  $replier->printBody();
}
