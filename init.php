<?php

Ngn::addBasePath(__DIR__, 3);
Config::addBasePath(dirname(NGN_PATH).'/projects/sitedraw/site/config', 3);
O::replaceInjection('DefaultRouter', 'SdRouter');
Sflm::$version = 9;
Sflm::$absBasePaths['sd'] = __DIR__.'/sd';

setConstant('DB_NAME', 'sitedraw');
require NGN_ENV_PATH.'/config/database.php'; // default server config

/*Sflm::$debugPaths = [
  'js' => [
    'sd/js/Ngn.sd.js',
    'sd/js/plugins/text.js',
    'sd/js/plugins/pages.js'
  ]
];
Sflm::$debugUrl = 'http://localhost:8888';*/