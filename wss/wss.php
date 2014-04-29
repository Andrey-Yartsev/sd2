<?php

require __DIR__.'/init.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

IoServer::factory(new HttpServer(new WsServer(new SdWssServer)), 9000)->run();
