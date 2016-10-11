<?php

namespace LineAgent\Send;

/**
 * The class is to send a message.
 *
 * @author  indeep-xyz
 * @package LineAgent\Send
 * @version 0.1.0
 */
abstract class Sender {

  const LINE_API_URL = 'https://trialbot-api.line.me/v1/events';
  const LINE_TO_CHANNEL = 1383378250;
  const LINE_EVENT_TYPE = '138311608800106203';

  /**
   * [
   *    channelId:
   *    channelSecret:
   *    mid:
   * ]
   * @var [mixed[]] The parameters for authentification.
   */
  private $auth;

  function __construct($auth) {
    $this->auth = $auth;
  }

  private function validateAuthHash($auth) {
    $requirements = [
        'channelId',
        'channelSecret',
        'mid',
    ];

    foreach ($requirements as $key) {
      if (!array_key_exists($key, $auth)) {
        exit;
      }
    }

    $this->auth = $auth;
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
        'Content-Type: application/json; charser=UTF-8',
        'X-Line-ChannelID: '             . $this->auth['channelId'],
        'X-Line-ChannelSecret: '         . $this->auth['channelSecret'],
        'X-Line-Trusted-User-With-ACL: ' . $this->auth['mid'],
    );
  }

  public function createPostBodyTemplate($to) {
    return [
        'to' => [$to],
        'toChannel' => self::LINE_TO_CHANNEL,
        'eventType' => self::LINE_EVENT_TYPE,
        'content' => [
            'contentType' => 1,
            'toType' => 1,
            'text' => null,
        ],
    ];
  }

  // abstract public function send();
  // abstract public function createPostBody();
}