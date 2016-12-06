<?php

namespace ColorBox;

require_once(dirname(__FILE__) . '/color-manager.php');

/**
 * This class outputs an image data as a colored box.
 *
 * @version  0.0.2
 * @author   indeep-xyz
 * @package  ColorBox
 */
class Out {
  /**
   * Size of image data, width and height.
   */
  const SIZE = 120;

  /**
   * Format of image data.
   */
  const FILE_TYPE = 'png';

  /**
   * A content type when an instance outputs image data.
   */
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

  /**
   * Constructor.
   * @param [ImagickPixel] $color - Color data
   */
  function __construct($color) {
    \MyLocalLogger\Write::journal('IN');

    $this->color = $color;
    $this->initBox();

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Initialize image data from color data
   * kept by an instance of this.
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
   * Output image data kept by an instance of this.
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

