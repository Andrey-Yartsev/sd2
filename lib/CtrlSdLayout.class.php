<?php

class CtrlSdLayout extends CtrlCommon {
use SdItemsCtrl;

  protected function items() {
    return new SdContainerItems('layout');
  }

}