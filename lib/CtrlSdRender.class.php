<?php

class CtrlSdRender extends CtrlSdRenderAbstract {

  function action_ajax_default() {
    $this->ajaxOutput = '<img src="/'.UPLOAD_DIR.'/'.$this->render().'?'.Misc::randString().'">';
  }

}
