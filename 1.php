<?php
(new WsClient('localhost', 9000))->connect()->sendData('ping');