<?php

class CtrlSdCreateFromTemplate extends CtrlCommon {

  function action_ajax_default() {
    Misc::checkEmpty(Auth::get('id'));
    print Sd2Core::copyDocument($this->req->param(1), Auth::get('id'), $this->req->param(2));
  }

}
