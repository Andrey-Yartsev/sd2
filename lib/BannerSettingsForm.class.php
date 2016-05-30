<?php

abstract class BannerSettingsForm extends Form {

  function __construct() {
    parent::__construct([
      [
        'title'    => 'Title',
        'name'     => 'title',
        'required' => true,
      ],
      [
        'title'   => 'Banner Size',
        'name'    => 'size',
        'type'    => 'select',
        'options' => CtrlSdCpanel::getSizeOptions()
      ]
    ]);
  }

}