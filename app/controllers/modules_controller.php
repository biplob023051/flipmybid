<?php
class ModulesController extends AppController {

	var $name = 'Modules';

	function beforeFilter() {
		parent::beforeFilter();
		if(isset($this->Auth)){
			$this->Auth->allow('enabled');
		}
	}

	function enabled($name = null) {
		return $this->Module->enabled($name);
	}

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('name' => 'asc'), 'contain' => '');
		$this->set('modules', $this->paginate());
	}

	function admin_enable($id = null) {
		if(!$id) {
			$this->Session->setFlash(__('This module is invalid.', true));
			$this->redirect(array('action'=>'index'));
		}

		$module = $this->Module->find('first', array('conditions' => array('Module.id' => $id, 'Module.show_active' => true), 'contain' => ''));

		if(empty($module)) {
			$this->Session->setFlash(__('This module is invalid.', true));
			$this->redirect(array('action'=>'index'));
		}

		$data['Module']['id'] 		= $id;
		$data['Module']['name'] 	= $module['Module']['name'];
		$data['Module']['active'] 	= true;

		$this->Module->save($data, false);

		// lets update the dependant settings!
		$this->Module->Setting->updateAll(array('Setting.disabled' => 0), array('Setting.module_id' => $id, 'Setting.dependant >' => 0));
		$this->Module->Setting->updateAll(array('Setting.disabled' => 0), array('Setting.dependant' => $id));

		$this->Session->setFlash(__('The module has been enabled.', true), 'default', array('class' => 'success'));
		$this->redirect(array('action'=>'index'));
	}

	function admin_disable($id = null){
		if(!$id) {
			$this->Session->setFlash(__('This module is invalid.', true));
			$this->redirect(array('action'=>'index'));
		}

		$module = $this->Module->find('first', array('conditions' => array('Module.id' => $id, 'Module.show_active' => true), 'contain' => ''));

		if(empty($module)) {
			$this->Session->setFlash(__('This module is invalid.', true));
			$this->redirect(array('action'=>'index'));
		}

		$data['Module']['id'] 		= $id;
		$data['Module']['name'] 	= $module['Module']['name'];
		$data['Module']['active'] 	= false;

		$this->Module->save($data, false);

		// lets update the dependant settings!


		$this->Module->Setting->updateAll(array('Setting.disabled' => 1), array('Setting.module_id' => $id, 'Setting.dependant >' => 0));
		$this->Module->Setting->updateAll(array('Setting.disabled' => 1), array('Setting.dependant' => $id));

		$this->Session->setFlash(__('The module has been disabled.', true), 'default', array('class' => 'success'));
		$this->redirect(array('action'=>'index'));
	}
}
?>