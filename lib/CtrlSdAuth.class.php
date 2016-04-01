<?php

class CtrlSdAuth extends CtrlBase {

  function action_default() {
    if (Auth::get('id')) {
      $this->redirect('/list');
      return;
    }
    $this->d['tpl'] = 'auth/login';
  }

}