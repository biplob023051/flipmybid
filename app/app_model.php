<?php
class AppModel extends Model{

	var $actsAs = array('Containable');

	var $appConfigurations;

	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);

		App::import('Controller','Settings');
		$this->SettingsController = new SettingsController();
		$this->SettingsController->constructClasses();

		// lets set the debug
		Configure::write('debug', $this->SettingsController->get('debug'));

		$this->appConfigurations['name'] 	= $this->SettingsController->get('site_name');
		$this->appConfigurations['url'] 	= $this->SettingsController->get('site_url');
		$this->appConfigurations['email'] 	= $this->SettingsController->get('site_email');
		// don't think we need the following in the app
		//$timezone = $this->SettingsController->get('time_zone');
		//if(!empty($timezone)) {
			//date_default_timezone_set($timezone);
		//}

		// lets see if we are using the translation behaviour
		if($this->SettingsController->enabled('multi_languages')) {
			if(!empty($_COOKIE['CakeCookie']['language']) && substr($_SERVER['REQUEST_URI'], 0, 7) !== '/admin/') {
				$language = $_COOKIE['CakeCookie']['language'];
			} else {
				// lets get the default language - this should be database driven one day if needed
				$language = 'eng';
			}
			$this->locale = $language;
		} else {
			$this->Behaviors->disable('Translate');
		}

		// finally lets set the image defaults
		Configure::write('thumb_image_width', $this->SettingsController->get('thumb_image_width'));
		Configure::write('thumb_image_height', $this->SettingsController->get('thumb_image_height'));
		Configure::write('max_image_width', $this->SettingsController->get('max_image_width'));
		Configure::write('max_image_height', $this->SettingsController->get('max_image_height'));
	}

	/**
	 * Function to get price rate used for beforeSave and afterFind
	 *
	 * @return float The rate which user choose
	 */
	function _getRate(){
		App::import('Controller','Currencies');
		$this->CurrenciesController = new CurrenciesController();
		$this->CurrenciesController->constructClasses();
		return $this->CurrenciesController->get();
	}

    /**
	* This function generates a unique slug
	*
	* @param $title
	* @param $id
	* @return $slug
	*/
	function generateNiceName($title, $id = null) {
		$title = strtolower($title);
		$nice_name = Inflector::slug($title, '-');

		if(!empty($id)) {
			 $conditions = array('conditions' => array($this->name.'.slug' => $nice_name, $this->name.'.id' => '<> '.$id));
		} else {
			 $conditions = array('conditions' => array($this->name.'.slug' => $nice_name));
		}

		$total = $this->find('count', $conditions);
		if($total > 0) {
			for($number = 2; $number > 0; $number ++) {
				if(!empty($id)) {
					 $conditions = array('conditions' => array($this->name.'.slug' => $nice_name.'-'.$number, $this->name.'.id' => '<> '.$id));
				} else {
					 $conditions = array('conditions' => array($this->name.'.slug' => $nice_name.'-'.$number));
				}

				$total = $this->find('count', $conditions);
				if($total == 0) {
					$nice_name = $nice_name.'-'.$number;
					$number = -1;
				}
			}
		}

		return $nice_name;
	}

	/**
	* This function checks that the field is unique taking into account the $id
	*
	* @param $data
	* @param $fieldName
	* @return true if valid, false otherwise
	*/
	function checkUnique($data, $fieldName) {
        $valid = false;
        if(!empty($fieldName) && $this->hasField($fieldName)) {
            if(!empty($this->data[$this->name]['id'])) {
            	$conditions = array($this->name.'.'.$fieldName => $data[$fieldName], $this->name.'.id <>' => $this->data[$this->name]['id']);
            	$valid = $this->isUnique($conditions, false);
            } else {
            	$conditions = array($this->name.'.'.$fieldName => $data[$fieldName]);
            }
            $valid = $this->isUnique($conditions, false);
        }
        return $valid;
	}

	/**
	* This function matches two fields
	*
	* @param $data
	* @param $fieldName1 (no longer required)
	* @param $fieldName2
	* @return true if they match, false otherwise
	*/
	function matchFields($data = array(), $compare_field) {
        foreach($data as $key => $value ){
            $v1 = $value;

            if(!empty($this->data[$this->name][$compare_field])) {
	            $v2 = $this->data[$this->name][$compare_field];
	            if($v1 !== $v2) {
	                return false;
	            } else {
	                continue;
	            }
            } else {
            	continue;
            }
        }
        return true;
	}

	/**
	* This function is used for
	*
	* @param $data
	* @return true if they match, false otherwise
	*/
	function custom($data) {
        if(Configure::read('Validation')) {
        	foreach ($data as $field => $value) {
        		if(!empty($value)) {
        			if($field == 'postcode') {
						if($regex = Configure::read('Validation.custom_rule_postcode')){
							if(preg_match($regex, $value)) {
        						return true;
        					} else {
        						return false;
        					}
						}elseif(Configure::read('Validation.postcode') == 'XXXX-XXX') {
        					if(preg_match('/^[0-9]{4}-[0-9]{3}$/', $value)) {
        						return true;
        					} else {
        						return false;
        					}
        				} else {
        					return true;
        				}
        			} else {
        				// can add future add ons here
        				return true;
        			}
        		} else {
        			return true;
        		}
        	}
       	} else {
       		return true;
       	}
	}

	/**
	 * validate alphanumeric for php compatibility sanity
	 *
	 */
	function alphaNumeric($data) {
		$val = array_shift(array_values($data));
		if (ereg('[^A-Za-z0-9]', $val)) {
			return false;
		}else{
			return true;
		}
	}
}
?>
