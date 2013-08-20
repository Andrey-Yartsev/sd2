<?php

class CtrlSdFont extends CtrlCommon {

  function action_ajax_browse() {
    $d['items'] = [];
    foreach (glob(Sflm::$absBasePaths['sd'].'/js/fonts/*.js') as $v) {
      $d['items'][] = ['name' => basename(Misc::removeSuffix('.js', $v))];
    }
    Tt()->tpl('font/browse', array_merge($this->req->r, $d));
  }

}