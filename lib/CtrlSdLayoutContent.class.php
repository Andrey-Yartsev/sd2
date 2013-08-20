<?php

class CtrlSdLayoutContent extends CtrlCommon {
use SdItemsCtrl;

  protected function items() {
    return new SdContainerItems('layoutContent');
  }

}