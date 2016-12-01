<?php

namespace LineAgent;

require_once(dirname(__FILE__) . '/parser.php');
require_once(dirname(__FILE__) . '/reply/message-replier.php');

/**
 * The class is a reception for the message sent from LINE server.
 *
 * @author  indeep-xyz
 * @package LineAgent
 * @version 0.2.0
 */
class Reception {

  private $accessToken = __LINE_CHANNEL_ACCESS_TOKEN__;
  private $urlColorBox = __URL_COLOR_BOX__;

  function __construct($rawStringFromLine) {
    $this->parser = new Parser($rawStringFromLine);
  }

  public function getReplier() {
    $result = null;
    $eventType = $this->parser->getEventType();

    switch ($eventType) {
       case Parser::EVENT_TYPE_MESSAGE:
         $result = $this->createMessageReplier();
         break;
       // case Parser::EVENT_TYPE_OPERATION:
       //   $result = $this->createOperationReplier();
       //   break;
    }

    return $result;
  }

  private function createMessageReplier() {
    $accessToken = $this->accessToken;
    $getEventDataArray = $this->parser->getEventDataArray();

    return new Reply\MessageReplier(
        $this->accessToken,
        $getEventDataArray[0],
        $this->urlColorBox);
  }

  private function createOperationReplier() {
    $accessToken = $this->accessToken;
    $getEventDataArray = $this->parser->getEventDataArray();
    // $replier = new Reply\OperationeReplier($getEventDataArray);

    return $replier;
  }
}