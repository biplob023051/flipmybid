&nbsp;&nbsp;&nbsp;
<?php
$html->addCrumb('Home', '/');

if($this->params['url']['url'] !== '/') {
	// extra MY ACCOUNT crumb - list the controllers it applies for
	$extra = array('users', 'addresses', 'packages', 'bids', 'bidbutlers', 'accounts', 'referrals','invites');
	if(in_array($this->params['controller'], $extra)) {
		$html->addCrumb('My Account', '/users');
	} elseif($this->params['url']['url'] == 'auctions/won') {
		$html->addCrumb('My Account', '/users');
	} elseif($this->params['controller'] == 'sections' && $this->params['url']['url'] !== 'help') {
		$html->addCrumb('Help Section', '/help');
	} elseif(($this->params['controller'] == 'topics' || $this->params['controller'] == 'posts') && $this->params['url']['url'] !== 'forum') {
		$html->addCrumb('Forum', '/forum');
	}

	if($this->params['action'] == 'index') {
		if($this->params['controller'] !== 'users' &&  $this->params['controller'] !== 'pages') {
			if(!empty($crumb)) {
				$html->addCrumb($crumb, '/'.$this->params['url']['url']);
			} else {
				$html->addCrumb(Inflector::humanize($this->params['controller']), '/'.$this->params['url']['url']);
			}
		}
	} else {
		if($this->params['controller'] !== 'users' && $this->params['controller'] !== 'pages' && $this->params['controller'] !== 'topics' && $this->params['controller'] !== 'posts') {
			if($this->params['controller'] == 'bidbutlers') {
				$html->addCrumb('Bid Buddies', '/'.$this->params['controller']);
			} else {
				$html->addCrumb(Inflector::humanize($this->params['controller']), '/'.$this->params['controller']);
			}
		}

		if($this->params['action'] !== 'index') {
			// this is added for category parents
			if(!empty($parents)) {
				foreach($parents as $key => $parent) {
					if(!empty($parent['Category']['name'])) {
						$html->addCrumb($parent['Category']['name'], '/categories/view/'.$parent['Category']['id']);
					} else {
						// this is for the forum posts
						$html->addCrumb($parent, '/topics/view/'.$key);
					}
				}
				if(empty($parent['Category']['name'])) {
					if(!empty($crumb)) {
						$html->addCrumb($crumb, '/'.$this->params['url']['url']);
					} else {
						$html->addCrumb(Inflector::humanize($this->params['action']), '/'.$this->params['url']['url']);
					}
				}
			} elseif(!empty($crumb)) {
				$html->addCrumb($crumb, '/'.$this->params['url']['url']);
			} else {
				$html->addCrumb(Inflector::humanize($this->params['action']), '/'.$this->params['url']['url']);
			}
		}
	}
}

echo $html->getCrumbs(' &raquo ');
?>