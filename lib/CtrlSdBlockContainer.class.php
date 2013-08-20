<?php

class CtrlSdBlockContainer extends CtrlCommon {
use SdItemsCtrl;

  protected function items() {
    return new SdBlockContainerItems($this->req['ownPageId'] ?: SdCore::defaultOwnPageId);
  }

}