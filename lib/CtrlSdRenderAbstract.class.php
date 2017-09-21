<?php

abstract class CtrlSdRenderAbstract extends CtrlCommon {

  protected function getParamActionN() {
    return 2;
  }

  protected function render() {
    $document = db()->getRow('sdDocuments', $this->req->param(1));
    if ($document['userId'] != Auth::get('id')) die('AccessDenied');
    return (new BcRender($this->req->param(1)))->render();
//    get_class(O::di('BcRender', $this->req->param(1)));
//    return O::di('BcRender', $this->req->param(1))->render();
  }

}
