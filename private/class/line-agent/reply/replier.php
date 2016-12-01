<?php

namespace LineAgent\Reply;

/**
 * This class manages to reply.
 *
 * @author  indeep-xyz
 * @package LineAgent\Reply
 * @version 0.2.0
 */
class Replier {

  /**
   * @var [mixed] The authentication to connect to LINE server
   */
  protected $accessToken;

  /**
   * @var [mixed] The content section of the converted data from LINE server
   */
  protected $eventData;

  /**
   * @var [boolean]
   */
  protected $dryRun;

  /**
   * Constructor.
   * @param [mixed] $lineContent - The content section of the converted data from LINE server
   */
  function __construct($accessToken, $eventData) {
    $this->eventData = $eventData;
    $this->accessToken = $accessToken;
  }

  /**
   * Set dry-run mode.
   * @param [boolean] $bool - Set dry-run mode when it is true
   */
  public function setDryRun($bool) {
    $this->dryRun = $bool || false;
  }
}