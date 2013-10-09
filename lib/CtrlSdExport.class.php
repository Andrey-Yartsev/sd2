<?php

class CtrlSdExport extends CtrlCommon {

  function action_json_default() {
    Sflm::resetFrontend('sdSite');
    //Sflm::flm('css')->addLib('sdSite');
    //Sflm::flm('js')->addLib('sdSite');
    //die2(Sflm::flm('css')->getTags());
    $t = Tt()->getTpl('export', [
      'sfl'  => 'sdSite',
      'html' => $this->req['html']
    ]);
    $t = preg_replace('/"(\/u\/[^"]+)"/', '"http://'.SITE_DOMAIN.'$1"', $t);
    $t = preg_replace('/\((\/u\/[^)]+)\)/', '(http://'.SITE_DOMAIN.'$1)', $t);
    //$t = $this->addStat($t);
    file_put_contents(WEBROOT_PATH.'/'.$this->req->param(1).'.html', $t);
    file_put_contents(SITE_PATH.'/html', $this->req['html']);
  }

}