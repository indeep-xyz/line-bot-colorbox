<?php

namespace LineAgent\Send;

require_once(dirname(__FILE__) . '/sender.php');
require_once(dirname(__FILE__) . '/sender-to-reply-impl.php');

/**
 * The class sends an error message.
 *
 * @author  indeep-xyz
 * @package LineAgent\Send
 * @version 0.2.1
 */
class ColorErrorSender
    extends Sender
    implements SenderToReplyImpl
    {

  /**
   * Constructor.
   * @param [mixed] $options - Options to run
   */
  function __construct(array $options) {
    parent::__construct($options);
  }

  /**
   * Depends on dry-run option,
   * Send a error message to LINE server
   * or print the body section of POST.
   * @param [string] $replyToken - The destination of the message
   * @param [ColorManager] $colorManager - Color data
   */
  public function run($replyToken, $colorManager) {
    $body = $this->createPostBody($replyToken, $colorManager);

    if ($this->dryRun) {
      $this->printPostBody($body);
    }
    else {
      $this->sendByCurl($body);
    }
  }

  /**
   * Create the body section of POST.
   * @param [string] $replyToken - The destination of the message
   * @param [ColorManager] $colorManager - Color data
   * @return [string] The body section of POST
   */
  public function createPostBody($replyToken, $colorManager) {
    $body = $this->createPostBodyTemplate($replyToken);
    $this->addMessage($body, $colorManager);

    return $body;
  }

  /**
   * Add data attached a message for color phrase error
   * to the message section of POST.
   * @param [array] &$body - The body section of POST
   * @param [ColorManager] $colorManager - Color data
   */
  protected function addMessage(array &$body, $colorManager) {
    $errorMessage = $this->createPostText($colorManager);

    parent::addMessage($body, [
        'type' => 'text',
        'text' => $errorMessage,
        ]
    );
  }

  /**
   * Send a error message to LINE server.
   * @param [string] $replyToken - The destination of the message
   * @param [ColorManager] $colorManager - Color data
   */
  private function send($replyToken, $colorManager) {
    $body = $this->createPostBody($replyToken, $colorManager);
    $this->sendByCurl($body);
  }

  /**
   * Create an error message.
   *
   * @param [ColorManager] $colorManager - Color data
   * @return [string] Return an error message
   */
  private function createPostText($colorManager) {
    return sprintf(
        '%s は無効なカラーコードです',
        $colorManager->getColorSource()
    );
  }

}