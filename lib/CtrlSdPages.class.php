<?php

class CtrlSdPages extends CtrlCommon {

  protected function action_json_getItems() {
    $this->json = Config::getVar("sd/pages");
  }

  protected function action_json_update() {
    SiteConfig::updateVar("sd/pages", $this->req['data'], true);
  }

}