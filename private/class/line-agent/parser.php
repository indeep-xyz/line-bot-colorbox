<?php

namespace LineAgent;

/**
 * The class parses JSON sent from LINE server.
 *
 * @author  indeep-xyz
 * @package LineAgent
 * @version 0.1.0
 */
class Parser {

  const EVENT_TYPE_MESSAGE   = '138311609000106303';
  const EVENT_TYPE_OPERATION = '138311609100106403';

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
        ? $this->converted->result[0]->content
        : null;
  }

  public function getData() {
    return ($this->isParsed())
        ? $this->converted
        : null;
  }

  public function getEventType() {
    return ($this->isParsed())
        ? $this->converted->result[0]->eventType
        : null;
  }

  public function isParsed() {
    return ($this->converted !== null);
  }
}