<?php

class CtrlSdRender extends CtrlSdRenderAbstract {

  function action_ajax_default() {
    $this->ajaxOutput = '<p>Your banner has been rendered</p><img src="/'.UPLOAD_DIR.'/'.$this->render().'?'.Misc::randString().'">';
  }

}
