<?php
class Module extends AppModel {

	var $name = 'Module';

	var $hasMany = 'Setting';

	function enabled($name) {
		if(!empty($name)) {
			$module = Cache::read('module_'.$name);
			if(!empty($module)) {
				return $module;
			} else {
				$this->recursive = -1;
				$module = $this->findByName($name);

				if(!empty($module)) {
					Cache::write('module_'.$module['Module']['name'], $module['Module']['active']);
					return $module['Module']['active'];
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}

	function beforeSave(){
		if(!empty($this->data)){
			if(!empty($this->data['Module']['name']) && isset($this->data['Module']['active'])) {
				Cache::delete('module_'.$this->data['Module']['name']);
				Cache::write('module_'.$this->data['Module']['name'], $this->data['Module']['active']);
			}
		}

		return true;
	}
}
?>