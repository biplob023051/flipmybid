<?php
class MembershipsController extends AppController {

	var $name = 'Memberships';

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('level', 'auctions', 'getnext');
		}

		if(!$this->Setting->Module->enabled('memberships')) {
			$this->cakeError('error404'); die;
		}
	}

	function level($user_id = null) {
		$data = array();

		if(empty($user_id)) {
			$user_id = $this->Auth->user('id');
		}

		$membership = $this->Membership->User->find('first', array('conditions' => array('User.id' => $user_id), 'contain' => 'Membership'));

		// now lets see if this user is able to jump a membership level!
		if($this->Setting->get('automatic_memberships')) {
			// lets get there total points
			$balance = $this->Membership->User->Point->balance($user_id, true);

			// lets get the next membership up and see what the points balance is
			if(empty($membership['Membership']['rank'])) {
				$membership['Membership']['rank'] = 0;
			}

			$nextMembership = $this->Membership->find('first', array('conditions' => array('Membership.rank >' => $membership['Membership']['rank']), 'contain' => '', 'order' => array('Membership.rank' => 'asc')));
			if(!empty($nextMembership)) {
				if($balance >= $nextMembership['Membership']['points']) {
					$user['User']['id'] = $user_id;
					$user['User']['membership_id'] = $nextMembership['Membership']['id'];

					$this->Membership->User->save($user, false);

					$membership = $this->Membership->User->find('first', array('conditions' => array('User.id' => $user_id), 'contain' => 'Membership'));
				}
			}
		}

		$data['Membership'] = $membership['Membership'];

		return $data;
	}

	function auctions() {
		$memberships = $this->Membership->find('all', array('contain' => array('Auction' => array('conditions' => array("start_time < '" . date('Y-m-d H:i:s') . "' AND end_time > '" . date('Y-m-d H:i:s') . "'", 'Auction.active' => 1, 'Auction.closed' => 0), 'fields' => 'Auction.id')), 'order' => array('rank' => 'asc')));

		if(!empty($memberships)) {
			foreach ($memberships as $key => $membership) {
				if(!empty($membership['Auction'])) {
					foreach ($membership['Auction'] as $id => $auction) {
						$auction = $this->Membership->Auction->getAuctions(array('Auction.id' => $auction['id']), 1);
						$memberships[$key]['Auction'][$id] = $auction;
					}
				}
			}
		}

		$this->set('memberships', $memberships);
	}

	function getnext($id = null) {
		$membership = $this->Membership->find('first', array('conditions' => array('Membership.id' => $id), 'contain' => '', 'fields' => 'rank'));
		return $this->Membership->find('first', array('conditions' => array('Membership.rank >' => $membership['Membership']['rank']), 'contain' => '', 'order' => array('Membership.rank' => 'asc')));
	}

	function admin_index() {
 		$this->paginate = array('order' => array('Membership.rank' => 'asc'), 'contain' => '');
		$this->set('memberships', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Membership->create();
			if ($this->Membership->save($this->data)) {
				$this->Session->setFlash(__('The Membership has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the membership please review the errors below and try again.', true));
			}
		}
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->Membership->locale = $language;
		}

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Membership', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if(!empty($this->data['Membership']['image_delete'])) {
				$this->data['Membership']['image']['delete'] = 1;
			}

			$this->data['Membership']['id'] = $id;

			if ($this->Membership->save($this->data)) {
				$this->Session->setFlash(__('The membership was updated successfully.', true), 'default', array('class' => 'success'));

				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $id));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Membership->recursive = -1;
				$membership = $this->Membership->read(null, $id);
				$this->data['Membership']['image'] = $membership['Membership']['image'];
				$this->Session->setFlash(__('There was a problem updating the membership please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->Membership->recursive = -1;
			$this->data = $this->Membership->read(null, $id);
		}

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Membership', true));
			$this->redirect(array('action'=>'index'));
		}
		$membership = $this->Membership->find('first', array('conditions' => array('Membership.id' => $id), 'contain' => ''));
		if (empty($membership)) {
			$this->Session->setFlash(__('Invalid id for Membership', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('membership', $membership);
		$this->set('languages', $this->requestAction('/languages/get'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Membership', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Membership->delete($id)) {
			$this->Session->setFlash(__('The membership was successfully deleted.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>