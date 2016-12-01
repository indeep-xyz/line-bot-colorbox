<?php

namespace LineAgent;

require_once(dirname(__FILE__) . '/reply/replier-factory.php');

/**
 * The class is a reception for the message sent from LINE server.
 *
 * @author  indeep-xyz
 * @package LineAgent
 * @version 0.2.1
 */
class Reception {

  /**
   * Options to run.
   * @var [mixed]
   * @var [string] $options['accessToken'] - The authentication to connect to LINE server
   * @var [string] $options['urlColorBox'] - The URL to return an image as a box
   * @var [string] $options['dryRun'] - Dry-run mode when it is truthy
   */
  private $options;

  /**
   * The raw string sent from LINE server.
   * @var [string]
   */
  private $raw;

  /**
   * Constructor.
   * @param [string] $raw - The raw string sent from LINE server
   * @param [mixed] $options - Options to run
   */
  function __construct($raw, $options) {
    $this->raw = $raw;
    $this->options = $options;
  }

  /**
   * Run events in data sent from LINE server.
   */
  public function runEvents() {
    $repliers = $this->createRepliers();

    foreach ($repliers as $replier) {
      $replier->reply();
    }
  }

  /**
   * Create instances of kind of the class Replier.
   * The kind of each instance depends on the parameter "type" of
   * the event data sent from LINE server.
   * @return [array<Replier>] Instances of kind of the class Replier
   */
  private function createRepliers() {
    $factory = new Reply\ReplierFactory($this->raw, $this->options);
    return $factory->createRepliers();
  }
}