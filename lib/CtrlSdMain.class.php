<?php

class CtrlSdMain extends CtrlCommon {

  function action_default() {
    $this->d['layoutContainers'] = (new SdContainerItems('container'))->getItems();
  }

}