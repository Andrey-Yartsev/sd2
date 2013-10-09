<?php

foreach (glob(Sflm::$absBasePaths['sd'].'/fonts/*') as $v) {
  $file = basename($v);
  preg_match('/(.*)\.(.*)/', $file, $m);
  $name = $m[1];
  print "@font-face {
font-family: $name;
src: url('/sd/fonts/$file');
}
";
}