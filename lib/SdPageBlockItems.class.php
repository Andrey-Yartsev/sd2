<?php

class SdPageBlockItems extends SdContainerItems {

  public $name, $ownPageId = 1, $bannerId;

  function __construct($bannerId) {
    Misc::checkEmpty($bannerId);
    $this->bannerId = $bannerId;
    $this->name = 'sd/pageBlocks/'.$bannerId;
    parent::__construct('sdBlocks');
    $this->cond->addF('bannerId', $this->bannerId);
  }

  function create(array $data) {
    $items = $this->getItems();
    if (!empty($data['data']['single'])) {
      foreach ($items as $v) {
        if ($v['data']['type'] == $data['data']['type']) {
          $this->delete($v['id']);
        }
      }
    }
    if (!empty($data['data']['bottom'])) {
      // Делаем orderKey максимальным чтобы блок встал сверху
      $orderKey = 0;
      foreach ($items as $v) {
        if ($v['orderKey'] >= $orderKey) $orderKey++;
      }
    }
    else {
      // Делаем orderKey минимальным чтобы блок встал сверху
      $orderKey = 0;
      foreach ($this->getItems() as $v) {
        if ($v['orderKey'] <= $orderKey) $orderKey--;
      }
    }
    $data['userId'] = Auth::get('id');
    $data['bannerId'] = $this->bannerId;
    $data['orderKey'] = $orderKey;
    $blockId = parent::create($data);
    return $blockId;
  }

  function fixTopOrder() {
    $items = $this->getItems();
    $orderKey = 0;
    foreach ($items as $v) {
      if ($v['orderKey'] >= $orderKey) $orderKey--;
    }
    foreach ($items as $v) {
      if (!empty($v['data']['top'])) {
        db()->update('sdBlocks', $v['id'], ['orderKey' => $orderKey]);
      }
    }
  }

  protected function dataHasChanged($id, $data) {
    if (!$currentData = db()->selectCell("SELECT data FROM sdBlocks WHERE sdBlocks.id=?", $id)) {
      return false;
    }
    $currentData = unserialize($currentData);
    foreach ($data as $k => $v) {
      if (!isset($currentData[$k])) return true;
      if ($currentData[$k] != $v) return true;
    }
    return false;
  }

  public $lastUndoId;

  function update($id, array $data) {
    if (empty($data['images']) and !$this->dataHasChanged($id, $data)) return;
    $r = $this->getItem($id);
    $currentData = $r->r;
    $currentData['data'] = serialize($currentData['data']);
    $currentData['act'] = 'update';
    $currentData['blockId'] = $currentData['id'];
    unset($currentData['id']);
    if (empty($currentData['content'])) $currentData['content'] = '';
    $this->_update($id, $data);
  }

  function _update($id, array $data) {
    $item = $this->getItem($id);
    $item['data'] = array_merge($item['data'], $data);
    parent::update($id, $item->r);
  }

  function updateContent($id, $content, $replace = false) {
    $item = $this->getItem($id);
    $_content = $item['content'];
    if ($item->hasSeparateContent()) {
      if ($replace) $_content = [];
      $_content[111] = $content;
    }
    else {
      $_content = $content;
    }
    $this->itemSubKey = false;
    parent::update($id, ['content' => $_content], true);
  }

  function updateSeparateContent($id, $separateContent) {
    $separateContent = (bool)$separateContent;
    $item = $this->getItem($id);
    if ($separateContent) {
      if (!empty($item['data']['separateContent'])) return;
      $this->update($id, ['separateContent' => true]);
      $this->updateContent($id, $item['content'], true);
    }
    else {
      if (empty($item['data']['separateContent'])) return;
      $this->remove($id, 'separateContent', 'data');
      $this->updateContent($id, Arr::first($item['content']));
    }
  }

  protected $itemSubKey = false;

  protected function mergeItem(&$item, $data) {
    if (!$this->itemSubKey) parent::mergeItem($item, $data);
    $item[$this->itemSubKey] = isset($item[$this->itemSubKey]) ? array_merge($item[$this->itemSubKey], $data) : $data;
  }

  function updateGlobal($id, $global) {
    $global = (bool)$global;
    if ($this->getItem($id)->getContainer()['global'] == $global) {
      $this->remove($id, 'global', 'data');
    }
    else {
      $this->update($id, ['global' => $global]);
    }
  }

  function getItemF($id) {
    $item = $this->getItem($id)->prepareHtml($this->ownPageId)->r;
    $item['dateCreate_tStamp'] = strtotime($item['dateCreate']);
    $item['dateUpdate_tStamp'] = strtotime($item['dateUpdate']);
    return $item;
  }

  function getItemE($id) {
    return $this->getItem($id)->editContent($this->ownPageId);
  }

  function getItem($id) {
    if (($item = parent::getItem($id)) === false) throw new EmptyException("id=$id");
    if (!isset($item['data']['type'])) throw new Exception("no type in block $id. ".getPrr($item));
    return SdPageBlockItem::factory($item, $this->bannerId);
  }

