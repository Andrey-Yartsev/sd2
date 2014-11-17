<?php

class CtrlSdExport extends CtrlCommon {

  function action_json_default() {
    Sflm::reset();
    Sflm::setFrontendName('sdSite');
    $t = Tt()->getTpl('export', [
      'sfl'  => 'sdSite',
      'html' => $this->req['html']
    ]);
    $t = preg_replace('/"(\/u\/[^"]+)"/', '"http://'.SITE_DOMAIN.'$1"', $t);
    $t = preg_replace('/\((\/u\/[^)]+)\)/', '(http://'.SITE_DOMAIN.'$1)', $t);
    file_put_contents(WEBROOT_PATH.'/'.$this->req->param(1).'.html', $t);
    file_put_contents(PROJECT_PATH.'/html', $this->req['html']);
  }

}