<?php

$projFolder = NGN_ENV_PATH.'/projects/'.$_SERVER['argv'][2];
File::checkExists($projFolder);
$dummyFolder = __DIR__.'/dummyProject';
Dir::copy($dummyFolder, $projFolder, false);
