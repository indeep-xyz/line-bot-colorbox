<?php

require_once('../private/commons.php');
require_once(__CLASS_ROOT__ . '/color-box/out.php');

\MyLocalLogger\Write::journal('------ START ------');

try {
  $colorSource = $_GET['color'];
  $colorManager = new \ColorBox\ColorManager($colorSource);

  if ($colorManager->isCreatedColor()) {
    $color = $colorManager->getColor();

    $box = new \ColorBox\Out($color);
    $box->output();
  }
}
catch (Exception $ex) {
  \MyLocalLogger\Write::error('Something error', $ex);
}

\MyLocalLogger\Write::journal('------- END -------');
