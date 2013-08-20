<?php

class CtrlSdBlog extends CtrlCommon {
  use DdCrudCtrl, DdCrudAuthorCtrl;

  protected function getStrName() {
    return 'blog';
  }

  protected function action_view() {
  }

  protected function items() {
    return (new DdItems($this->getStrName()))->setPagination(true)->setN(3);
  }

}
