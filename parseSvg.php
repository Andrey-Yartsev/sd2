<?

foreach (glob(__DIR__.'/svg/*.svg') as $v) {
  $c = file_get_contents($v);
  $tag = 'path';
  if (preg_match('/<'.$tag.'[^>]+>/um', $c, $m)) {
    foreach ($m as $p) {
      $cls = preg_replace('/class="(\w+)"/', '$1', $p);
    }
  }
}