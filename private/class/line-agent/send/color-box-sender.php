<?php

namespace LineAgent\Send;

require_once(dirname(__FILE__) . '/sender.php');
require_once(dirname(__FILE__) . '/sender-to-reply-impl.php');

/**
 * The class sends a message with an image.
 *
 * @author  indeep-xyz
 * @package LineAgent\Send
 * @version 0.2.1
 */
class ColorBoxSender
    extends Sender
    implements SenderToReplyImpl
    {

  /**
   * The URL which returns a colored box image.
   * @var [string]
   */
  private $urlColorBox;

  /**
   * Constructor.
   * @param [mixed] $options - Options to run
   */
  function __construct(array $options) {
    \MyLocalLogger\Write::journal('IN');

    parent::__construct($options);
    $this->setUrlColorBox($options);

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Set a member variable "urlColorBox".
   * @param [mixed] &$options - Options expected to include the item "urlColorBox".
   */
  private function setUrlColorBox(array &$options) {
    \MyLocalLogger\Write::journal('IN');

    $key = 'urlColorBox';

    if (array_key_exists($key, $options)) {
      $this->$key = $options[$key];
      unset($options[$key]);
    }
    else {
      $message = 'Require an URL which returns a colored box image.';

      \MyLocalLogger\Write::error($message);
      throw new InvalidArgumentException($message);
    }

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Depends on dry-run option,
   * Send a colored box image to LINE server
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
   * Add data attached a colored box image
   * to the message section of POST.
   * @param [array] &$body - The body section of POST
   * @param [ColorManager] $colorManager - Color data
   */
  protected function addMessage(array &$body, $colorManager) {
    \MyLocalLogger\Write::journal('IN');

    $imageUrl = $this->createImageUrl($colorManager);

    parent::addMessage($body, [
        'type' => 'image',
        'originalContentUrl' => $imageUrl,
        'previewImageUrl' => $imageUrl,
        ]
    );

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Send a colored box image to LINE server.
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
   * Create an url which displays a colored box image.
   * @param [ColorManager] $colorManager - Color data
   * @return [string] An url which displays a colored box image
   */
  private function createImageUrl($colorManager) {
    \MyLocalLogger\Write::journal('IN');

    $urlWithQueryString = sprintf(
        '%s?color=%s',
        $this->urlColorBox,
        urlencode($colorManager->getColorAsString())
    );

    \MyLocalLogger\Write::journal('OUT');
    return $urlWithQueryString;
  }
}