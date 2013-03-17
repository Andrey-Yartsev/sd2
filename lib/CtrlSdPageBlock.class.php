<?php

class CtrlSdPageBlock extends CtrlCommon {
use SdBgCtrl;

  protected function items() {
    return new SdPbItems;
  }

  function action_json_edit() {
    return $this->jsonFormActionUpdate(new SdPageBlockEditForm($this->req->param(2)));
  }

  function upload($type) {
    $items = $this->items();
    $name = $items->name;
    $size = getimagesize($this->req->files['file']['tmp_name']);
    $d = [
      'type' => 'image',
      'ownPageId' => 1,
      'containerId' => (new SdContainerItems('container'))->getItems()[0]['id'],
      'position' => ['x' => 50, 'y' => 50],
      'size' => ['x' => $size[0], 'y' => $size[1]]
    ];
    $id = $items->create($d);
    $file = Dir::make(UPLOAD_PATH."/$name/$type").'/'.$id.'.jpg';
    copy($this->req->files['file']['tmp_name'], $file);
    $this->json = $items->getItem($id);
  }

  function action_json_createImage() {
    $this->upload('image');
  }

}

