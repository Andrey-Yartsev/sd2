<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title><?= SITE_TITLE ?></title>
  <?= Sflm::get('css')->getTags() ?>
  <? if ($d['sfl'] != 'sdSite') { ?>
  <script src="/i/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
  <? } ?>
  <?= Sflm::get('js')->getTags() ?>
</head>
