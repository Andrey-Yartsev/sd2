<?php

abstract class CtrlSdRenderAbstract extends CtrlCommon {

  protected function getParamActionN() {
    return 2;
  }

  protected function render() {
    $banner = db()->getRow('sdDocuments', $this->req->param(1));
    if ($banner['userId'] != Auth::get('id')) throw new AccessDenied;
    return O::di('BcRender', $this->req->param(1))->render();
  }

}
