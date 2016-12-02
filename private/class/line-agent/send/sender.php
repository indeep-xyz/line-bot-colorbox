<?php

namespace LineAgent\Send;

/**
 * The class is to send a message.
 *
 * @author  indeep-xyz
 * @package LineAgent\Send
 * @version 0.2.1
 */
abstract class Sender {

  /**
   * The URL to LINE server.
   * @var [string]
   */
  const LINE_API_URL = 'https://api.line.me/v2/bot/message/reply';

  /**
   * The authentication to connect to LINE server.
   * @var [string]
   */
  private $accessToken;

  /**
   * Dry-run mode when it is truthy.
   * @var [bool]
   */
  protected $dryRun;

  /**
   * Options to run.
   * @var [mixed]
   * @var [string] $options['accessToken'] - The authentication to connect to LINE server
   * @var [string] $options['urlColorBox'] - The URL to return an image as a box
   * @var [string] $options['dryRun'] - Dry-run mode when it is truthy
   */
  protected $options;

  /**
   * Constructor.
   * @param [mixed] $options - Options to run
   */
  function __construct(array &$options) {
    $this->setAccessToken($options);
    $this->setDryRun($options);
  }

  /**
   * Set a member variable "accessToken".
   * @param [mixed] &$options - Options expected to include the item "accessToken".
   */
  private function setAccessToken(array &$options) {
    $key = 'accessToken';

    if (array_key_exists($key, $options)) {
      $this->$key = $options[$key];
      unset($options[$key]);
    }
    else {
      throw new InvalidArgumentException(
          'Require an access token to connect to LINE server.');
    }
  }

  /**
   * Set a member variable "dryRun".
   * @param [mixed] &$options - Options expected to include the item "dryRun".
   */
  private function setDryRun(array &$options) {
    $key = 'dryRun';

    if (array_key_exists($key, $options)) {
      $this->$key = $options[$key];
      unset($options[$key]);
    }
  }

  /**
   * Send a message by cURL.
   * @param  [mixed] $body - The body of POST
   */
  protected function sendByCurl(array $body) {
    $ch = curl_init(self::LINE_API_URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $this->createHttpHeader());
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));

    $result = curl_exec($ch);
    curl_close($ch);
  }

  /**
   * Create the header of HTTP.
   * @return [mixed<string>] The source of the header of HTTP
   */
  private function createHttpHeader() {
    return array(
        'Content-Type:application/json',
        'Authorization: Bearer ' . $this->accessToken,
    );
  }

  /**
   * Create a template for the body of POST.
   * @param [string] $replyToken - The destination of the message
   * @return [mixed] A template for the body of POST
   */
  protected function createPostBodyTemplate($replyToken) {
    return [
        'replyToken' => $replyToken,
        'messages' => [],
    ];
  }

  /**
   * Add data to the message section of POST.
   * @param [mixed] &$body - The body section of POST
   * @param [undefined] $item - Additional data into the body
   */
  protected function addMessage(array &$body, $item) {
    array_push($body['messages'], $item);
  }

  /**
   * Print the body section of POST.
   * This method runs when an instance is in dry-run mode.
   * @param  [mixed] $body - The body section of POST
   */
  protected function printPostBody(array $body) {
    echo json_encode($body);
  }
}