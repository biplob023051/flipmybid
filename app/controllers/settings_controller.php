<?php
class SettingsController extends AppController {

	var $name = 'Settings';

	// for some reason I can't connect direct to modules via Setting->Module
	var $uses = array('Setting', 'Module');

	function beforeFilter() {
		parent::beforeFilter();
		if(isset($this->Auth)){
			$this->Auth->allow('get', 'enabled', 'offline');
		}
	}

	function get($name = null, $auction_id = null) {
		return $this->Setting->get($name, $auction_id);
	}

	function enabled($name = null) {
		return $this->Module->enabled($name);
	}

	function offline() {
		if($this->theme == 'flipmybid') {
			$this->layout = false;
		}

		$this->set('message', $this->Setting->get('offline_message'));
		$this->set('title_for_layout', __('Offline', true));
	}

	function count($id = null, $type = 'module') {
		if($type == 'module') {
			return $this->Setting->find('count', array('conditions' => array('Setting.module_id' => $id, 'Setting.disabled' => 0), 'recursive' => -1));
		} elseif($type == 'advanced') {
			return $this->Setting->find('count', array('conditions' => array('Setting.setting_id' => $id, 'Setting.disabled' => 0), 'recursive' => -1));
		}
	}

	function admin_index() {
		if(!empty($this->appConfigurations['demoMode'])) {
			$this->paginate = array('conditions' => array('Setting.name <>' => 'license_code', 'Setting.module_id' => 0), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('name' => 'asc'), 'contain' => '');
		} else {
			$this->paginate = array('conditions' => array('Setting.module_id' => 0), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('name' => 'asc'), 'contain' => '');
		}

		$this->set('settings', $this->paginate());
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Setting', true));
			$this->redirect(array('action'=>'index'));
		}

		$setting = $this->Setting->find('first', array('conditions' => array('Setting.id' => $id), 'contain' => array('Module.name', 'Parent.name')));
		if(empty($setting)) {
			$this->Session->setFlash(__('The setting was invalid.', true));
			$this->redirect(array('action'=>'index'));
		}

		if (!empty($this->data)) {
			$this->data['Setting']['name'] 		  = $setting['Setting']['name'];
			$this->data['Setting']['allow_empty'] = $setting['Setting']['allow_empty'];
			if ($this->Setting->save($this->data)) {
				$this->Session->setFlash(__('The setting has been successfully updated.', true), 'default', array('class' => 'success'));
				if(!empty($setting['Setting']['setting_id'])) {
					$this->redirect(array('action'=>'advanced', $setting['Setting']['setting_id']));
				} elseif(!empty($setting['Setting']['module_id'])) {
					$this->redirect(array('action'=>'module', $setting['Setting']['module_id']));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('There was a problem updating the setting please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $setting;
		}

		$this->set('setting', $setting);

		if(!empty($setting['Setting']['options'])) {
			$setting['Setting']['options'] = str_replace(' ', '', $setting['Setting']['options']);
		   	$explode = explode(',', $setting['Setting']['options']);

		   	// lets run through the options
		   	$options = array();
		   	foreach ($explode as $key => $option) {
		   		if($option == '0') {
		   			$options[0] = __('No', true);
		   		} elseif($option == '1') {
		   			$options[1] = __('Yes', true);
		   		} else {
		   			$options[$option] = $option;
		   		}
		   	}

			$this->set('options', $options);
		}
	}

	function admin_module($module_id = null) {
		if(!$module_id) {
			$this->Session->setFlash(__('This module is invalid.', true));
			$this->redirect(array('action'=>'index'));
		}

		$module = $this->Setting->Module->find('first', array('conditions' => array('Module.id' => $module_id, 'Module.active' => true), 'contain' => ''));

		if(empty($module)) {
			$this->Session->setFlash(__('This module is invalid.', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('module', $module);

		$this->paginate = array('conditions' => array('Setting.module_id' => $module_id, 'Setting.disabled' => 0, 'Setting.setting_id' => 0), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('name' => 'asc'), 'contain' => '');
		$this->set('settings', $this->paginate());
	}

	function admin_advanced($setting_id = null) {
		if(!$setting_id) {
			$this->Session->setFlash(__('This setting is invalid.', true));
			$this->redirect(array('action'=>'index'));
		}

		$module = $this->Setting->find('first', array('conditions' => array('Setting.id' => $setting_id), 'contain' => 'Module'));

		if(empty($module)) {
			$this->Session->setFlash(__('This setting is invalid.', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('module', $module);

		$this->paginate = array('conditions' => array('Setting.setting_id' => $setting_id), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('name' => 'asc'), 'contain' => '');
		$this->set('settings', $this->paginate());
	}

	function admin_license() {
		$licenseCode = $this->Setting->find('first', array('conditions' => array('Setting.name' => 'license_code')));

		if (!empty($this->data)) {
			$this->data['Setting']['id'] = $licenseCode['Setting']['id'];
			$this->data['Setting']['name'] = $licenseCode['Setting']['name'];

			if ($this->Setting->save($this->data)) {
				$this->Session->setFlash(__('The license code has been updated!', true), 'default', array('class' => 'success'));
				$this->redirect('/admin/dashboards');
			} else {
				$this->Session->setFlash(__('There was a problem updating the setting please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $licenseCode;
		}
	}
}
?>