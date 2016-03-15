<?php

trait ItemsCtrl {

  /**
   * @return UpdatableItems
   */
  abstract protected function items();

  function action_json_create() {
    $items = $this->items();
    $id = $items->create($this->req['data']);
    $this->json = $items->getItemF($id);
  }

  protected function updateReqId() {
    return $this->req['data']['id'];
  }

  function action_json_update() {
    $items = $this->items();
    $items->update($this->updateReqId(), $this->req['data']);
    $this->json = $items->getItemF($this->updateReqId());
  }

  function action_json_getItems() {
    $items = $this->items()->getItemsF();
    foreach ($items as &$item) foreach ($item as &$v) if (is_array($v) and !count($v)) $v = (object)$v;
    $this->json = $items;
  }

  function action_json_getItem() {
    $item = $this->items()->getItemF($this->req->param(3));
    foreach ($item as &$v) if (is_array($v) and !count($v)) $v = (object)$v;
    $this->json = $item;
  }

  function action_json_delete() {
    $this->items()->delete($this->req->param(3));
  }

}