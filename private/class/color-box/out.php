<?php

namespace ColorBox;

require_once(dirname(__FILE__) . '/color-manager.php');

/**
 * This class outputs a color box.
 *
 * @version  0.0.2
 * @author   indeep-xyz
 * @package  ColorBox
 */
class Out {
  const SIZE = 120;
  const FILE_TYPE = 'png';
  const CONTENT_TYPE = 'Content-type: image/png';

  /**
   * An image as a box.
   * @var [Imagick]
   */
  private $box;

  /**
   * The color for drawing box.
   * @var [ImagickPixel]
   */
  private $color;

  function __construct($color) {
    \MyLocalLogger\Write::journal('IN');

    $this->color = $color;
    $this->initBox();

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Initialize an image which an instance has.
   */
  private function initBox() {
    \MyLocalLogger\Write::journal('IN');

    $box = new \Imagick();
    $box->newImage(self::SIZE, self::SIZE, $this->color);
    $box->setImageFormat(self::FILE_TYPE);

    $this->box = $box;

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Output an image which an instance has.
   */
  public function output() {
    \MyLocalLogger\Write::journal('IN');

    header(self::CONTENT_TYPE);
    echo $this->box;

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Check $this->box has created correctly.
   */
  public function isOutputable() {
    return $this->box instanceof \Imagick;
  }
}

