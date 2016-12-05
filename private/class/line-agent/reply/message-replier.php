<?php

namespace LineAgent\Reply;

use \LineAgent\Send as Send;

require_once(dirname(__FILE__) . '/replier.php');
require_once(__CLASS_ROOT__ . '/color-box/color-manager.php');
require_once(dirname(__FILE__) . '/../send/color-error-sender.php');
require_once(dirname(__FILE__) . '/../send/color-box-sender.php');

/**
 * This class manages for the event type which is message.
 *
 * @author  indeep-xyz
 * @package LineAgent\Reply
 * @version 0.2.1
 */
class MessageReplier
    extends Replier
    {

  /**
   * Constructor.
   * @param [mixed] $eventData - The events section of the data from LINE server
   * @param [mixed] $options - Options to run
   */
  function __construct($eventData, $options) {
    \MyLocalLogger\Write::journal('IN');

    parent::__construct($eventData, $options);

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Reply message to LINE server.
   */
  public function reply() {
    \MyLocalLogger\Write::journal('IN');

    $colorManager = $this->createColorManager();

    if ($colorManager->isCreatedColor()) {
      $this->sendWithColorBox($colorManager);
    }
    else {
      $this->sendFailureMessage($colorManager);
    }

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Create an instance of ColorManager and return it.
   * @return [ColorManager] An instance
   */
  private function createColorManager() {
    \MyLocalLogger\Write::journal('IN');

    $colorSource = $this->eventData->message->text;
    $colorManager = new \ColorBox\ColorManager($colorSource);

    \MyLocalLogger\Write::journal('OUT');
    return $colorManager;
  }

  /**
   * Send message to LINE server with color data.
   * @param [ColorManager] colorManager - An instance
   */
  private function sendWithColorBox($colorManager) {
    \MyLocalLogger\Write::journal('IN');

    $replyToken = $this->eventData->replyToken;

    $sender = new Send\ColorBoxSender($this->options);
    $sender->run($replyToken, $colorManager);

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Send failure message to LINE server.
   * @param [ColorManager] colorManager - An instance
   */
  private function sendFailureMessage($colorManager) {
    \MyLocalLogger\Write::journal('IN');

    $replyToken = $this->eventData->replyToken;

    $sender = new Send\ColorErrorSender($this->options);
    $sender->run($replyToken, $colorManager);

    \MyLocalLogger\Write::journal('OUT');
  }
}