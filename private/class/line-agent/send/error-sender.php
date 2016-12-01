<?php

namespace LineAgent\Send;

require_once(dirname(__FILE__) . '/sender.php');

/**
 * The class sends an error message.
 *
 * @author  indeep-xyz
 * @package LineAgent\Send
 * @version 0.2.0
 */
class ErrorSender extends Sender {

  function __construct($auth) {
    parent::__construct($auth);
  }

  public function send($replyToken, $colorPhrase) {
    $body = $this->createPostBody($replyToken, $colorPhrase);
    $this->sendByCurl($body);
  }

  public function createPostBody($replyToken, $colorPhrase) {
    $body = $this->createPostBodyTemplate($replyToken);
    $this->addMessage($body, $colorPhrase);

    return $body;
  }

  private function addMessage(&$body, $colorPhrase) {
    $errorMessage = $this->createPostText($colorPhrase);

    array_push($body['messages'], [
        'type' => 'text',
        'text' => $errorMessage,
        ]
    );
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