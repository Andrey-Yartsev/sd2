<?php

class CtrlSdLayoutContent extends CtrlCommon {
use SdBgCtrl;

  protected function items() {
    return new SdContainerItems('layoutContent');
  }

}