<?php
class BannersController extends AppController {

	var $name = 'Banners';

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)){
			$this->Auth->allow('get');
		}
	}

	function get($banner_location_id = null) {
		if(!empty($banner_location_id)) {
			return $this->Banner->find('all', array('conditions' => array('Banner.banner_location_id' => $banner_location_id), 'order' => array('Banner.order' => 'asc')));
		} else {
			return $this->Banner->find('all', array('order' => array('Banner.order' => 'asc')));
		}
	}

	function admin_index() {
 		$this->paginate = array('order' => array('Banner.banner_location_id' => 'asc', 'Banner.order' => 'asc'));
		$this->set('banners', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			if(empty($this->data['Banner']['order'])) {
				$this->data['Banner']['order'] = 0;
			}

			$this->Banner->create();
			if ($this->Banner->save($this->data)) {
				$this->Session->setFlash(__('The banner has been added successfully.',true), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The banner could not be saved. Please, try again.',true));
			}
		}

		$this->set('banner_locations', $this->Banner->BannerLocation->find('list'));
	}

	function admin_edit($id = null)
	{
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid Banner',true));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {
    		if(empty($this->data['Banner']['order'])) {
				$this->data['Banner']['order'] = 0;
			}

    		if($this->Banner->save($this->data, false)) {
    			$this->Session->setFlash(__('The banner has been edited successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
    		} else {
    			$this->Session->setFlash(__('The banner could not be saved. Please, try again.', true));
    		}
		} else {
			$this->data = $this->Banner->read(null, $id);
			if(empty($this->data)) {
				$this->Session->setFlash(__('Invalid Banner', true));
				$this->redirect(array('action' => 'index'));
			}
		}

		$this->set('banner_locations', $this->Banner->BannerLocation->find('list'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Banner',true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Banner->delete($id)) {
			$this->Session->setFlash(__('The banner has been deleted',true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>