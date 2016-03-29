<?php
class PointsController extends AppController {

	var $name = 'Points';
	
	var $uses = array('Bid', 'Point');

	function index() {
		$this->paginate = array('conditions' => array('Point.user_id' => $this->Auth->user('id')), 'limit' => $this->appConfigurations['pageLimit'], 'order' => array('Point.created' => 'desc'), 'contain' => '');
		$this->set('points', $this->paginate());

		$this->set('balance', $this->Point->balance($this->Auth->user('id')));
		
		/* Change by Andrew Buchan */
		
		$userID = $this->Auth->user('id');
		$tweetBidExists = $this->Bid->find('first', array('conditions' => array('user_id' => $userID, 'description' => 'FMB Tweet', 'auction_id' => '0')));
		if($tweetBidExists)
		{
			$this->set('tweetexists', 1);
		}
		else
		{
			$this->set('tweetexists', 0);
		}
		
		/* End Change */
		
		/* Change by Andrew Buchan */
		
		$userID = $this->Auth->user('id');
		$facebookLikeExists = $this->Bid->find('first', array('conditions' => array('user_id' => $userID, 'description' => 'Facebook Like', 'auction_id' => '0')));
		$points = $this->Setting->get('facebook_like_points');
		if($facebookLikeExists)
		{
			$this->set('fbpoints', $facebookLikeExists);
			$this->set('fblikeexists', 1);
		}
		else
		{
			$this->set('fbpoints', $points);
			$this->set('fblikeexists', 0);
		}
		
		/* End Change */
		
		/* Change by Andrew Buchan */
		//require "../vendors/twitteroauth/autoload.php";
		//use Abraham\TwitterOAuth\TwitterOAuth;
		/* End Change */

		$this->set('title_for_layout', __('My Reward Points', true));
	}

	function admin_user($user_id = null) {
		if(empty($user_id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$user = $this->Point->User->read(null, $user_id);
		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$this->set('user', $user);

		$this->paginate = array('conditions' => array('Point.user_id' => $user_id), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('Point.created' => 'desc'), 'contain' => '');
		$this->set('points', $this->paginate());

		$this->set('balance', $this->Point->balance($user_id));
		
		
		/* Change by Andrew Buchan on 2015-04-03: Add accumulated bid points for current user */
		$bidPoints = $this->User->Auction->Bid->find('count', array('conditions' => array('Bid.user_id' => $this->Auth->user('id'), 'Bid.auction_id >' => 0)));
		$this->set('bidPoints', $bidPoints);
		/* End Change */
		
	}

	function admin_add($user_id = null) {
		if(empty($user_id)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		$user = $this->Point->User->read(null, $user_id);
		if(empty($user)) {
			$this->Session->setFlash(__('Invalid User.', true));
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}

		if(!empty($this->data)) {
			$this->data['Point']['user_id'] = $user_id;
			if(!empty($this->data['Point']['total'])) {
				if($this->data['Point']['total'] > 0) {
					$this->data['Point']['credit'] = $this->data['Point']['total'];
				} else {
					$this->data['Point']['debit'] = $this->data['Point']['total'] * -1;
				}
			}

			if($this->Point->save($this->data)) {
				$this->Session->setFlash(__('The rewards transaction has been added successfully.', true));
				$this->redirect(array('action' => 'user', $user_id));
			} else {
				$this->Session->setFlash(__('There was a problem adding the rewards transaction please review the errors below and try again.', true));
			}
		}

		$this->set('user', $user);
	}

	function admin_delete($id = null) {
		if(empty($id)) {
			$this->Session->setFlash(__('Invalid id for point', true));
			$this->redirect(array('controller' => 'users', 'action'=>'index'));
		}

		$point = $this->Point->read(null, $id);
		if(empty($point)) {
			$this->Session->setFlash(__('Invalid id for point', true));
			$this->redirect(array('controller' => 'users', 'action'=>'index'));
		}

		if ($this->Point->del($id)) {
			$this->Session->setFlash(__('The reward transaction was successfully deleted.', true));
		} else {
			$this->Session->setFlash(__('There was a problem deleting this reward transation', true));
		}
		$this->redirect(array('action'=>'user', $point['Point']['user_id']));
	}
	
	function tweet()
	{
		$userID = $this->Auth->user('id');
		$tweetBidExists = $this->Bid->find('first', array('conditions' => array('user_id' => $userID, 'description' => 'FMB Tweet', 'auction_id' => '0')));
		if($tweetBidExists)
		{
			$this->set('tweetexists', 1);
		}
		else
		{
			$this->set('tweetexists', 0);
			$this->Bid->create();
			if($this->Bid->save(array('user_id' => $userID, 'auction_id' => 0, 'description' => 'FMB Tweet', 'credit' => 1, 'debit' => 0)))
			{

			}
		}
	}
	
	function fblike()
	{
		// First get number of points the user gains from liking Facebook page
		$points = $this->Setting->get('facebook_like_points');
		if((is_numeric($points)) && $points > 0)
		{
			$userID = $this->Auth->user('id');
			$facebookLikeExists = $this->Bid->find('first', array('conditions' => array('user_id' => $userID, 'description' => 'Facebook Like', 'auction_id' => '0')));
			if($facebookLikeExists)
			{
				$this->set('fblikeexists', 1);
			}
			else
			{
				// Only give this user a point if they have not got points from liking Facebook yet
				$this->set('fblikeexists', 0);
				$this->Bid->create();
				if($this->Bid->save(array('user_id' => $userID, 'auction_id' => 0, 'description' => 'Facebook Like', 'credit' => $points, 'debit' => 0)))
				{
					
				}
			}
			$this->redirect(array('action'=>'index'));
		}
	}
	
}
?>