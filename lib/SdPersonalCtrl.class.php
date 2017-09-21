<?php

trait SdPersonalCtrl {

  protected function isSdAdmin() {
    return $this->req['adminKey'] === Config::getVar('adminKey');
  }

  protected function initAuth() {
    if (!empty($this->req['adminKey'])) {
      if (!$this->isSdAdmin()) {
        throw new AccessDenied;
      }
      if (empty($this->req['userId'])) {
        throw new Error404('param `userId` is required with `adminKey` param');
      }
      Auth::loginById($this->req['userId']);
    }
    if (!Auth::get('id')) {
      throw new AccessDenied;
    }
    $this->setPageTitle('Editor');
  }

}