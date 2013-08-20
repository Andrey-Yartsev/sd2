<?

$i = (new DdItems('audio'))->setPagination(true)->prepareItemsConds();
$i->cond->setLimit(BlogSettingsForm::defaultLimit);
$i->cond->setOrder('dateCreate DESC');
print '<div class="pNums">'.$i->pNums.'</div>';
print '<hr>';
$ddo = new Ddo('audio', 'siteItems');
die2($i->getItems());
print $ddo->setItems($i->getItems_cache())->els();

?>