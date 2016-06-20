<?php

class SdPageBlockItems extends SdContainerItems {

  public $name;

  protected $ownPageId = 1, $bannerId;

  function __construct($bannerId) {
    Misc::checkEmpty($bannerId);
    $this->bannerId = $bannerId;
    $this->name = 'sd/pageBlocks/'.$bannerId;
    parent::__construct('bcBlocks');
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
    $r = parent::create($data);
    return $r;
  }

  function fixTopOrder() {
    //$r = db()->select('SELECT id, orderKey FROM bcBlocks'.$this->cond->all().' ORDER BY orderKey');
    //die2($r);
    $items = $this->getItems();
    $orderKey = 0;
    foreach ($items as $v) {
      if ($v['orderKey'] >= $orderKey) $orderKey--;
    }
    foreach ($items as $v) {
      if (!empty($v['data']['top'])) {
        db()->update('bcBlocks', $v['id'], ['orderKey' => $orderKey]);
      }
    }
  }

  function update($id, array $data) {
    $item = $this->getItem($id);
    $item['data'] = array_merge($item['data'], $data);
    parent::update($id, $item->r);
    db()->query('UPDATE bcBanners SET dateUpdate=? WHERE id=?', Date::db(), $this->bannerId);
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
    return $this->getItem($id)->prepareHtml($this->ownPageId)->r;
  }

  function getItemE($id) {
    return $this->getItem($id)->editContent($this->ownPageId);
  }

  function getItem($id) {
    if (($item = parent::getItem($id)) === false) throw new EmptyException("id=$id");
    return SdPageBlockItem::factory($item, $this->bannerId);
  }

  function getItemD($id) {
    return $this->getItem($id)['data'];
  }

  function getItemsF() {
    $r = [];
    foreach (parent::getItems() as $v) {
      $item = SdPageBlockItem::factory($v, $this->bannerId)->prepareHtml($this->ownPageId);
      if ($item->isShow($this->ownPageId)) $r[] = $item->r;
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

}