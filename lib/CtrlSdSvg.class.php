<?php

class CtrlSdSvg extends CtrlCommon {

  static function getFiles() {
    return glob(Sflm::$absBasePaths['sd'].'/svg/*.svg');
  }

  static function file($name) {
    return Sflm::$absBasePaths['sd'].'/svg/'.$name.'.svg';
  }

  function action_ajax_browse() {
    $d['items'] = [];
    foreach (self::getFiles() as $file) $d['items'][] = new SvgItem($file);
    Tt()->tpl('svg/browse', array_merge($this->req->r, $d));
  }

  function action_ajax_uploadForm() {
    $form = new Form([[
      'title' => 'SVG',
      'name' => 'file',
      'type' => 'file'
    ]], [
      'uploadOptions' => [
        //'url' => '/svg/ajax_upload'
      ]
    ]);
    UploadTemp::extendFormOptions($form);
    return $this->jsonFormAction($form);
  }

  function action_ajax_upload() {
    //
  }

  function action_ajax_item() {
    Tt()->tpl('blocks/svg', [
      'html' => (new SvgItem(self::file($this->req->param(2))))->html(),
      'size' => 200
    ]);
  }

}