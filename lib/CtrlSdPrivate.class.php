<?php

abstract class CtrlSdPrivate extends CtrlCommon {

  protected function init_() {
    $id = Auth::get('id');
    if (!$id) throw new AccessDenied;
  }

  function action_default() {
    $this->d['tpl'] = 'auth/login';
  }

}