  function getItemD($id) {
    return $this->getItem($id)['data'];
  }

  function getItemsF() {
    $r = [];
    foreach (parent::getItems() as $v) {
      $item = SdPageBlockItem::factory($v, $this->bannerId)->prepareHtml($this->ownPageId);
      $r[] = $item->r;
    }
    return $r;
  }

  function getItemsFF() {
    return array_filter(parent::getItems(), function ($v) {
      return $this->ownPageId == $v['data']['ownPageId'];
    });
  }

  function hasAnimation() {
    foreach (parent::getItems() as $v) {
      if (SdPageBlockItem::factory($v, $this->bannerId)->hasAnimation()) {
        return true;
      }
    }
    return false;
  }

  function maxFramesNumber() {
    $maxFramesNumber = 1;
    foreach (parent::getItems() as $v) {
      $framesNumber = SdPageBlockItem::factory($v, $this->bannerId)->framesNumber();
      if ($framesNumber > $maxFramesNumber) {
        $maxFramesNumber = $framesNumber;
      }
    }
    return $maxFramesNumber;
  }

  function cufonBlocksNumber() {
    $n = 0;
    foreach (parent::getItems() as $v) {
      if (SdPageBlockItem::factory($v, $this->bannerId)->hasCufon()) {
        $n++;
      }
    }
    return $n;
  }

  function delete($id) {
    $r = db()->selectRow('SELECT * FROM sdBlocks WHERE id=?d', $id);
    $r['blockId'] = $r['id'];
    $r['act'] = 'delete';
    unset($r['id']);
    if (file_exists($this->imagesFolder($id))) {
      Dir::move($this->imagesFolder($id), $this->undoImagesFolder($undoId));
    }
    parent::delete($id);
  }

  function getOrder() {
    return db()->selectCol("SELECT id AS ARRAY_KEY, orderKey FROM sdBlocks WHERE bannerId=?d", $this->bannerId);
  }

  function updateOrder(array $blockIdToOrderKey) {
    $this->_updateOrder($blockIdToOrderKey);
  }

  protected function _updateOrder(array $blockIdToOrderKey) {
    foreach ($blockIdToOrderKey as $blockId => $orderKey) {
      db()->query("UPDATE sdBlocks SET orderKey=?d WHERE id=?d", $orderKey, $blockId);
    }
  }

  function updateMultiImages($blockId, $imageN, $uploadedFile) {
    $block = $this->getItem($blockId);
    $images = empty($block['data']['images']) ? [] : $block['data']['images'];
    $filename = "{$this->name}/multi".'/'.$blockId.'/'.$imageN.'.jpg';
    $images[$imageN] = '/'.UPLOAD_DIR.'/'.$filename;
    $newData = ['images' => $images];
    // if this is a new first image add size in data
    if (empty($block['data']['size'])) {

      list($w, $h) = getimagesize($uploadedFile);
      $newData['size'] = [
        'w' => $w,
        'h' => $h
      ];
    }
    // -----
    $this->update($blockId, $newData, true);
    if (!empty($block['data']['images'])) {
      $currentUndoItemFolder = Dir::make($this->undoImagesFolder($this->lastUndoId));
      foreach ($images as $n => $path) {
        // if exists current image with the same number as new, copy to undo folder
        if (isset($block['data']['images'][$n])) {
          $undoFile = $currentUndoItemFolder.'/'.basename($path);
          copy(WEBROOT_PATH.$path, $undoFile);
        }
      }
    }
    $file = Dir::make($this->imagesFolder($blockId)).'/'.$imageN.'.jpg';
    copy($uploadedFile, $file);
    return $images;
  }

  function imagesFolder($blockId) {
    return UPLOAD_PATH."/{$this->name}/multi".'/'.$blockId;
  }

  function undoImagesFolder($undoId) {
    Misc::checkEmpty($undoId);
    return DATA_PATH.'/sdUndo/'.$this->bannerId.'/'.$undoId;
  }

  function redoImagesFolder($redoId) {
    Misc::checkEmpty($redoId);
    return DATA_PATH.'/sdRedo/'.$this->bannerId.'/'.$redoId;
  }

  function deleteImage($blockId, $imageN) {
    $block = $this->getItem($blockId);
    $basePath = '/'.UPLOAD_DIR."/{$this->name}/multi/$blockId";
    $folder = UPLOAD_PATH."/{$this->name}/multi/$blockId";
    $images = $block['data']['images'];
    unset($images[$imageN]);
    $newImages = [];
    for ($i = 0; $i < count($images); $i++) {
      $newImages[] = $basePath."/$i.jpg";
    }
    $this->update($blockId, ['images' => $newImages]);
    // -- undo logic
    Dir::copy( //
      $this->imagesFolder($blockId), //
      Dir::make($this->undoImagesFolder($this->lastUndoId)) //
    );
    // --
    File::delete("$folder/$imageN.jpg");
    $n = 0;
    foreach (glob("$folder/*") as $file) {
      if ($file != "$folder/$n.jpg") {
        rename($file, "$folder/$n.jpg");
      }
      $n++;
    }
  }

}
