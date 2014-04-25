<?php

if (empty($_SERVER['argv'][2])) throw new Exception("'project name' argv #2 is required");
$projFolder = NGN_ENV_PATH.'/projects/'.$_SERVER['argv'][2];
File::checkExists($projFolder);
$dummyFolder = __DIR__.'/dummyProject';
Dir::copy($dummyFolder, $projFolder, false);
print `pm localProject cc {$_SERVER['argv'][2]}`;
