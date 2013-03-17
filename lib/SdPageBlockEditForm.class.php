<?php

class SdPageBlockEditForm extends Form {

  /**
   * @var ConfigItems
   */
  protected $items;

  /**
   * @var integer
   */
  protected $id;

  /**
   * @var array
   */
  protected $item;

  function __construct($id) {
    $this->id = $id;
    $this->items = new SdPbItems;
    $this->item = $this->items->getItem($id);
    if (!empty($this->item['content'])) $this->defaultData = $this->item['content'];
    parent::__construct([['type' => 'wisiwigSimple', 'name' => 'text']]);
    //parent::__construct([['type' => 'image', 'name' => 'image']]);
  }

  function _update(array $d) {
    $this->item['content'] = $d;
    $this->items->update($this->id, $this->item);
  }

}