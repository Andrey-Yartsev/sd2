<?php

class SdBlockContainerItems extends SdContainerItems {

  public $ownPageId;

  function __construct($ownPageId = SdCore::defaultOwnPageId) {
    $this->ownPageId = $ownPageId;
    parent::__construct('blockContainer'.ucfirst(SdCore::getLayout($this->ownPageId)));
  }

}