<?php

class CtrlSdCpanel extends CtrlBase {
  use SdPersonalCtrl;

  protected function init() {
    Sflm::frontend('css')->addLib('sdEdit');
    Sflm::frontend('js')->addLib('sdEdit');
    Sflm::frontend('js')->addClass('Ngn.Dialog.RequestForm');

  }

  function action_default() {
    //die2((new SdPageBlockItems)->getItem(17)->isShow(1));
    //if (!Auth::check()) $this->d['tpl'] = 'auth/login';
    //else $this->d['tpl'] = 'inner';
    $this->d['tpl'] = 'inner';
  }

  function action_json_get() {
    foreach (['layout', 'layoutContent', 'blockContainer', 'pageBlock'] as $v) {
      $this->json['items'][$v] = (new RouterManager(['req' => new Req(['uri' => "/$v/json_getItems?ownPageId={$this->req['ownPageId']}"])]))->router()->dispatch()->controller->json;
      if (!empty($this->json['items'][$v]['error'])) {
        $this->json['error'] = $this->json['items'][$v]['error'];
        return;
      }
    }
    //$this->json['project'] = SdCore::getProject();
    $this->json['project'] = ['title' => 'dummy'];
    //$this->json['blockUserTypes'] = $this->getUserTypes($this->json['project']['package']['id']);
    //$this->json['blockUserTypes'] = $this->getUserTypes(312);
    $this->json['layout'] = SdCore::getLayout($this->req['ownPageId']);
    $this->json['pageTitle'] = Config::getVar("sd/pages")['name'][$this->req['ownPageId'] - 1];
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

  protected function addStat($t) {
    return $t;
    /*
    $statId = SdCore::getProject()['statId'];
    $trackCode = <<<CODE
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://stat.sitedraw.ru//";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', $statId]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();

</script>
<noscript><p><img src="http://stat.sitedraw.ru/piwik.php?idsite=$statId" style="border:0" alt="" /></p></noscript>
CODE;
    return str_replace('</body>', $trackCode.'</body>', $t);
    */
  }

  function action_ajax_exportPhp() {
  }

  function action_json_uploadFontForm() {

  }

  function action_json_uploadFont() {
    //ucfirst($this->req['name']);
    //$this->req->files['file']['tmp_name'];
  }

}