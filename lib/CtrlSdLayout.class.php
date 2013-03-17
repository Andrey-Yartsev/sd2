<?php

class CtrlSdLayout extends CtrlCommon {
use SdBgCtrl;

  protected function items() {
    return new SdContainerItems('layout');
  }

}