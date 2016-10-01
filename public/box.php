<?php

require_once('../private/commons.php');
require_once(__CLASS_ROOT__ . '/color-box/out.php');

$colorSource = $_GET['color'];
$colorManager = new \ColorBox\ColorManager($colorSource);

if ($colorManager->isCreatedColor()) {
  $color = $colorManager->getColor();

  $box = new \ColorBox\Out($color);
  $box->output();
}
