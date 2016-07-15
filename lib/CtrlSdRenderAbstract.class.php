<?php

abstract class CtrlSdRenderAbstract extends CtrlCommon {

  protected function getParamActionN() {
    return 2;
  }

  protected function render() {
    return O::di('BcRender', $this->req->param(1))->render();
  }

}
