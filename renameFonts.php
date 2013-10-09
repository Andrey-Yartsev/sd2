<?php

$fontsFolder = __DIR__.'/fonts';
foreach (glob($fontsFolder.'/*.{ttf,otf,pfm,vfb}', GLOB_BRACE) as $v) {
  if (strstr($v, ' ')) rename($v, str_replace(' ', '_', $v));
}
