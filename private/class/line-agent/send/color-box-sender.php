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
    parent::__construct($options);
    $this->setUrlColorBox($options);
  }

  /**
   * Set a member variable "urlColorBox".
   * @param [mixed] &$options - Options expected to include the item "urlColorBox".
   */
  private function setUrlColorBox(array &$options) {
    $key = 'urlColorBox';

    if (array_key_exists($key, $options)) {
      $this->$key = $options[$key];
      unset($options[$key]);
    }
    else {
      throw new InvalidArgumentException(
          'Require an URL which returns a colored box image.');
    }
  }

  /**
   * Depends on dry-run option,
   * Send a colored box image to LINE server
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
   * Add data attached a colored box image
   * to the message section of POST.
   * @param [array] &$body - The body section of POST
   * @param [ColorManager] $colorManager - Color data
   */
  protected function addMessage(array &$body, $colorManager) {
    $imageUrl = $this->createImageUrl($colorManager);

    parent::addMessage($body, [
        'type' => 'image',
        'originalContentUrl' => $imageUrl,
        'previewImageUrl' => $imageUrl,
        ]
    );
  }

  /**
   * Send a colored box image to LINE server.
   * @param [string] $replyToken - The destination of the message
   * @param [ColorManager] $colorManager - Color data
   */
  private function send($replyToken, $colorManager) {
    $body = $this->createPostBody($replyToken, $colorManager);
    $this->sendByCurl($body);
  }

  /**
   * Create an url which displays a colored box image.
   * @param [ColorManager] $colorManager - Color data
   * @return [string] An url which displays a colored box image
   */
  private function createImageUrl($colorManager) {
    return sprintf(
        '%s?color=%s',
        $this->urlColorBox,
        urlencode($colorManager->getColorAsString())
    );
  }
}