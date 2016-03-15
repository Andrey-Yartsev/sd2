<?php

$projectName = PROJECT_KEY;
$projFolder = NGN_ENV_PATH.'/projects/'.$projectName;
File::checkExists($projFolder);
$dummyFolder = __DIR__.'/dummyProject';
Dir::copy($dummyFolder, $projFolder, false);
print `pm localProject cc $projectName`;
