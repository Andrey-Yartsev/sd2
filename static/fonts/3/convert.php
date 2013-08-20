<?php

function sys($s) {
  print "***$s***\n";
  system($s, $r);
}

foreach (glob(__DIR__.'/*.otf') as $v) {
  $js = str_replace('.otf', '.js', $v);
  $js = '/home/user/sd/static/js/fonts/'.basename($js);
  $name = str_replace('.js', '', basename($js));
  sys("php /home/user/sd/cufon/generate/convertFonts.php $v -u \"U+0400-U+04FF\" -n \"$name\" > $js");
}
