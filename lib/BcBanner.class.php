<?php

class BcBanner extends ArrayAccesseble {

  function __construct(array $data) {
    $data['editLink'] = '/cpanel/'.$data['id'];
    if ((new SdPageBlockItems($data['id']))->hasAnimation()) {
      if (file_exists(UPLOAD_PATH.'/banner/animated/result/'.$data['id'].'.gif')) {
        $data['directLink'] = '/'.UPLOAD_DIR.'/banner/animated/result/'.$data['id'].'.gif?'.strtotime($data['dateRender']);
        $data['downloadLink'] = '/list/download/'.$data['id'];
        $data['downloadFile'] = UPLOAD_PATH.'/banner/animated/result/'.$data['id'].'.gif';
      }
    }
    else {
      if (file_exists(UPLOAD_PATH.'/banner/static/'.$data['id'].'.png')) {
        $data['directLink'] = '/'.UPLOAD_DIR.'/banner/static/'.$data['id'].'.png?'.strtotime($data['dateRender']);
        $data['downloadLink'] = '/list/download/'.$data['id'];
        $data['downloadFile'] = UPLOAD_PATH.'/banner/static/'.$data['id'].'.png';
      }
    }
    $this->r = $data;
  }

}