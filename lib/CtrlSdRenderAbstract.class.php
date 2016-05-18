<?php

abstract class CtrlSdRenderAbstract extends CtrlCommon {

  protected function getParamActionN() {
    return 2;
  }

  protected function render() {
    return BcCore::render($this->req->param(1));
  }

}
