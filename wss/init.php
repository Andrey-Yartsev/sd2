<?php

//require dirname(dirname(__DIR__)).'/ngn/vendors/ratchet/vendor/autoload.php';
require dirname(dirname(__DIR__)).'/ratchet/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class SdWssServer implements MessageComponentInterface {
  protected $clients;

  protected function log($s) {
    print "* $s\n";
    LogWriter::str('wss', $s);
  }

  function __construct() {
    $this->log("Starting WebSocket server...");
    $this->clients = new \SplObjectStorage;
    date_default_timezone_set('Europe/Moscow');
  }

  function onOpen(ConnectionInterface $conn) {
    $this->log("New client connected");
    $this->clients->attach($conn);
  }

  function onMessage(ConnectionInterface $from, $msg) {
    print getBacktrace(false);
    $this->log("New message received: $msg");
    print_r(count($this->clients));
    foreach ($this->clients as $client) {
      if ($from !== $client) $client->send($msg);
    }
  }

  function onClose(ConnectionInterface $conn) {
    $this->log("Client connection closed");
    $this->clients->detach($conn);
  }

  function onError(ConnectionInterface $conn, \Exception $e) {
    $this->log("Error: ".$e->getMessage());
    if (gettype($e) == 'RuntimeException') {
      Err::logWarning($e);
      $conn->close();
      return;
    }
    Err::log($e);
    $conn->close();
  }

}

define('NGN_PATH', dirname(dirname(__DIR__)).'/ngn');
define('LOGS_PATH', __DIR__.'/logs');

require NGN_PATH.'/core/lib/common.func.php';
require NGN_PATH.'/core/lib/Err.class.php';
require NGN_PATH.'/core/lib/Arr.class.php';
require NGN_PATH.'/core/lib/LogWriter.class.php';

if (!defined('LOGS_PATH')) throw new Exception('define LOGS_PATH');

set_exception_handler(['Err', 'exceptionHandler']);
set_error_handler(['Err', 'errorHandler']);

date_default_timezone_set('Europe/Moscow');
