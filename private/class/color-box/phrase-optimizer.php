<?php

namespace ColorBox;

/**
 * This class supports to optimize a phrase for color code.
 *
 * @version  0.0.2
 * @author   indeep-xyz
 * @package  ColorBox
 */
class PhraseOptimizer {

  /**
   * @var [string] The source for optimization.
   */
  private $source;

  /**
   * Constructor.
   * @param [string] $source - The source for optimization
   */
  function __construct($source) {
    \MyLocalLogger\Write::journal('IN');

    $this->source = $this->removeWhiteSpace($source);

    \MyLocalLogger\Write::journal('OUT');
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
    \MyLocalLogger\Write::journal('IN');

    $source = $this->source;
    $source = urldecode($source);
    $source = $this->convertToHexColor($source);

    \MyLocalLogger\Write::journal('OUT');
    return $source;
  }

  /**
   * Convert hex string to hex color code.
   * @param  [string] $source - It has only hex string
   * @return [string] Returns hex color code if the argument is convertible
   * @return [string] Returns the argument as it is
   */
  private function convertToHexColor($source) {
    \MyLocalLogger\Write::journal('IN');

    if ($this->checkHexString($source, 3) ||
        $this->checkHexString($source, 6)
        ) {
      $source = '#' . $source;
    }

    \MyLocalLogger\Write::journal('OUT');
    return $source;
  }

  /**
   * Check the argument is hex and is a correct length.
   * @param  [string] $source - Hex string
   * @param  [string] $length - The length of $source
   * @return [boolean] Returns true if $source is hex and has the same length as $length
   */
  private function checkHexString($source, $length) {
    \MyLocalLogger\Write::journal('IN');

    $pattern = '/^[0-9a-f]{' . $length . '}$/i';
    $hexString = (preg_match($pattern, $source) != 0);

    \MyLocalLogger\Write::journal('OUT');
    return $hexString;
  }
}