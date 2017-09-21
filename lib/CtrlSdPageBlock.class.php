<?php

class CtrlSdPageBlock extends CtrlCommon {
  use SdItemsCtrl;

  protected function updateReqId() {
    return $this->req['id'];
  }

  protected function getCurrentOwnPageId() {
    return $this->req['ownPageId'] ?: SdCore::defaultOwnPageId;
  }

  protected $_items;

  protected function documentId() {
    return $this->req->param(1);
  }

  protected function blockId() {
    return $this->req->param(3);
  }

  protected function items() {
    if (isset($this->_items)) return $this->_items;
    return $this->_items = new SdPageBlockItems($this->documentId());
  }

  function action_json_getItems() {
    $this->items()->cond->setOrder('orderKey');
    $items = $this->items()->getItemsF();
    foreach ($items as &$item) foreach ($item as &$v) if (is_array($v) and !count($v)) $v = (object)$v;
    $this->json = $items;
  }

  static function boolValue($v) {
    if (strlen($v) > 1) {
      // значит это слово 'false' / 'true'
      return $v === 'false' ? false : true;
    }
    else {
      return (bool)$v;
    }
  }

  function action_json_update() {
    $items = $this->items();
    $data = $this->req['data'];
    if (isset($this->req['data']['font']['shadow'])) {
      $data['font']['shadow'] = self::boolValue($this->req['data']['font']['shadow']);
    }
    $items->update($this->updateReqId(), $data);
    $this->json = $items->getItemF($this->updateReqId());
  }

  function action_json_edit() {
    return $this->jsonFormActionUpdate(SdFormFactory::edit($this->req->param(3), $this->items()));
  }

  static function protoData($type) {
    return [
      'data' => [
        'type'       => $type,
        'ownPageId'  => SdCore::defaultOwnPageId,
        'dateUpdate' => time(),
        'position'   => [
          'x' => 0,
          'y' => 0
        ]
      ]
    ];
  }

  function uploadCreate($type) {
    $items = $this->items();
    $name = $items->name;
    $size = getimagesize($this->req->files['file']['tmp_name']);
    $maxWidth = Sd2Core::getSize($this->req->param(1))['w'] * 2;
    if ($size[0] > $maxWidth) {
      $w = $maxWidth;
      $a = $size[0] / $size[1];
      $h = $w / $a;
      (new Image)->resizeAndSave($this->req->files['file']['tmp_name'], $this->req->files['file']['tmp_name'], $w, $h);
      $size[0] = $maxWidth;
      $size[1] = $h;
    }
    $d = [
      'data' => [
        'type'       => 'image',
        'ownPageId'  => $this->getCurrentOwnPageId(),
        'dateUpdate' => time(),
        'position'   => [
          'x' => 0,
          'y' => 0
        ],
        'size'       => [
          'w' => $size[0],
          'h' => $size[1]
        ]
      ]
    ];
    $id = $items->create($d);
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
      'size'       => [
        'w' => $size[0],
        'h' => $size[1]
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
    $n = 0;
    LogWriter::str('image', getPrr($this->req->files));
    if (empty($this->req->files['image'])) {
      $this->error404('no image uploaded');
      return;
    }
    $images = [];
    foreach ($this->req->files['image'] as $n => $v) {
      $folder = UPLOAD_PATH."/{$items->name}/images/{$this->blockId()}";
      $path = '/'.UPLOAD_DIR."/{$items->name}/images/{$this->blockId()}/$n.jpg";
      Dir::make($folder);
      $file = "$folder/$n.jpg";
      copy($v['tmp_name'], $file);
      $images[$n] = $path;
    }
    $currentImages = $items->getItem($this->blockId())['data']['images'];
    //die2($images);
    //die2($items->getItem($this->blockId()));
    foreach ($images as $k => $v) {
      $currentImages[$k] = $v;
    }
    //$images = array_merge($currentImages, $images);
    //die2($currentImages);
    //$images = [];
    $items->update($this->blockId(), ['images' => $currentImages]);
    // $items->updateContent($this->blockId(), ['n' => $n]);
  }

  function action_json_imageMultiUpload() {
    $this->action_json_updateImages();
  }

  function action_json_updateOrder() {
    $this->items()->updateOrder(array_flip($this->req['ids']));
  }

}
