<?php

Dir::make('/home/user/ngn-env/projects/bmaker/u/banner/static');

system('phantomjs /home/user/ngn-env/sd/phantomjs/genStatic.js ');

$src = imagecreatefrompng('/home/user/ngn-env/projects/bmaker/u/banner/1.png');
$src = imagecrop($src, [
  'width' => 300,
  'height' => 250,
  'x' => 362,
  'y' => 100
]);
imagepng($src, '/home/user/ngn-env/projects/bmaker/u/banner/1.png', 4);
print 'u/banner/1.png';
