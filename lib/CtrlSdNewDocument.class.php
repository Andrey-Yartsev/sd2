<?php

class CtrlSdNewDocument extends CtrlBase {

  function action_json_default() {
    $form = new DocumentSettingsCreationForm;
    if ($r = ($this->jsonFormActionUpdate($form) === true)) {
      $this->json['id'] = $form->createdId;
    }
    return $r;
  }

}
