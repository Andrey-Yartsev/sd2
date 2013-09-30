<?php

class SvgItem extends ArrayAccesseble {

  function __construct($file) {
    $this->r['name'] = basename(Misc::removeSuffix('.svg', $file));
    $this->r['classes'] = [];
    $this->r['paths'] = [];
    $this->r['contents'] = file_get_contents($file);
    if (preg_match_all('/<path[^>]+>/um', $this->r['contents'], $m) and $m[0]) {
      foreach ($m[0] as $path) {
        if (preg_match('/class="(\w+)"/m', $path, $m2)) {
          if (!in_array($m2[1], $this->r['classes'])) $this->r['classes'][] = $m2[1];
        }

        $this->r['paths'][] = $path;
      }
    }
  }

  function html() {
    return $this->r['contents'];
    //return implode("\n", $this->r['paths']);
  }


}