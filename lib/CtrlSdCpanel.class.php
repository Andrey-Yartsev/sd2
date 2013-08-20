<?php

class CtrlSdCpanel extends CtrlCommon {
use SdPersonalCtrl;

  function action_default() {

    //die2(DB_NAME);

    $this->d['staticLib'] = 'sdEdit';
    if (!Auth::check()) $this->d['tpl'] = 'auth/login';
    else $this->d['tpl'] = 'inner';
  }

  function action_json_get() {
    foreach (['layout', 'layoutContent', 'blockContainer', 'pageBlock'] as $v) {
      $this->json['items'][$v] = (new RouterManager(['req' => new Req(['uri' => "/$v/json_getItems?ownPageId={$this->req['ownPageId']}"])]))->router()->dispatch()->controller->json;
      if (!empty($this->json['items'][$v]['error'])) {
        $this->json['error'] = $this->json['items'][$v]['error'];
        return;
      }
    }
    $this->json['project'] = SdCore::getProject();
    $this->json['blockUserTypes'] = $this->getUserTypes($this->json['project']['package']['id']);
    $this->json['layout'] = SdCore::getLayout($this->req['ownPageId']);
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
        'packages' => [312]
      ], [
        'title'=> 'Блог',
        'data' => [
          'type' => 'blog'
        ],
        'packages' => [312]
      ], [
        'title'         => 'Произвольный шаблон',
        'data'          => [
          'type' => 'tpl'
        ],
        'dialogOptions' => [
          'width'       => '220',
          'dialogClass' => 'dialog fieldFullWidth'
        ],
        'packages' => [312]
      ], [
        'title'         => 'Аудио',
        'data'          => [
          'type' => 'audio'
        ],
        'packages' => [315]
      ]
    ];
    return array_values(array_filter($r, function($v) use ($package) {
      return in_array($package, $v['packages']);
    }));
  }

  function action_json_export() {
    $t = Tt()->getTpl('export', [
      'staticLib' => 'sdSite',
      'html'      => $this->req['html']
    ]);
    $t = preg_replace('/"(\/u\/[^"]+)"/', '"http://'.SITE_DOMAIN.'$1"', $t);
    $t = preg_replace('/\((\/u\/[^)]+)\)/', '(http://'.SITE_DOMAIN.'$1)', $t);
    $t = $this->addStat($t);
    file_put_contents(WEBROOT_PATH.'/'.$this->req->param(2).'.html', $t);
    file_put_contents(SITE_PATH.'/html', $this->req['html']);
  }

  protected function addStat($t) {
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