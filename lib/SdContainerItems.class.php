<?php

class SdContainerItems extends ConfigItems {

  function __construct($name) {
    parent::__construct("sd/$name");
  }

  function getItemF($id) {
    return $this->getItem($id);
  }

  function getItemE($id) {
    return $this->getItem($id);
  }

  function getItemD($id) {
    return $this->getItem($id);
  }

  function getItemsF() {
    return $this->getItems();
  }

}