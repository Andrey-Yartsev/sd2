<?php

class CtrlSdBlogSettings extends CtrlCommon {

  function action_json_default() {
    $this->json['title'] = 'Настройки блога';
    return $this->jsonFormActionUpdate(new BlogSettingsForm);
  }

}