<?php

namespace LineAgent\Reply;

require_once(dirname(__FILE__) . '/message-replier.php');
/**
 * The class parses JSON sent from LINE server and
 * create instances of the class Replier.
 *
 * @author  indeep-xyz
 * @package LineAgent\Reply
 * @version 0.2.1
 */
class ReplierFactory {

  const EVENT_TYPE_MESSAGE   = 'message';
  // const EVENT_TYPE_OPERATION = '138311609100106403';

  /**
   * Options to run.
   * @var [mixed]
   * @var [string] $options['accessToken'] - The authentication to connect to LINE server
   * @var [string] $options['urlColorBox'] - The URL to return an image as a box
   * @var [string] $options['dryRun'] - Dry-run mode when it is truthy
   */
  private $options;

  /**
   * @var [mixed] The section "events" in data sent from LINE server.
   */
  private $events;

  function __construct($raw, $options) {
    \MyLocalLogger\Write::journal('IN');

    $this->initializeEvents($raw);
    $this->options = $options;

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Parse the argument and initialize member variables.
   * @param [string] $rawJSON - The raw JSON sent from LINE server
   */
  private function initializeEvents($raw) {
    \MyLocalLogger\Write::journal('IN');

    $converted = json_decode($raw);
    $this->events = $converted->events;

    \MyLocalLogger\Write::journal('OUT');
  }

  /**
   * Create instances of kind of the class Replier.
   * The kind of each instance depends on the parameter "type" of
   * the event data sent from LINE server.
   * @return [array<Replier>] Instances of kind of the class Replier
   */
  public function createRepliers() {
    \MyLocalLogger\Write::journal('IN');

    $repliers = [];

    foreach ($this->events as $event) {
      $replier = $this->createReplier($event);

      if ($replier != null) {
        array_push($repliers, $replier);
      }
    }

    \MyLocalLogger\Write::journal('OUT');
    return $repliers;
  }

  /**
   * Create an instance of kind of the class Replier.
   * Its kind depends on the parameter "type" of the event data.
   *
   * @param  [mixed] $event - Event data
   * @return [Replier] An instance of kind of the class Replier
   */
  public function createReplier($event) {
    \MyLocalLogger\Write::journal('IN');

    $replier = null;

    switch ($event->type) {
       case self::EVENT_TYPE_MESSAGE:
         $replier = new MessageReplier($event, $this->options);
       // case self::EVENT_TYPE_OPERATION:
       //   $replier = new OperationeReplier($event, $this->options);
    }

    \MyLocalLogger\Write::journal('OUT');
    return $replier;
  }
}