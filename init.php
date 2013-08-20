<?php

// define('FORCE_STATIC_FILES_CACHE', true); // @todo не работает

Ngn::addBasePath(__DIR__, 3);
Config::addBasePath(dirname(NGN_PATH).'/projects/sitedraw/site/config', 3);
O::replaceInjection('DefaultRouter', 'SdRouter');
Sflm::$version = 9;

setConstant('DB_HOST', 'localhost');
setConstant('DB_USER', 'root');
setConstant('DB_PASS', '{dbPass}');
setConstant('DB_LOGGING', false);
setConstant('DB_NAME', 'sitedraw');