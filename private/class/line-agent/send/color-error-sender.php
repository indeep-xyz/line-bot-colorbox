<?php

namespace LineAgent\Send;

require_once(dirname(__FILE__) . '/sender.php');
require_once(dirname(__FILE__) . '/sender-to-reply-impl.php');

/**
 * The class sends an error message.
 *
 * @author  indeep-xyz
 * @package LineAgent\Send
 * @version 0.2.2
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
    \MyLocalLogger\Write::journal('IN');

    parent::__construct($options);

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Depends on dry-run option,
   * Send a error message to LINE server
   * or print the body section of POST.
   * @param [string] $replyToken - The destination of the message
   * @param [ColorManager] $colorManager - Color data
   */
  public function run($replyToken, $colorManager) {
    \MyLocalLogger\Write::journal('IN');

    $body = $this->createPostBody($replyToken, $colorManager);

    if ($this->dryRun) {
      $this->printPostBody($body);
    }
    else {
      $this->sendByCurl($body);
    }

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Create the body section of POST.
   * @param [string] $replyToken - The destination of the message
   * @param [ColorManager] $colorManager - Color data
   * @return [string] The body section of POST
   */
  public function createPostBody($replyToken, $colorManager) {
    \MyLocalLogger\Write::journal('IN');

    $body = $this->createPostBodyTemplate($replyToken);
    $this->addMessage($body, $colorManager);

    \MyLocalLogger\Write::journal('OUT');
    return $body;
  }

  /**
   * Add data attached a message for color phrase error
   * to the message section of POST.
   * @param [array] &$body - The body section of POST
   * @param [ColorManager] $colorManager - Color data
   */
  protected function addMessage(array &$body, $colorManager) {
    \MyLocalLogger\Write::journal('IN');

    $errorMessage = $this->createPostText($colorManager);

    parent::addMessage($body, [
        'type' => 'text',
        'text' => $errorMessage,
        ]
    );

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Send a error message to LINE server.
   * @param [string] $replyToken - The destination of the message
   * @param [ColorManager] $colorManager - Color data
   */
  private function send($replyToken, $colorManager) {
    \MyLocalLogger\Write::journal('IN');

    $body = $this->createPostBody($replyToken, $colorManager);
    $this->sendByCurl($body);

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Create an error message.
   *
   * @param [ColorManager] $colorManager - Color data
   * @return [string] Return an error message
   */
  private function createPostText($colorManager) {
    \MyLocalLogger\Write::journal('IN');

    $text = sprintf(
        '%s は無効なカラーコードです',
        $colorManager->getColorSource()
    );

    \MyLocalLogger\Write::journal('OUT');
    return $text;
  }

}