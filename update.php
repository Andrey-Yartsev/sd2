<?php

$c = file_get_contents(__DIR__.'/init.php');
$c = preg_replace_callback('/(Sflm::\$version = )(\d+)/s', function($m) {
  $newVersion = ++$m[2];
  print "new version: $newVersion";
  return $m[1].$newVersion;
}, $c);
file_put_contents(__DIR__.'/init.php', $c);

