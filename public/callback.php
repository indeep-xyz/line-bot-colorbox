<?php

require_once('../private/commons.php');
require_once(__CLASS_ROOT__ . '/line-agent/reception.php');

$agent = new \LineAgent\Reception(file_get_contents("php://input"));
$replier = $agent->getReplier();

if ($replier === null) {
  $agent = new \LineAgent\Reception(file_get_contents(__EXAMPLE_ROOT__ . '/text-message-en'));
  $replier = $agent->getReplier();
  $replier->setDryRun(true);
}

if ($replier->hasFrom()) {
  $replier->send();
}
else {
  $replier->printBody();
}
