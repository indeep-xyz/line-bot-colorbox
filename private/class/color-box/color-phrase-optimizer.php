<?php

namespace ColorBox;

class ColorPhraseOptimizer {

  /**
   * @var [string] The source for optimization.
   */
  private $source;

  /**
   * Constructor.
   * @param [string] $source - The source for optimization
   */
  function __construct($source) {
    $this->source = $this->removeWhiteSpace($source);
  }

  /**
   * Remove white spaces from the argument.
   * @param  [string] $source - String for removing white spaces
   * @return [string] Returns string removed with white spaces by this method
   */
  private function removeWhiteSpace($source) {
    return preg_replace('/[\s\t\n]/', '', $source);
  }

  /**
   * Convert $this->source optimized for query string
   * and return it.
   * @return [string] Returns the optimized string
   */
  public function fromQueryString() {
    $source = $this->source;
    $source = urldecode($source);
    $source = $this->convertToHexColor($source);

    return $source;
  }

  /**
   * Convert hex string to hex color code.
   * @param  [string] $source - It has only hex string
   * @return [string] Returns hex color code if the argument is convertible
   * @return [string] Returns the argument as it is
   */
  private function convertToHexColor($source) {
    if ($this->checkHexString($source, 3) ||
        $this->checkHexString($source, 6)
        ) {
      $source = '#' . $source;
    }

    return $source;
  }

  /**
   * Check the argument is hex and is a correct length.
   * @param  [string] $source - Hex string
   * @param  [string] $length - The length of $source
   * @return [boolean] Returns true if $source is hex and has the same length as $length
   */
  private function checkHexString($source, $length) {
    $pattern = '/^[0-9a-f]{' . $length . '}$/i';

    return (preg_match($pattern, $source) != 0);
  }
}