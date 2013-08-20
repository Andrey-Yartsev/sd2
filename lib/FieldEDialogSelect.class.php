<?php

class FieldEDialogSelect extends FieldESelect {

  protected function defineOptions() {
    return array_merge(parent::defineOptions(), ['rowClass' => 'dialogSelectEl']);
  }

}
