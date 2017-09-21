<?php

class CtrlSdAllDocuments extends CtrlBase {
  use SdPersonalCtrl;

  protected function init() {
    $this->initAuth();
  }

  function action_json_default() {
    $this->json['banners'] = [];
    foreach (db()->select('SELECT * FROM sdDocuments WHERE userId=?d', Auth::get('id')) as $v) {
      $this->json['banners'][] = (new BcBanner($v))->r;
    }
  }

}