<?php

namespace ColorBox;

require_once(dirname(__FILE__) . '/color-manager.php');

/**
 * This class outputs a color box.
 *
 * @version  0.0.1
 * @author   indeep-xyz
 * @package  ColorBox
 */
class Out {
  const SIZE = 120;
  const FILE_TYPE = 'png';
  const CONTENT_TYPE = 'Content-type: image/png';

  /**
   * The image data
   * @var [Imagick]
   */
  private $box;

  /**
   * The color for drawing box.
   * @var [ImagickPixel]
   */
  private $color;

  function __construct($color) {
    $this->color = $color;
    $this->initBox();
  }

  private function initBox() {
    $box = new \Imagick();
    $box->newImage(self::SIZE, self::SIZE, $this->color);
    $box->setImageFormat(self::FILE_TYPE);

    $this->box = $box;
  }

  public function output() {
    header(self::CONTENT_TYPE);
    echo $this->box;
  }

  public function isOutputable() {
    return $this->box instanceof \Imagick;
  }
}

