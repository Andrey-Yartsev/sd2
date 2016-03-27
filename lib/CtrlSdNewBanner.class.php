<?php

class CtrlSdNewBanner extends CtrlBase {

  function action_json_default() {
    $form = new Form([
      [
        'title'   => 'Banner Size',
        'name'    => 'bannerSize',
        'required' => true,
        'type'    => 'select',
        'options' => CtrlSdCpanel::getSizeOptions()
      ]
    ], [
      'title'       => 'Create banner...',
      'submitTitle' => 'Create'
    ]);
    if ($form->isSubmittedAndValid()) {
      $this->json['id'] = BcCore::createBanner($form->getData()['bannerSize']);
      return;
    }
    return $form;
  }

}
