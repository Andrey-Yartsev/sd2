<?php

function sys($s) {
  print "\n$s";
  system($s, $r);
}

$d = __DIR__;
$jsFolder = "$d/sd/js/fonts";
$fontsFolder = "$d/fonts";
foreach (glob("$jsFolder/*") as $v) unlink($v);
foreach (glob($fontsFolder.'/*.{ttf,otf,pfm,vfb}', GLOB_BRACE) as $v) {
  print "$v\n=================\n";
  $name = basename(preg_replace('/^(.*)\.\w+$/', '$1', $v));
  $js = "$jsFolder/$name.js";
  sys("php $d/cufon/generate/convert.php '$v' -u \"U+0400-U+04FF,U+0020-U+007F,U+2012-U+2015,U+00AB,U+00BB\" -n '$name' > '$js'");
}
