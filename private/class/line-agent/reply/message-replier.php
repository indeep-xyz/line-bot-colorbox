<?php

namespace LineAgent\Reply;

use \LineAgent\Send as Send;

require_once(dirname(__FILE__) . '/replier.php');
require_once(__CLASS_ROOT__ . '/color-box/color-manager.php');
require_once(dirname(__FILE__) . '/../send/error-sender.php');
require_once(dirname(__FILE__) . '/../send/message-sender.php');

/**
 * This class manages for the event type which is message.
 *
 * @author  indeep-xyz
 * @package LineAgent\Reply
 * @version 0.1.0
 */
class MessageReplier extends Replier {

  private $colorSource;
  private $color;

  /**
   * @var [string] The URL to return an image as a box
   */
  private $urlColorBox;

  /**
   * Constructor.
   * @param [mixed] $lineContent - The content section of the converted data from LINE server
   * @param [string] $urlColorBox - The URL to return an image as a box
   */
  function __construct($auth, $lineContent, $urlColorBox) {
    parent::__construct($auth, $lineContent);
    $this->urlColorBox = $urlColorBox;
  }

  /**
   * Create an instance of ColorManager and return it.
   * @return [ColorManager] An instance
   */
  private function createColorManager() {
    $colorSource = $this->lineContent->text;
    return new \ColorBox\ColorManager($colorSource);
  }

  /**
   * Send message to LINE server.
   */
  public function send() {
    if ($this->dryRun) {
      $this->printBody();
      return;
    }

    $colorManager = $this->createColorManager();

    if ($colorManager->isCreatedColor()) {
      $this->sendWithColorBox($colorManager);
    }
    else {
      $this->sendFailureMessage();
    }
  }

  /**
   * Check an instance has the address of sender.
   * @return [boolean] Returns true if an instance has it.
   */
  public function hasFrom() {
    return ($this->lineContent->from != null);
  }

  /**
   * Send message to LINE server with color data.
   * @param [ColorManager] colorManager - An instance
   */
  private function sendWithColorBox($colorManager) {
    $from = $this->lineContent->from;

    $sender = $this->createMessageSender();
    $sender->send($from, $colorManager);
  }

  /**
   * Send failure message to LINE server.
   */
  private function sendFailureMessage() {
    $to = $this->lineContent->from;
    $colorPhrase = $this->lineContent->text;

    $sender = $this->createErrorSender();
    $sender->send($to, $colorPhrase);
  }

  /**
   * Print the body of post at sending to LINE server.
   */
  public function printBody() {
    $colorManager = $this->createColorManager();

    if ($colorManager->isCreatedColor()) {
      $this->printBodyWithColorBox($colorManager);
    }
    else {
      $this->printBodyFailureMessage();
    }
  }

  /**
   * Print the body of post with color data
   * at sending to LINE server.
   * @param [ColorManager] colorManager - An instance
   */
  private function printBodyWithColorBox($colorManager) {
    $to = $this->lineContent->from;

    $sender = $this->createMessageSender();
    $postBody = $sender->createPostBody($to, $colorManager);

    echo json_encode($postBody);
  }

  /**
   * Print the body of post at sending to LINE server
   * when error occurred.
   */
  private function printBodyFailureMessage() {
    $to = $this->lineContent->from;
    $colorPhrase = $this->lineContent->text;

    $sender = $this->createErrorSender();
    $postBody = $sender->createPostBody($to, $colorPhrase);

    echo json_encode($postBody);
  }

  private function createErrorSender() {
    return new Send\ErrorSender($this->auth);
  }

  private function createMessageSender() {
    return new Send\MessageSender($this->auth, $this->urlColorBox);
  }

}