<?php

namespace ColorBox;

require_once(dirname(__FILE__) . '/phrase-optimizer.php');

/**
 * This class keeps color data.
 *
 * @version  0.0.2
 * @author   indeep-xyz
 * @package  ColorBox
 */
class ColorManager {

  /**
   * The color data, ImagickPixel or null.
   * @var [ImagickPixel] Set it when the instance is created successfully
   * @var [null] Set it when the instance creation is failed
   */
  private $color;

  /**
   * @var [string] The source of color data
   */
  private $colorSource;

  /**
   * Construct.
   * @param [string] $colorSource - A color code
   */
  function __construct($colorSource) {
    \MyLocalLogger\Write::journal('IN');
    \MyLocalLogger\Write::input('Color Source', $colorSource);

    $this->colorSource = $colorSource;
    $this->initColor();

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Initialize $this->color.
   *
   * Set an instance of ImagickPixel to it
   * when the instance is created successfully.
   *
   * Set null to it
   * when the instance creation is failed.
   */
  private function initColor() {
    \MyLocalLogger\Write::journal('IN');

    $this->color = $this->createPixel($this->colorSource);

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Create an instance of ImagickPixel from a color code.
   * @param  [string] $colorSource - A color code
   * @return [ImagickPixel] Returns an instance
   * @return [null] Returns null if a class can not optimize the argument
   */
  private function createPixel($colorSource) {
    \MyLocalLogger\Write::journal('IN');

    $phraseOptimizer = new PhraseOptimizer($colorSource);
    $colorPhrase = $phraseOptimizer->fromQueryString();
    $color = null;

    if ($colorPhrase != '') {
      try {
        $color = new \ImagickPixel($colorPhrase);;
        \MyLocalLogger\Write::debug(
            sprintf(
                'Create a color %s from a color source "%s"',
                $color->getColorAsString(),
                $colorSource
            )
        );
      }
      catch (\ImagickPixelException $ex) {
        \MyLocalLogger\Write::debug(
            sprintf(
                'Failed to create from a color source "%s"',
                $colorSource
            )
        );
      }
    }

    \MyLocalLogger\Write::journal('OUT');
    return $color;
  }

  /**
   * Return $this->color.
   * @return [ImagickPixel]
   */
  public function getColor() {
    return $this->color;
  }

  /**
   * Return the color as string of $this->color.
   * @return [string] Returns string if $this->color is created successfully
   * @return [null] Returns null if $this->color is not created
   */
  public function getColorAsString() {
    \MyLocalLogger\Write::journal('IN');

    $colorAsString = null;

    if ($this->isCreatedColor()) {
      $colorAsString = $this->color->getColorAsString();
    }

    \MyLocalLogger\Write::journal('OUT');
    return $colorAsString;
  }

  /**
   * Return $this->colorSource.
   * @return [ImagickPixel]
   */
  public function getColorSource() {
    return $this->colorSource;
  }

  /**
   * Check $this->color is created successfully.
   * @return [boolean] Returns true if $this->color is created successfully
   */
  public function isCreatedColor() {
    return $this->color instanceof \ImagickPixel;
  }
}