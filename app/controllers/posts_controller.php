<?php
class PostsController extends AppController {

	var $name = 'Posts';

	function beforeFilter() {
		parent::beforeFilter();

		if(!empty($this->Auth)){
			$this->Auth->allow('view', 'count', 'getthread');
		}
	}

	function view($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid Thread.', true));
			$this->redirect(array('controllers' => 'topics', 'action' => 'index'));
		}

		$thread = $this->Post->find('first', array('conditions' => array('Post.id' => $id), 'contain' => array('Topic', 'Auction' => 'Product')));

		if (empty($thread)) {
			$this->Session->setFlash(__('Invalid Thread.', true));
			$this->redirect(array('controllers' => 'topics', 'action' => 'index'));
		}
		$this->set('thread', $thread);

		// for the breadcrum
		if(!empty($thread['Topic']['name'])) {
			$this->set('parents', array($thread['Topic']['id'] => $thread['Topic']['name']));
		}

		$this->set('title_for_layout', $thread['Post']['title']);

		// get the posts
		$this->paginate = array('conditions' => array('OR' => array('Post.id' => $id, 'Post.post_id' => $id)), 'order' => array('Post.created' => 'asc'), 'limit' => 25, 'contain' => 'User');
		$this->set('posts', $this->paginate());
	}

	function add($topic_id = null) {
		if(empty($topic_id)) {
			$this->Session->setFlash(__('Invalid Topic', true));
			$this->redirect(array('controller' => 'topics', 'action'=>'index'));
		}

		$topic = $this->Post->Topic->find('first', array('conditions' => array('Topic.id' => $topic_id), 'contain' => ''));

		if(empty($topic)) {
			$this->Session->setFlash(__('Invalid Topic', true));
			$this->redirect(array('controller' => 'topics', 'action'=>'index'));
		}

		$this->set('topic', $topic);

		if (!empty($this->data)) {
			$this->data['Post']['topic_id']  = $topic_id;
			if(!$this->Auth->user('admin')) {
				$this->data['Post']['user_id']	 = $this->Auth->user('id');
			}

			if(empty($this->data['Post']['auction_id'])) {
				$this->data['Post']['auction_id'] = 0;
			}

			$this->Post->create();
			if ($this->Post->save($this->data)) {
				$this->Session->setFlash(__('The thread has been added successfully and is now live!', true), 'default', array('class' => 'success'));
				$this->redirect(array('controller' => 'topics', 'action'=>'view', $topic_id));
			} else {
				$this->Session->setFlash(__('There was a problem adding the thread please review the errors below and try again.', true));
			}
		}

		// for the breadcrum
		if(!empty($topic['Topic']['name'])) {
			$this->set('parents', array($topic['Topic']['id'] => $topic['Topic']['name']));
		}

		$this->set('title_for_layout', __('Create new thread', true));

		$this->set('auctions', $this->_liveauctions());
	}

	function reply($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid Topic', true));
			$this->redirect(array('controller' => 'topics', 'action'=>'index'));
		}

		$thread = $this->Post->find('first', array('conditions' => array('Post.id' => $id, 'Post.post_id' => 0), 'contain' => 'Topic'));

		if(empty($thread)) {
			$this->Session->setFlash(__('Invalid Topic', true));
			$this->redirect(array('controller' => 'topics', 'action'=>'index'));
		}

		$this->set('thread', $thread);

		if (!empty($this->data)) {
			if(!$this->Auth->user('admin')) {
				$this->data['Post']['user_id']	 = $this->Auth->user('id');
			}

			$this->data['Post']['post_id']	 = $id;

			$this->Post->create();
			if ($this->Post->save($this->data)) {
				// lets update the modified date of the thread
				$thread['Post']['modified'] = date('Y-m-d H:i:s');
				$this->Post->save($thread);

				$this->Session->setFlash(__('The post has been added successfully', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'view', $id));
			} else {
				$this->Session->setFlash(__('There was a problem adding the post please review the errors below and try again.', true));
			}
		}

		// for the breadcrum
		if(!empty($thread['Topic']['name'])) {
			$this->set('parents', array($thread['Topic']['id'] => $thread['Topic']['name']));
		}

		$this->set('title_for_layout', __('Reply to a thread', true));

		$this->set('auctions', $this->_liveauctions());
	}

	function count($type = 'threads', $id = null) {
		if($type == 'topics') {
			return $this->Post->find('count', array('conditions' => array('Post.topic_id' => $id, 'Post.post_id' => 0)));
		} elseif($type == 'threads') {
			 $count = $this->Post->find('count', array('conditions' => array('Post.post_id' => $id)));
			 return $count + 1;
		}
	}

	function getthread($id) {
		return $this->Post->find('first', array('conditions' => array('Post.id' => $id), 'contain' => ''));
	}

	function _liveauctions() {
		$data = array();

		$auctions = $this->Post->Auction->find('all', array('conditions' => array('Auction.closed' => 0), 'contain' => array('Product'), 'order' => array('Auction.end_time' => 'asc')));

		if(!empty($auctions)) {
			App::import('Helper', array('Number', 'Time'));
			$number = new NumberHelper();
			$time   = new TimeHelper();

			foreach ($auctions as $auction) {
				$data[$auction['Auction']['id']] = $auction['Product']['title'].', Current Price: '.$number->currency($auction['Auction']['price'], $this->appConfigurations['currency']).', Ending: '.$time->niceShort($auction['Auction']['end_time']);
			}
		}

		return $data;
	}

	function admin_index($id = 0) {
 		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Post.created' => 'desc'));
		$this->set('posts', $this->paginate());
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Post', true));
			$this->redirect(array('action'=>'index'));
		}

		// need to check if it is the main post or not
		$post = $this->Post->find('first', array('conditions' => array('Post.id' => $id), 'contain' => ''));

		if ($this->Post->delete($id)) {
			if(empty($post['Post']['post_id'])) {
				$this->Post->deleteAll(array('Post.post_id' => $id));
			}
			$this->Session->setFlash(__('The post was successfully deleted.', true), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('Post does not exist', true));
		}

		$this->redirect(array('action'=>'index'));
	}
}
?>