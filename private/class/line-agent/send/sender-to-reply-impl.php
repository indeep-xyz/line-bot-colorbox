<?php

namespace LineAgent\Send;

/**
 * The class is to send a message.
 *
 * @author  indeep-xyz
 * @package LineAgent\Send
 * @version 0.2.1
 */
interface SenderToReplyImpl {

  /**
   * Create the body section of POST.
   * @param [string] $replyToken - The destination of the message
   * @param [undefined] $source - The source of the post body
   * @return [string] The body section of POST
   */
  public function createPostBody($replyToken, $source);

  /**
   * Send a message.
   * @param [string] $replyToken - The destination of the message
   * @param [undefined] $source - The source of the post body
   */
  public function run($replyToken, $source);
}