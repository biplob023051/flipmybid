<?php
	Router::connect('/', array('controller' => 'auctions', 'action' => 'index'));
	//Router::connect('/', array('controller' => 'auctions', 'action' => 'home'));

	/* Admin Stuff */
	Router::connect('/admin', array('controller' => 'dashboards', 'action' => 'index', 'admin' => true));
    //Router::connect('/admin/users/login', array('controller' => 'users', 'action' => 'login', 'admin' => false));
    //Router::connect('/admin/users/logout', array('controller' => 'users', 'action' => 'logout', 'admin' => false));

	/* Pages Routing */
	Router::connect('/page/*', array('controller' => 'pages', 'action' => 'view'));
	Router::connect('/contact', array('controller' => 'pages', 'action' => 'contact'));
    Router::connect('/suggestion', array('controller' => 'pages', 'action' => 'suggestion'));
    Router::connect('/pay/*', array('controller' => 'payment_gateways', 'action' => 'pay'));
    Router::connect('/success', array('controller' => 'payment_gateways', 'action' => 'success'));
    Router::connect('/help', array('controller' => 'sections', 'action' => 'index'));
    Router::connect('/help/*', array('controller' => 'sections', 'action' => 'index'));
    Router::connect('/support', array('controller' => 'pages', 'action' => 'support'));

	/* Offline mode */
	Router::connect('/offline', array('controller' => 'settings', 'action' => 'offline'));
	Router::connect('/comingsoon', array('controller' => 'settings', 'action' => 'comingsoon'));

	/* Bid Buddies URL change */
	Router::connect('/bidbuddies', array('controller' => 'bidbutlers', 'action' => 'index'));
	Router::connect('/bidbuddies/add/*', array('controller' => 'bidbutlers', 'action' => 'add'));
	Router::connect('/bidbuddies/edit/*', array('controller' => 'bidbutlers', 'action' => 'edit'));

	/* Forum URL change */
	Router::connect('/forum', array('controller' => 'topics', 'action' => 'index'));

	Router::connect('/auction/*', array('controller' => 'auctions', 'action' => 'view'));

	Router::connect('/referral/*', array('controller' => 'referrals', 'action' => 'activate'));

	Router::connect('/landing/*', array('controller' => 'landings', 'action' => 'view'));
	Router::connect('/landing2/*', array('controller' => 'landings', 'action' => 'view2'));

	Router::connect('/Terms', array('controller' => 'pages', 'action' => 'view', 'terms-and-conditions'));
?>