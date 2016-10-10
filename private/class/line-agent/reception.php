<?php

namespace LineAgent;

require_once(dirname(__FILE__) . '/parser.php');
require_once(dirname(__FILE__) . '/reply/message-replier.php');

/**
 * The class is a reception for the message sent from LINE server.
 *
 * @author  indeep-xyz
 * @package LineAgent
 * @version 0.1.0
 */
class Reception {

  function __construct($rawStringFromLine) {
    $this->validateDefinitions();
    $this->parser = new Parser($rawStringFromLine);
  }

  private function validateDefinitions() {
    $definitions = array(
        '__LINE_CHANNEL_ID__',
        '__LINE_CHANNEL_SECRET__',
        '__LINE_TRUSTED_USER_WITH_ACL__',
        '__URL_COLOR_BOX__',
    );

    foreach ($definitions as $def) {
      if (!defined($def)) {
        exit;
      }
    }
  }

  public function getReplier() {
    $result = null;
    $eventType = $this->parser->getEventType();

    switch ($eventType) {
       case Parser::EVENT_TYPE_MESSAGE:
         $result = $this->createMessageReplier();
         break;
       case Parser::EVENT_TYPE_OPERATION:
         $result = $this->createOperationReplier();
         break;
    }

    return $result;
  }

  private function createMessageReplier() {
    $auth = $this->createAuthArray();
    $content = $this->parser->getContent();

    return new Reply\MessageReplier($auth, $content, __URL_COLOR_BOX__);
  }

  private function createOperationReplier() {
    $auth = $this->createAuthArray();
    $content = $this->parser->getContent();
    // $replier = new Reply\OperationeReplier($content);

    return $replier;
  }

  private function createAuthArray() {
    return [
        'channelId'     => __LINE_CHANNEL_ID__,
        'channelSecret' => __LINE_CHANNEL_SECRET__,
        'mid'           => __LINE_TRUSTED_USER_WITH_ACL__,
    ];
  }

}