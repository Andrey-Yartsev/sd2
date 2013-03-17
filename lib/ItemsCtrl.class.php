<?php

trait ItemsCtrl {

  /**
   * @return UpdatableItems
   */
  abstract protected function items();

  function action_json_create() {
    $items = $this->items();
    $id = $items->create($this->req['data']);
    $this->json = $items->getItem($id);
  }

  function action_json_update() {
    $items = $this->items();
    $items->update($this->req['data']['id'], $this->req['data']);
    $this->json = $items->getItem($this->req['data']['id']);
  }

  function action_json_getItems() {
    $this->json = $this->items()->getItems();
  }

  function action_json_getItem() {
    $this->json = $this->items()->getItem($this->req->param(2));
  }

  function action_json_delete() {
    $this->items()->delete($this->req->param(2));
  }

}