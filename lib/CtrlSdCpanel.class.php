<?php

class CtrlSdCpanel extends CtrlBase {
  use SdPersonalCtrl;

  protected function getParamActionN() {
    return 2;
  }

  protected function init() {
    if (!Auth::get('id') and $this->req['renderKey'] != Config::getVar('sd/renderKey')) {
      $this->redirect('/');
      return;
    }
  }

  protected function afterInit() {
    $this->d['bannerId'] = Misc::checkEmpty($this->req->param(1));
    Sflm::frontend('css')->addLib('sdEdit');
    Sflm::frontend('js')->addLib('sdEdit');
    Sflm::frontend('js')->addClass('Ngn.Dialog.RequestForm');
    Sflm::frontend('js')->addPath('sd/js/Ngn.sd.js');
  }

  function action_default() {
    $this->d['tpl'] = 'inner';
  }

  function action_json_get() {
    $this->json['items'] = [
      'blockContainer' => [
        [
          'id'     => 'content',
          'blocks' => true,
          'global' => false
        ]
      ],
      'layout'         => [
        [
          'id'         => 'layout1',
          'parent'     => 'layout',
          'bgSettings' => [
            'repeat' => 'no-repeat'
          ]
        ],
        [
          'id'     => 'layout2',
          'parent' => 'layout1'
        ]
      ],
      'layoutContent'  => [
        [
          'id'   => 'layout',
          'type' => 'layoutContent',
          'font' => ['fontSize' => '24px']
        ]
      ]
    ];
    $this->json['items']['pageBlock'] = (new RouterManager([ //
      'req' => new Req([ //
        'uri' => "/pageBlock/{$this->d['bannerId']}/json_getItems" //
      ]) //
    ]))->router()->dispatch()->controller->json;
    if (!empty($this->json['items']['pageBlock']['error'])) {
      $this->json['error'] = $this->json['items']['pageBlock']['error'];
      return;
    }
    $this->json['bannerSizes'] = self::getSizes();
    $this->json['project'] = ['title' => 'dummy'];
    $this->json['layout'] = SdCore::getLayout($this->req['ownPageId']);
    $this->json['bannerSettings']['size'] = BcCore::getSize($this->d['bannerId']);
  }

  static $sizes;

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
    $form = new Form([
      [
        'title'   => 'Banner Size',
        'name'    => 'size',
        'type'    => 'select',
        'options' => self::getSizeOptions()
      ]
    ]);
    if ($form->isSubmittedAndValid()) {
      $data = $form->getData();
      db()->update('bcBanners', $this->d['bannerId'], ['size' => $data['size']]);
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
    $db = BcCore::zukulDb();
    $size = BcCore::getSize($this->d['bannerId']);
    $bannerSizeId = $db->selectCell("SELECT id FROM bannerSize WHERE width=? AND height=?", $size['w'], $size['h']);
    $r = $db->select("SELECT * FROM bannerTemplate WHERE bannerSizeId=?d", $bannerSizeId);
    foreach ($r as $v) {
      print "<img src='http://zukul.com/public/uploads/bannerTemplate/{$v['filename']}'>\n";
    }
  }

  function action_json_createBackgroundBlock() {
    $data = CtrlSdPageBlock::protoData('background');
    $data['data']['backgroundUrl'] = $this->req->rq('backgroundUrl');
    $data['data']['size'] = BcCore::getSize($this->d['bannerId']);
    (new SdPageBlockItems($this->d['bannerId']))->create($data);
  }

  function action_ajax_buttonSelect() {
    foreach (BcCore::zukulDb()->select("SELECT * FROM bannerButton") as $v) {
      print "<img src= 'http://zukul.com/public/uploads/bannerButton/{$v['filename']}'>\n";
    }
  }

  function action_ajax_clipartSelect() {
    //$ids = implode(', ', db()->ids('bcBannerButtonBroken'));
    foreach (BcCore::zukulDb()->select("SELECT * FROM bannerImage
 -- WHERE id NOT IN ()
 ") as $v) {
      print "<img src='http://zukul.com/public/uploads/bannerImage/{$v['filename']}'>\n";
    }
  }

  function action_json_createButtonBlock() {
    $data = CtrlSdPageBlock::protoData('button');
    $data['data']['buttonUrl'] = $this->req->rq('buttonUrl');
    list($imageSize['w'], $imageSize['h']) = getimagesize($data['data']['buttonUrl']);
    $bannerSize = BcCore::getSize($this->d['bannerId']);
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

CtrlSdCpanel::$sizes = Config::getVar('sd/sizes', false, false);