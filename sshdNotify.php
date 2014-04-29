<?php

$lockfile = __DIR__.'/.sshdNotifyLast';
if (!file_exists($lockfile)) file_put_contents($lockfile, time());
$lastNotify = function() use ($lockfile) {
  return file_get_contents($lockfile);
};
if ($lastNotify() > time()-1) return;
file_put_contents($lockfile, time());
if ($lines = file('/var/log/auth.log')) {
  foreach ($lines as $line) {
    if (strstr($line, 'pam_unix(sshd:session): session closed for user user')) {
      $domain = 'design-1-1.june.majexa.ru';
      `phantomjs ~/ngn-env/sd/capture.js $domain`;
      $path = __DIR__.'/static/watch/'.$domain.'.png'; // result of cmd above
      (new Image)->resizeAndSave($path, $path, 300, 200);
      (new WsClient('localhost', 9000))->connect()->sendData("domain:$domain");
      file_put_contents('/var/log/auth.log', '');
      break;
    }
  }
}