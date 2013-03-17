<?php

class CtrlSdContainer extends CtrlCommon {
use SdBgCtrl;

  protected function items() {
    return new SdContainerItems('container');
  }

}