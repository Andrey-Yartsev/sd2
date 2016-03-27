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
    $this->json['bannerSizes'] = self::getSizes();
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

  static function getSizes() {
    $r = [];
    foreach (self::$sizes as $v) {
      $r[] = $v[0].' x '.$v[1];
    }
    return $r;
  }

  static function getSizeOptions() {
    $options = [];
    foreach (self::$sizes as $v) {
      $options[$v[0].' x '.$v[1]] = $v[0].' x '.$v[1];
    }
    return $options;
  }

  function action_json_settings() {
    $form = new ConfigForm('bannerSettings/'.$this->d['bannerId'], [
      [
        'title'   => 'Banner Size',
        'name'    => 'size',
        'type'    => 'select',
        'options' => self::getSizeOptions()
      ]
    ]);
    if ($form->update()) {
      $data = $form->getData();
      list($this->json['w'], $this->json['h']) = explode(' x ', $data['size']);
      return null;
    }
    $this->json['title'] = 'Banner Settings';
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

  function action_ajax_backgroundSelect() {
    $db = new Db('developer', 'K3fo83Gf2a', 's0.toasterbridge.com', 'zukul');
    $size = CtrlSdCpanel::getSize($this->d['bannerId']);
    $bannerSizeId = $db->selectCell("SELECT id FROM bannerSize WHERE width=? AND height=?", $size['w'], $size['h']);
    $r = $db->select("SELECT * FROM bannerTemplate WHERE bannerSizeId=?d", $bannerSizeId);
    foreach ($r as $v) {
      print "<img src='https://zukul.com/public/uploads/bannerTemplate/{$v['filename']}' data-id='{$v['id']}'>\n";
    }
  }

  function action_json_createBackgroundBlock() {
    $data = CtrlSdPageBlock::protoData('background');
    $data['data']['backgroundId'] = $this->req->param(3);
    $data['data']['size'] = self::getSize($this->d['bannerId']);
    (new SdPageBlockItems($this->d['bannerId']))->create($data);
  }

  function action_ajax_buttonSelect() {
    $db = new Db('developer', 'K3fo83Gf2a', 's0.toasterbridge.com', 'zukul');
    foreach ($db->select("SELECT * FROM bannerButton") as $v) {
      print "<img src='https://zukul.com/public/uploads/bannerButton/{$v['filename']}'>\n";
    }
  }

  function action_ajax_clipartSelect() {
    $db = new Db('developer', 'K3fo83Gf2a', 's0.toasterbridge.com', 'zukul');
    foreach ($db->select("SELECT * FROM bannerButton") as $v) {
      print "<img src='https://zukul.com/public/uploads/bannerImage/{$v['filename']}'>\n";
    }
  }

  function action_json_createButtonBlock() {
    $data = CtrlSdPageBlock::protoData('button');
    $data['data']['buttonUrl'] = $this->req->rq('buttonUrl');
    list($imageSize['w'],$imageSize['h']) = getimagesize($data['data']['buttonUrl']);
    $bannerSize = self::getSize($this->d['bannerId']);
//    if ($imageSize['w'] > $bannerSize['w'] - 20) {
//      $imageSize['w'] = $imageSize['w'] / 2 - 20;
//      $imageSize['h'] = $imageSize['h'] / 2 - 20;
//    }
//    if ($imageSize['h'] > $bannerSize['h'] - 20) {
//      $imageSize['w'] = $imageSize['w'] / 2 - 20;
//      $imageSize['h'] = $imageSize['h'] / 2 - 20;
//    }
    $data['data']['size'] = $imageSize;
    $data['data']['position'] = [
      'x' => $bannerSize['w'] - $imageSize['w'] - 10,
      'y' => $bannerSize['h'] - $imageSize['h'] - 10
    ];
    (new SdPageBlockItems($this->d['bannerId']))->create($data);
  }

}