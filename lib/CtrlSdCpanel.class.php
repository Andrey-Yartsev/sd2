<?php

class CtrlSdCpanel extends CtrlBase {
  use SdPersonalCtrl;

  protected function getParamActionN() {
    return 2;
  }

  protected function init() {
    Sflm::frontend('css')->addLib('sdEdit');
    Sflm::frontend('js')->addLib('sdEdit');
    Sflm::frontend('js')->addClass('Ngn.Dialog.RequestForm');
    Sflm::frontend('js')->addPath('sd/js/Ngn.sd.js');
    Sflm::frontend('js')->addPath('sd/js/plugins/font.js');
    $this->d['bannerId'] = Misc::checkEmpty($this->req->param(1));
  }

  function action_default() {
    $this->d['tpl'] = 'inner';
  }

  static function getSize($bannerId) {
    $bannerSettings = Config::getVar('bannerSettings/'.$bannerId);
    $r = [];
    list($r['w'], $r['h']) = explode(' x ', $bannerSettings['size']);
    return $r;
  }

  function action_json_get() {
    foreach (['layout', 'layoutContent', 'blockContainer', 'pageBlock'] as $v) {
      $this->json['items'][$v] = (new RouterManager([ //
        'req' => new Req([ //
          'uri' => "/$v/{$this->d['bannerId']}/json_getItems" //
        ]) //
      ]))->router()->dispatch()->controller->json;
      if (!empty($this->json['items'][$v]['error'])) {
        $this->json['error'] = $this->json['items'][$v]['error'];
        return;
      }
    }
    $this->json['project'] = ['title' => 'dummy'];
    $this->json['layout'] = SdCore::getLayout($this->req['ownPageId']);
    $this->json['pageTitle'] = Config::getVar("sd/pages")['name'][$this->req['ownPageId'] - 1];
    $this->json['bannerSettings']['size'] = CtrlSdCpanel::getSize($this->d['bannerId']);
  }

  static $sizes = [
    [125, 125], //
    [160, 600], //
    [200, 200], //
    [250, 250], //
    [300, 250], //
    [300, 600], //
    [336, 280], //
    [468, 60], //
    [728, 90], //
    [1200, 628], //
    [900, 471], //
    [1024, 536] //
  ];

  function action_json_settings() {
    $options = [];
    foreach (self::$sizes as $v) {
      $options[$v[0].' x '.$v[1]] = $v[0].' x '.$v[1];
    }
    $form = new ConfigForm('bannerSettings/'.$this->d['bannerId'], [[
      'title' => 'Размер',
      'name' => 'size',
      'type' => 'select',
      'options' => $options
    ]]);
    if ($form->update()) {
      $data = $form->getData();
      list($this->json['w'], $this->json['h']) = explode(' x ', $data['size']);
      return null;
    }
    $this->json['title'] = 'Настройки баннера';
    return $form;
  }

  protected function getUserTypes($package) {
    $r = [
      [
        'title'         => 'Авторизация',
        'dynamic'       => true,
        'data'          => [
          'type' => 'auth'
        ],
        'dialogOptions' => [
          'dialogClass' => 'settingsDialog compactFields dialog'
        ],
        'packages'      => [312]
      ],
      /*
      [
        'title'    => 'Блог',
        'data'     => [
          'type' => 'blog'
        ],
        'packages' => [312]
      ],
      */
      [
        'title'    => 'Галерея',
        'data'     => [
          'type' => 'gallery'
        ],
        'packages' => [312]
      ],
      [
        'title'         => 'Произвольный шаблон',
        'data'          => [
          'type' => 'tpl'
        ],
        'dialogOptions' => [
          'width'       => '220',
          'dialogClass' => 'dialog fieldFullWidth'
        ],
        'packages'      => [312]
      ],
      [
        'title'    => 'Аудио',
        'data'     => [
          'type' => 'audio'
        ],
        'packages' => [315]
      ]
    ];
    return array_values(array_filter($r, function ($v) use ($package) {
      return in_array($package, $v['packages']);
    }));
  }



}