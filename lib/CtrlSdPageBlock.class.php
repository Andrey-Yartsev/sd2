<?php

class CtrlSdPageBlock extends CtrlCommon {
use SdItemsCtrl;

  protected function updateReqId() {
    return $this->req['id'];
  }

  protected function getCurrentOwnPageId() {
    return $this->req['ownPageId'] ? : SdCore::defaultOwnPageId;
  }

  protected function items() {
    return new SdPageBlockItems($this->req->param(1));
  }

  function action_json_edit() {
    return $this->jsonFormActionUpdate(SdFormFactory::edit($this->req->param(3) , $this->items()));
  }

  function uploadCreate($type) {
    $items = $this->items();
    $name = $items->name;
    $size = getimagesize($this->req->files['file']['tmp_name']);
    $d = [
      'data' => [
        'type'        => 'image',
        'ownPageId'   => $this->getCurrentOwnPageId(),
        'dateUpdate'  => time(),
        'containerId' => (new SdBlockContainerItems(SdCore::defaultOwnPageId))->getItems()[0]['id'],
        'position'    => [
          'x' => 50,
          'y' => 50
        ],
        'size'        => [
          'x' => $size[0],
          'y' => $size[1]
        ]
      ]
    ];
    $id = $items->create($d);
    $pageId = SdCore::defaultOwnPageId;
    $file = Dir::make(UPLOAD_PATH."/$name/$type")."/$id.jpg";
    copy($this->req->files['file']['tmp_name'], $file);
    $this->json = $items->getItemF($id);
  }

  function uploadUpdate($type) {
    $items = $this->items();
    $id = $this->req->param(2);
    $size = getimagesize($this->req->files[$this->req['fn']]['tmp_name']);
    $items->update($id, [
      'dateUpdate' => time(),
      'size' => [
        'x' => $size[0],
        'y' => $size[1]
      ]
    ]);
    $file = Dir::make(UPLOAD_PATH."/{$items->name}/$type").'/'.$id.'.jpg';
    copy($this->req->files[$this->req['fn']]['tmp_name'], $file);
    $this->json = $items->getItemF($id);
  }

  function action_json_createImage() {
    $this->uploadCreate('image');
  }

  function action_json_updateImage() {
    $this->uploadUpdate('image');
  }

  function action_json_updateImages() {
    $items = $this->items();
    $id = $this->req->param(2);
    $n = 0;
    foreach ($this->req->files['images'] as $v) {
      $file = Dir::make(UPLOAD_PATH."/{$items->name}/images/$id").'/'.$n.'.jpg';
      copy($v['tmp_name'], $file);
      $n++;
    }
    $items->updateContent($id, ['n' => $n]);
  }

  function action_ajax_updateGlobal() {
    $this->items()->updateGlobal($this->req->param(2), $this->req->params[3]);
  }

  function action_ajax_updateSeparateContent() {
    $this->items()->updateSeparateContent($this->req->param(2), $this->req->params[3]);
  }

  function action_ajax_updateOrder() {
    $items = $this->items()->getItemsFF();
    $ids = array_flip($this->req['ids']);
    //print_r($items);
    foreach ($items as &$item) {
      $item['orderKey'] = $ids[$item['id']];
    }
    //print_r($items);
   // die2(Arr::sortByOrderKey($items, 'orderKey'));

    $this->items()->replace(Arr::sortByOrderKey($items, 'orderKey'));
  }

}
