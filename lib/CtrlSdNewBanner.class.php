<?php

class CtrlSdNewBanner extends CtrlBase {

  function action_json_default() {
    $form = new BannerSettingsCreationForm;
    if ($r = ($this->jsonFormActionUpdate($form) === true)) {
      $this->json['id'] = $form->createdId;
    }
    return $r;
  }

}
