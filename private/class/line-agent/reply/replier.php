<?php

namespace LineAgent\Reply;

/**
 * This class manages to reply.
 *
 * @author  indeep-xyz
 * @package LineAgent\Reply
 * @version 0.2.1
 */
class Replier {

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
   * @param [mixed] $lineContent - The content section of the converted data from LINE server
   * @param [mixed] $options - Options to run
   */
  function __construct($eventData, $options) {
    $this->eventData = $eventData;
    $this->options = $options;
  }
}