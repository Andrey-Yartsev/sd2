<?php

// define('FORCE_STATIC_FILES_CACHE', true); // @todo не работает

Ngn::addBasePath(__DIR__, 3);
Config::addBasePath(dirname(NGN_PATH).'/projects/sitedraw/site/config', 3);
O::replaceInjection('DefaultRouter', 'SdRouter');
Sflm::$version = 9;
Sflm::$absBasePaths['sd'] = __DIR__.'/static';

setConstant('DB_HOST', 'localhost');
setConstant('DB_USER', 'root');
setConstant('DB_PASS', 'ypyfjipdtl');
setConstant('DB_LOGGING', false);
setConstant('DB_NAME', 'sitedraw');

Sflm::$debugPaths = [
  'js' => [
    'sd/js/Ngn.sd.js',
    'sd/js/plugins/text.js',
    'sd/js/plugins/pages.js'
  ]
];
Sflm::$debugUrl = 'http://localhost:8888';