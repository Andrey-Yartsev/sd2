<?php

define('SD_PATH', __DIR__);
Ngn::addBasePath(SD_PATH, 3);
Config::addBasePath(dirname(NGN_PATH).'/projects/sitedraw/site/config', 3);
O::replaceInjection('DefaultRouter', 'SdRouter');
Sflm::$version = 9;
Sflm::$absBasePaths['sd'] = __DIR__.'/sd';

require NGN_ENV_PATH.'/config/database.php'; // default server config
