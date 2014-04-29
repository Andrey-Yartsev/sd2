<?php

$domain = 'design-1-1.june.majexa.ru'; // thing about it
$cmd = "phantomjs ".__DIR__."/capture.js $domain";
$output = Errors::checkText(trim(`$cmd`));
output3($output);
//(new Image)->resizeAndSave($output, str_replace('.png', '_sm.png', $output), 150, 100);
