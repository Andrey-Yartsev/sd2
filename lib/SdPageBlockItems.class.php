<?php

class SdPageBlockItems extends SdContainerItems {

  public $ownPageId;

  function __construct($ownPageId = SdCore::defaultOwnPageId) {
    Misc::checkEmpty($ownPageId);
    $this->ownPageId = $ownPageId;
    parent::__construct("pageBlocks");
  }

  function update($id, array $data) {
    $this->itemSubKey = 'data';
    parent::update($id, $data);
  }

  function replace(array $_items) {
    $items = $this->getItems();
    foreach ($items as $k => $item) if ($item['data']['ownPageId'] == $this->ownPageId) unset($items[$k]);
    $items = array_values($items);
    $items = array_merge($items, $_items);
    ProjectConfig::updateVar($this->name, $items, true);
  }

  function updateContent($id, $content, $replace = false) {
    $item = $this->getItem($id);
    $_content = $item['content'];
    if ($item->hasSeparateContent()) {
      if ($replace) $_content = [];
      $_content[$this->ownPageId] = $content;
    } else {
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
    } else {
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
    } else {
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
    return SdPageBlockItem::factory($item);
  }

  function getItemD($id) {
    return $this->getItem($id)['data'];
  }

  function getItemsF() {
    $r = [];
    foreach (parent::getItems() as $v) {
      $item = SdPageBlockItem::factory($v)->prepareHtml($this->ownPageId);
      if ($item->isShow($this->ownPageId)) $r[] = $item->r;
    }
    return $r;
  }

  function getItemsFF() {
    return array_filter(parent::getItems(), function($v) {
      return $this->ownPageId == $v['data']['ownPageId'];
    });
  }

}