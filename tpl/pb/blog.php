<?

$i = (new DdItems('blog', new Db(DB_USER, DB_PASS, DB_HOST, PROJECT_KEY)))->setPagination(true)->prepareItemsConds();
$i->cond->setLimit(BlogSettingsForm::defaultLimit);
$i->cond->setOrder('dateCreate DESC');
print '<div class="pNums">'.$i->pNums.'</div>';
print '<hr>';
$ddo = new Ddo('blog', 'siteItems');
$ddo->ddddItemLink = '`/blog/view/`.$id';
print $ddo->setItems($i->getItems())->els()

?>
<script>
  document.addEvent('domready', function() {
    c($('.block.id_2'));
  });
</script>