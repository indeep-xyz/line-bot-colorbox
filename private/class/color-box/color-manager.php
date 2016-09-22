<?php

namespace ColorBox;

require_once(dirname(__FILE__) . '/color-phrase-optimizer.php');

class ColorManager {

  /**
   * The color data, ImagickPixel or null.
   * @var [ImagickPixel] Set it when the instance is created successfully
   * @var [null] Set it when the instance creation is failed
   */
  private $color;

  /**
   * The source of color data.
   * @var [string] $colorSource - A color code
   */
  private $colorSource;

  /**
   * Construct.
   * @param [string] $colorSource - A color code
   */
  function __construct($colorSource) {
    $this->colorSource = $colorSource;
    $this->initColor();
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
    $color = null;

    try {
      $color = $this->createPixel($this->colorSource);
    }
    catch (ImagickPixelException $ex) {
      ;
    }

    $this->color = $color;
  }

  /**
   * Create an instance of ImagickPixel from a color code.
   * @param  [string] $colorSource - A color code
   * @return [ImagickPixel] Returns an instance
   * @return [null] Returns null if a class can not optimize the argument
   */
  private function createPixel($colorSource) {
    $phraseOptimizer = new ColorPhraseOptimizer($colorSource);
    $colorPhrase = $phraseOptimizer->fromQueryString();
    $color = null;

    if ($colorPhrase != '') {
      $color = new \ImagickPixel($colorPhrase);
    }

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
    if ($this->isCreatedColor()) {
      return $this->color->getColorAsString();
    }

    return null;
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