<?php

class CtrlSdList extends CtrlBase {

  function action_default() {
    if (!Auth::get('id')) {
      header('Location: /');
      return;
    }
    $this->d['tpl'] = 'list';
  }

}