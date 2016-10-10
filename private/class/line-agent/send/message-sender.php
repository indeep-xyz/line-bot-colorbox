<?php

namespace LineAgent\Send;

require_once(dirname(__FILE__) . '/sender.php');

/**
 * The class sends a message with an image.
 *
 * @author  indeep-xyz
 * @package LineAgent\Send
 * @version 0.1.0
 */
class MessageSender extends Sender {

  private $url;

  function __construct($auth, $url) {
    parent::__construct($auth);
    $this->url = $url;
  }

  public function send($to, $colorManager) {
    $body = $this->createPostBody($to, $colorManager);
    $this->sendByCurl($body);
  }

  public function createPostBody($to, $colorManager) {
    $body = $this->createPostBodyTemplate($to);

    $body['content']['contentType'] = 2;
    $body['content']['originalContentUrl'] = $this->createImageUrl($colorManager);
    $body['content']['previewImageUrl'] = $this->createImageUrl($colorManager);

    return $body;
  }

  private function createImageUrl($colorManager) {
    $colorPhrase = urlencode($colorManager->getColorAsString());
    return $this->url . '?color=' . $colorPhrase;
  }

}