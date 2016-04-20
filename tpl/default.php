<?

die2('!!!');

if (file_exists(PROJECT_PATH.'/html')) {
  print preg_replace_callback('/{tpl:(\w+)}/', function($m) {
    return Tt()->getTpl('tpl/'.$m[1]);
  }, file_get_contents(PROJECT_PATH.'/html'));
}

?>