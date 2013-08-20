<?php

trait SdDefaultCtrl {

  function processExportedHtml($html) {
    $items = new SdPageBlockItems;
    $this->output = preg_replace_callback('/{tplBlock:(\d+)}/', function($m) use ($items) {
      return $items->getItemF($m[1])['html'];
    }, $html);
    $ctrl = $this;
    $this->output = preg_replace_callback('/{tpl:(\w+)}/', function($m) use ($items, $ctrl) {
      return Tt()->getTpl('sd/tpl/'.$m[1], $ctrl->d);
    }, $this->output);
  }

}