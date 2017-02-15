<?php

class CtrlSdDownload extends CtrlSdRenderAbstract {

  function action_ajax_default() {
    $this->render();
    $this->ajaxOutput = '/download/'.$this->req->param(1).'/get';
  }

  function action_get() {
    $banner = new BcBanner(db()->selectRow('SELECT * FROM sdDocuments WHERE id=?d', $this->req->param(1)));
    Misc::checkEmpty($banner['downloadFile']);
    header('Content-Type: application/image');
    header('Content-Disposition: attachment;filename="'.basename($banner['downloadFile']).'"');
    readfile($banner['downloadFile']);
  }

}
