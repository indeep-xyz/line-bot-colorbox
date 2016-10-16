<?php

namespace LineAgent\Send;

require_once(dirname(__FILE__) . '/sender.php');

/**
 * The class sends an error message.
 *
 * @author  indeep-xyz
 * @package LineAgent\Send
 * @version 0.1.0
 */
class ErrorSender extends Sender {

  function __construct($auth) {
    parent::__construct($auth);
  }

  public function send($to, $colorPhrase) {
    $body = $this->createPostBody($to, $colorPhrase);
    $this->sendByCurl($body);
  }

  public function createPostBody($to, $colorPhrase) {
    $text = $this->createPostText($colorPhrase);
    $body = $this->createPostBodyTemplate($to);

    $body['content']['contentType'] = 1;
    $body['content']['text'] = $text;

    return $body;
  }

  /**
   * Create an error message.
   *
   * @param  [string] $colorPhrase - Text which expresses a color
   * @return [string] Return an error message
   */
  private function createPostText($colorPhrase) {
    return $colorPhrase . ' は無効なカラーコードです';
  }

}