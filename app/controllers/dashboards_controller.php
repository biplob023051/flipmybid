<?php
    class DashboardsController extends AppController{
        var $name = 'Dashboards';
        var $uses = array('Bid', 'Account');

		function beforeFilter(){
			parent::beforeFilter();

			if(!empty($this->Auth)) {
				$this->Auth->allow('server');
			}
		}

        function _getOnlineUsers(){
            $dir   = TMP . DS . 'cache' . DS;

			$files = scandir($dir);
			$count = 0;

			foreach($files as $filename){
				if(is_dir($dir . $filename)){
					continue;
				}

				if(substr($filename, 0, 16) == 'cake_user_count_') {
					$count++;
				}
			}

			return $count;
        }

        function _getOnlineVisitors(){
            $dir   = TMP . DS . 'cache' . DS;

			$files = scandir($dir);
			$count = 0;

			foreach($files as $filename){
				if(is_dir($dir . $filename)){
					continue;
				}

				if(substr($filename, 0, 19) == 'cake_visitor_count_') {
					$count++;
				}
			}

			return $count;
        }

        function _income($type, $past = false, $options = null) {
        	if($type == 'days') {
        		$date = date('Y-m-d');

        		if($past == true) {
        			$date = date('Y-m-d', time() - 86400 * $options);
        		}

        		if($options == 1) {
	        		$income = $this->Account->find('all', array('conditions' => "Account.created BETWEEN '$date 00:00:00' AND '$date 23:59:59'", 'fields' => "SUM(Account.price) as 'income'"));

					if(empty($income[0][0]['income'])) {
						$income[0][0]['income'] = 0;
					}
        		} else {
        			$past = date('Y-m-d', strtotime($date) - 86400 * $options);

        			$income = $this->Account->find('all', array('conditions' => "Account.created BETWEEN '$past 00:00:00' AND '$date 23:59:59'", 'fields' => "SUM(Account.price) as 'income'"));
					if(empty($income[0][0]['income'])) {
						$income[0][0]['income'] = 0;
					}
        		}
        	} elseif($type == 'month') {
        		$lastDay = date('t');
        		$month = date('m');
        		$year = date('y');

        		$rollback = date('d') + 1;

        		if($past == true) {
        			$lastDay = date('t', time() - 86400 * $rollback);
        			$month = date('m', time() - 86400 * $rollback);
        			$year = date('y', time() - 86400 * $rollback);
        		}

        		$income = $this->Account->find('all', array('conditions' => "Account.created BETWEEN '$year-$month-01 00:00:00' AND '$year-$month-$lastDay 23:59:59'", 'fields' => "SUM(Account.price) as 'income'"));
				if(empty($income[0][0]['income'])) {
					$income[0][0]['income'] = 0;
				}
        	} elseif($type == 'time') {
				$date = date('Y-m-d', time() - 86400 * $options);
				$time = date('H:i:s');

				$income = $this->Account->find('all', array('conditions' => "Account.created BETWEEN '$date 00:00:00' AND '$date $time'", 'fields' => "SUM(Account.price) as 'income'"));
				if(empty($income[0][0]['income'])) {
					$income[0][0]['income'] = 0;
				}
        	}

        	return $income[0][0]['income'];
        }

        function _serverLoad() {
			$os = strtolower(PHP_OS);
        	if(strpos($os, "win") === false) {
  				if(file_exists("/proc/loadavg")) {
         			$load = file_get_contents("/proc/loadavg");
         			$load = explode(' ', $load);
         			return $load[0];
	  			} elseif(function_exists("shell_exec")) {
	        		$load = explode(' ', `uptime`);
	         		return $load[count($load)-1];
	  			} else {
	  				return __('n/a', true);
	  			}
	        } else {
	  			if(class_exists("COM")) {
	         		$wmi = new COM("WinMgmts:\\\\.");
	         		$cpus = $wmi->InstancesOf("Win32_Processor");

	         		$cpuload = 0;
	         		$i = 0;
	         		while ($cpu = $cpus->Next()) {
	    				$cpuload += $cpu->LoadPercentage;
	    				$i++;
	         		}

	         		$cpuload = round($cpuload / $i, 2);
	         		return $cpuload.'%';
	  			} else {
	         		return __('n/a', true);
	  			}
	        }
        }

        function admin_index(){
            $this->set('onlineUsers', $this->_getOnlineUsers());
            $this->set('onlineVisitors', $this->_getOnlineVisitors());
            $this->set('serverLoad', 'Not Available');

            $this->set('dailyIncome', $this->_income('days', false, 1));
            $this->set('yesterdayIncome', $this->_income('days', true, 1));
            $this->set('thisTimeYesterdayIncome', $this->_income('time', null, 1));

            $this->set('weeklyIncome', $this->_income('days', false, 7));
            $this->set('lastweekIncome', $this->_income('days', true, 7));

            $this->set('monthlyIncome', $this->_income('month'));
            $this->set('lastmonthIncome', $this->_income('month', true));

            // lets get the number of outstanding bids!
			$credit = $this->Bid->find('all', array('fields' => "SUM(Bid.credit) as 'credit'"));
			if(empty($credit[0][0]['credit'])) {
				$credit[0][0]['credit'] = 0;
			}

			$debit  = $this->Bid->find('all', array('fields' => "SUM(Bid.debit) as 'debit'"));
			if(empty($debit[0][0]['debit'])) {
				$debit[0][0]['debit'] = 0;
			}

			$user = $this->Bid->User->find('all', array('fields' => "SUM(User.bid_balance) as 'credit'", 'contain' => ''));
			if(empty($user[0][0]['credit'])) {
				$user[0][0]['credit'] = 0;
			}

			$outstandingBids = $credit[0][0]['credit'] + $user[0][0]['credit'] - $debit[0][0]['debit'];
			$this->set('outstandingBids', $outstandingBids);
        }
    }
?>
