<?php

class SdProjectItems extends DdItems {

  protected $pm;

  function __construct() {
    parent::__construct('projects');
    $this->pm = 'php /home/user/ngn-env/pm/pm.php';
  }

  protected function _create(array $data = []) {
    $id = parent::create([]);
    $this->addCreateData($id, $data);
    parent::update($id, $data);
    $data['id'] = $id;
    $data['type'] = 'sd';
    return $data;
  }

  protected function addCreateData($id, array &$data) {
    $data['name'] = "id$id";
    if ($this->getItemByField('name', $data['name'])) throw new Exception('data[name] already used');
    if (empty($data['domain'])) $data['domain'] = "{$data['name']}.sitedraw.ru";
  }

  function create(array $data) {
    $data = $this->_create($data);
    (new PmLocalServer($data))->a_createProject();
    (new PmLocalProject($data))->updateConstant('site', 'SITE_TITLE', $data['title']);
    $this->created($data['id']);
    return $data['id'];
  }

  function copy($id, $newData = null) {
    $newId = parent::copy($id, $newData);
    $curData = $this->getItem($id);
    $newData = ['title' => $curData['title'].' (копия)'];
    $this->addCreateData($newId, $newData);
    parent::update($newId, $newData);
    (new PmLocalProject($curData))->copy($newData['name'], $newData['domain']);     // копируем проект
    $this->created($newId);
    return $newId;
  }

  function update($id, array $data) {
    $oldData = $this->getItem($id);
    parent::update($id, $data);
    $data = $this->getItem($id);
    $localProject = new PmLocalProject($oldData);
    if ($oldData['title'] != $data['title']) $localProject->updateConstant('site', 'SITE_TITLE', $data['title']);
    if ($oldData['domain'] != $data['domain']) $localProject->_updateDomain($data['domain']);
    if ($oldData['name'] != $data['name']) $localProject->_updateName($data['name']); // должен следовать последним так как переименовывает каталог проекта
    if ($oldData['domain'] != $data['domain'] or $oldData['name'] != $data['name']) (new PmLocalServer)->updateHosts()->restart();
  }

  function delete($id) {
    try {
      (new PmLocalProject(['name' => $this->getItem($id)['name']]))->a_delete();
    } catch (Exception $e) {}
    parent::delete($id);
    if (isset($e)) throw $e;
  }

  protected function created($id) {
    $this->createStat($id);
  }

  protected function createStat($id) {
    //return;
    $item = $this->getItem($id);
    $db = new Db(DB_USER, DB_PASS, DB_HOST, 'stat');
    $statId = $db->insert('stat_site', [
      'name' => $item['title'],
      'main_url' => 'http://'.$item['domain'],
      'ts_created' => $item['dateCreate'],
      'timezone' => 'Europe/Moscow'
    ]);
    $this->updateField($id, 'statId', $statId);
  }

}