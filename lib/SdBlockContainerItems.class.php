<?php

class SdBlockContainerItems extends SdContainerItems {

  public $ownPageId;

  function __construct($ownPageId = SdCore::defaultOwnPageId) {
    $this->ownPageId = $ownPageId;

    parent::__construct('blockContainer'.ucfirst(SdCore::getLayout($this->ownPageId)));
  }
  function getItems() {
    //die2(Config::getFilePaths($this->name, 'vars'));
    //die2(Config::getVar($this->name, true, false));
    return Config::getVar($this->name, true, false) ?: [];
  }

}