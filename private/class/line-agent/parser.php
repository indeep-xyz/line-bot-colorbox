<?php

namespace LineAgent;

/**
 * The class parses JSON sent from LINE server.
 *
 * @author  indeep-xyz
 * @package LineAgent
 * @version 0.2.0
 */
class Parser {

  const EVENT_TYPE_MESSAGE   = 'message';
  // const EVENT_TYPE_OPERATION = '138311609100106403';

  /**
   * @var [string] The raw JSON string sent from LINE server
   */
  private $raw;

  /**
   * @var [mixed] The converted data from $this->raw
   */
  private $converted;

  function __construct($raw) {
    $this->init($raw);
  }

  /**
   * Initialize and parse data which is sent from LINE server.
   * @param [string] $rawJSON - The raw JSON data from LINE server
   */
  private function init($raw) {
    $this->raw = $raw;
    $converted = null;

    if ($raw !== false) {
      $this->converted = json_decode($raw);
    }
  }

  public function getContent() {
    return ($this->isParsed())
        ? $this->converted->events[0]->content
        : null;
  }

  public function getEventDataArray() {
    return ($this->isParsed())
        ? $this->converted->events
        : null;
  }

  public function getEventType() {
    return ($this->isParsed())
        ? $this->converted->events[0]->type
        : null;
  }

  public function getReplyToken() {
    return ($this->isParsed())
        ? $this->converted->events[0]->replyToken
        : null;
  }

  public function isParsed() {
    return ($this->converted !== null);
  }
}