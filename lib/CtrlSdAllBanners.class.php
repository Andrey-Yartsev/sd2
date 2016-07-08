<?php

class CtrlSdAllBanners extends CtrlBase {

  function action_json_default() {
    $this->json['banners'] = [];
    foreach (db()->select('SELECT * FROM bcBanners WHERE userId=?d LIMIT 5', Auth::get('id')) as $v) {
      $this->json['banners'][] = (new BcBanner($v))->r;
    }
  }

}