<?

if (file_exists(SITE_PATH.'/html')) {
  print preg_replace_callback('/{tpl:(\w+)}/', function($m) {
    return Tt()->getTpl('tpl/'.$m[1]);
  }, file_get_contents(SITE_PATH.'/html'));
}

?>