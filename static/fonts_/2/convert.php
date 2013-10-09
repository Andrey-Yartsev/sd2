<?php

foreach (glob(__DIR__.'/*.ttf') as $v) {
  $js = str_replace('.ttf', '.js', $v);
  $js = dirname($js).'/js/'.basename($js);
  `php /home/user/sd/cufon/generate/convert.php $v -u "U+??" > $js`;
}
