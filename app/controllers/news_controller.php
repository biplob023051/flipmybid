<?php
class NewsController extends AppController {

	var $name = 'News';

	var $helpers = array('Fck');

	function beforeFilter(){
		parent::beforeFilter();

		if(!empty($this->Auth)) {
			$this->Auth->allow('index', 'getlatest', 'view');
		}
	}

	function index() {
		$this->paginate = array('limit' => 10, 'order' => array('created' => 'desc'));
		$this->set('news', $this->paginate());

		$this->set('title_for_layout', __('Latest News', true));
		$this->set('meta_description', $this->Setting->get('blog_meta_description'));
        $this->set('meta_keywords', $this->Setting->get('blog_meta_keywords'));
	}

	function view($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid News.', true));
			$this->redirect(array('action'=>'index'));
		}

		$news = $this->News->read(null, $id);
		if(empty($news)) {
			$this->Session->setFlash(__('Invalid News.', true));
			$this->redirect(array('action'=>'index'));
		}

		if(!empty($this->data)) {
			$this->data['Comment']['news_id'] 	= $id;
			$this->data['Comment']['user_id'] 	= $this->Auth->user('id');
			$this->data['Comment']['approved']	= 0;

			if ($this->News->Comment->save($this->data)) {
				$this->Session->setFlash(__('Thank you for posting your comment.  Your comment will be reviewed for approval before being posted on the website.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'view', $news['News']['id']));
			} else {
				$this->Session->setFlash(__('There was a problem submitting the comment, please try again.', true));
			}
		}

		$this->set('news', $news);

		$this->set('title_for_layout', $news['News']['title']);
        if(!empty($news['News']['meta_description'])) {
			$this->set('meta_description', $news['News']['meta_description']);
		}
		if(!empty($news['News']['meta_keywords'])) {
			$this->set('meta_keywords', $news['News']['meta_keywords']);
		}

		$this->set('comments', $this->News->Comment->find('all', array('conditions' => array('Comment.news_id' => $id, 'Comment.approved' => 1), 'order' => array('Comment.id' => 'asc'), 'contain' => 'User')));
	}

	function getlatest($limit = 1) {
		if($limit == 1){
			$type = 'first';
		}else{
			$type = 'all';
		}

		return $this->News->find($type, array('limit' => $limit, 'order' => array('created' => 'desc')));
	}

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('created' => 'desc'));
		$this->set('news', $this->paginate());
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->News->create();
			if ($this->News->save($this->data)) {
				$this->Session->setFlash(__('The news has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem adding the news please review the errors below and try again.', true));
			}
		}
	}

	function admin_edit($id = null, $language = null) {
		if(!empty($language)) {
			$this->News->locale = $language;
		}
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid News', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			$this->data['News']['id'] = $id;
			if ($this->News->save($this->data)) {
				$this->Session->setFlash(__('The news has been updated successfully.', true), 'default', array('class' => 'success'));
				if($this->Setting->Module->enabled('multi_languages')) {
					$this->redirect(array('action'=>'translations', $id));
				} else {
					$this->redirect(array('action'=>'index'));
				}
			} else {
				$this->Session->setFlash(__('There was a problem editing the news please review the errors below and try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->News->read(null, $id);
		}

		$this->set('language', $language);
		$this->set('id', $id);
	}

	function admin_translations($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for News', true));
			$this->redirect(array('action'=>'index'));
		}
		$news = $this->News->find('first', array('conditions' => array('News.id' => $id), 'contain' => ''));
		if (empty($news)) {
			$this->Session->setFlash(__('Invalid id for News', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('news', $news);
		$this->set('languages', $this->requestAction('/languages/get'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for News', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->News->delete($id)) {
			$this->Session->setFlash(__('The news was successfully deleted.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>