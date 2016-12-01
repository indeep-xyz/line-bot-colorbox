<?php

namespace LineAgent\Send;

/**
 * The class is to send a message.
 *
 * @author  indeep-xyz
 * @package LineAgent\Send
 * @version 0.2.0
 */
abstract class Sender {

  const LINE_API_URL = 'https://api.line.me/v2/bot/message/reply';

  /**
   * @var [string] The parameters for authentification.
   */
  private $accessToken;

  function __construct($accessToken) {
    $this->accessToken = $accessToken;
  }

  protected function sendByCurl($body) {
    $ch = curl_init(self::LINE_API_URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->createHeader());
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

    $result = curl_exec($ch);
    curl_close($ch);
  }

  private function createHeader() {
    return array(
        'Content-Type:application/json',
        'Authorization: Bearer ' . $this->accessToken,
    );
  }

  public function createPostBodyTemplate($replyToken) {
    return [
        'replyToken' => $replyToken,
        'messages' => [],
    ];
  }

  // abstract public function send();
  // abstract public function createPostBody();
}