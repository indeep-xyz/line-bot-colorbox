<?php

namespace LineAgent\Reply;

/**
 * This class manages to reply.
 *
 * @author  indeep-xyz
 * @package LineAgent\Reply
 * @version 0.1.0
 */
class Replier {

  /**
   * @var [mixed] The authentication for connecting to LINE server
   */
  protected $auth;

  /**
   * @var [mixed] The content section of the converted data from LINE server
   */
  protected $lineContent;

  /**
   * Constructor.
   * @param [mixed] $lineContent - The content section of the converted data from LINE server
   */
  function __construct($auth, $lineContent) {
    $this->lineContent = $lineContent;
    $this->auth = $auth;
  }

  /**
   * Set dry-run mode.
   * @param [boolean] $bool - Set dry-run mode when it is true
   */
  public function setDryRun($bool) {
    $this->dryRun = $bool || false;
  }
}