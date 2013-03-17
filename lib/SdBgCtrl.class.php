<?php

trait SdBgCtrl {
use ItemsCtrl;

  function action_json_uploadBg() {
    $name = $this->items()->name;
    $id = $this->req->param(2);
    $file = Dir::make(UPLOAD_PATH."/$name/bg").'/'.$id.'.jpg';
    copy($this->req->files['file']['tmp_name'], $file);
    $items = $this->items();
    $item = $items->getItem($id);
    $this->json['url'] = '/'.UPLOAD_DIR."/$name/bg/".$id.'.jpg';
    $item['bg'] = $this->json['url'];
    $items->update($id, $item);
  }

  function action_json_removeBg() {
    $id = $this->req->param(2);
    $file = Dir::make(UPLOAD_PATH."/{$this->items()->name}/bg")."/$id.jpg";
    $items = $this->items();
    $item = $items->getItem($id);
    unset($item['bg']);
    $items->update($id, $item);
    unlink($file);
  }

  function action_json_fontSettings() {
    return $this->jsonFormActionUpdate(new SdContainerFontSettingsForm($this->items(), $this->req->param(2)));
  }

}