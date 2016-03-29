<?php
class CommentsController extends AppController {

	var $name = 'Comments';

	function admin_index() {
		$this->paginate = array('limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Comment.id' => 'desc'));
		$this->set('comments', $this->paginate());
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Comment', true));
			$this->redirect(array('action'=>'index'));
		}

		$comment = $this->Comment->find('first', array('conditions' => array('Comment.id' => $id), 'contain' => array('News', 'User')));
		if(empty($comment)) {
			$this->Session->setFlash(__('Invalid Comment', true));
			$this->redirect(array('action'=>'index'));
		}

		$this->set('comment', $comment);

		if (!empty($this->data)) {
			if ($this->Comment->save($this->data)) {
				if(!empty($this->data['Comment']['approved']) && empty($comment['Comment']['approved'])) {
					$default = $this->Language->find('first', array('conditions' => array('Language.default' => true), 'recursive' => -1, 'fields' => 'code'));
					if(!empty($comment['User']['language_id'])) {
						$language = $this->Language->find('first', array('conditions' => array('Language.id' => $comment['User']['language_id']), 'recursive' => -1, 'fields' => 'code'));
						Configure::write('Config.language', $language['Language']['code']);

						$this->Comment->News->locale = $language['Language']['code'];
					} else {
						$this->Comment->News->locale = $default['Language']['code'];
					}

					$news = $this->Comment->News->find('first', array('conditions' => array('News.id' => $comment['News']['id']), 'contain' => ''));
					if(!empty($news)) {
						$comment['News'] = $news;
					}

					if(!empty($this->data['Comment']['bids']) && $this->Setting->get('comments_free_bids') > 0) {
						$bid['Bid']['user_id'] = $comment['Comment']['user_id'];
						$bid['Bid']['description'] = __('Free bid(s) given for submitting a news comment.', true);
						$bid['Bid']['credit'] = $this->Setting->get('comments_free_bids');

						$this->Comment->User->Bid->create();
						$this->Comment->User->Bid->save($bid);
					}

					// lets email the user to let them know the testimonial was approved
					$data						   = $comment;
					$data['Comment']['bids']   	   = $this->data['Comment']['bids'];
		    		$data['to'] 				   = $comment['User']['email'];
					$data['subject'] 			   = sprintf(__('%s - News Comment Approved', true), $this->appConfigurations['name']);
					$data['template'] 			   = 'auctions/comment';
					$this->_sendEmail($data);
				}

				Configure::write('Config.language', $default['Language']['code']);

				if(!empty($this->data['Comment']['bids'])) {
					$this->Session->setFlash(__('The comments has been updated successfully and the free bids have been given.', true), 'default', array('class' => 'success'));
				} else {
					$this->Session->setFlash(__('The comments has been updated successfully.', true));
				}

				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('There was a problem editing the comments please review the errors below and try again.', true));
			}
		} else {
			$this->data = $comment;
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Comment', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Comment->delete($id)) {
			$this->Session->setFlash(__('The comment was successfully deleted.', true), 'default', array('class' => 'success'));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>