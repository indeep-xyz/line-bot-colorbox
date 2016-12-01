<?php

namespace LineAgent\Send;

require_once(dirname(__FILE__) . '/sender.php');

/**
 * The class sends a message with an image.
 *
 * @author  indeep-xyz
 * @package LineAgent\Send
 * @version 0.2.0
 */
class MessageSender extends Sender {

  private $url;

  function __construct($auth, $url) {
    parent::__construct($auth);
    $this->url = $url;
  }

  public function send($replyToken, $colorManager) {
    $body = $this->createPostBody($replyToken, $colorManager);
    $this->sendByCurl($body);
  }

  public function createPostBody($replyToken, $colorManager) {
    $body = $this->createPostBodyTemplate($replyToken);
    $this->addMessage($body, $colorManager);

    return $body;
  }

  private function addMessage(&$body, $colorManager) {
    $imageUrl = $this->createImageUrl($colorManager);

    array_push($body['messages'], [
        'type' => 'image',
        'originalContentUrl' => $imageUrl,
        'previewImageUrl' => $imageUrl,
        ]
    );
  }

  private function createImageUrl($colorManager) {
    $colorPhrase = urlencode($colorManager->getColorAsString());
    return $this->url . '?color=' . $colorPhrase;
  }

}