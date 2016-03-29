<?php
class Translation extends AppModel {

	var $name = 'Translation';

	var $actsAs = array('Containable');

	var $belongsTo = 'Language';

	function __construct($id = false, $table = null, $ds = null){
		parent::__construct($id, $table, $ds);

		$this->validate = array(
			'msgid' => array(
				'rule' => array('notEmpty'),
				'message' => __('Msgid is a required field.', true)
			)
		);
	}

	function import($language_id = null, $code = 'eng', $file = 'default.po') {
		$filename = ROOT.DS.'app'.DS.'locale'.DS.$code.DS.'LC_MESSAGES'.DS. $file;

	    // open the file
	    $filehandle = fopen($filename, "r");
	    while (($row = fgets($filehandle)) !== FALSE) {
	    	if (substr($row, 0, 3) == '#: ') {
				$reference = str_replace('#: ', '', $row);
				continue;
	        }

	        if (substr($row,0,7) == 'msgid "') {
	        	// parse string in hochkomma:
	            $msgid = substr($row, 7 ,(strpos($row,'"',6)-8));
	            if (!empty($msgid)) {
	            	$row = fgets($filehandle);
	               	if (substr($row, 0, 8) == 'msgstr "') {
	                	$msgstr = substr($row, 8 ,(strpos($row,'"',7)-9));
	               	}

	               	// check if exists
	               	$translation = $this->Language->Translation->find(array('msgid' => $msgid, 'language_id' => $language_id));
					if (empty($translation)) {
	               		$this->create();
	                  	$this->data['Translation']['msgid'] = $msgid;
	                  	$this->data['Translation']['msgstr'] = $msgstr;
	                  	$this->data['Translation']['language_id'] = $language_id;

						if(!empty($reference)) {
	                  		$this->data['Translation']['reference'] = $reference;
	                  	}

	                  	$this->data['Translation']['last_used'] = date('Y-m-d H:i:s');

	                  	$this->save($this->data, false);
	                  	$reference = null;
	               	} else {
	                  	$this->data['Translation']['id'] = $translation['Translation']['id'];
	                  	$this->data['Translation']['last_used'] = date('Y-m-d H:i:s');
	                  	$this->save($this->data, false);
	               	}
	           	}
	      	}
		}

	    fclose($filehandle);
	}

	function export($language_id = null, $code = 'eng', $file = 'default.po') {
		$path = ROOT.DS.'app'.DS.'locale'.DS.$code.DS.'LC_MESSAGES';

		if (file_exists($path.DS.$file)) {
        	rename($path.DS.$file, $path.DS.$file.'.'.gmdate('YmdHis'));
        }

        $translations = $this->Language->Translation->find('all', array('conditions' => array('Translation.language_id' => $language_id), 'contain' => ''));

		if(!empty($translations)) {
			$generate = new File($path.DS.$file);

			foreach ($translations as $translation) {
				if(!empty($translation['Translation']['reference'])) {
					$generate->write('#: ' .$translation['Translation']['reference']);
				}
	            $generate->write('msgid "' .$translation['Translation']['msgid'] .'"'."\n");
	            $generate->write('msgstr "'.$translation['Translation']['msgstr'].'"'."\n\n");
	        }

	        $generate->close();

	        // finally lets clear the persistant directory
			if (file_exists(ROOT.DS.'app'.DS.'tmp'.DS.'cache'.DS.'persistent'.DS.'cake_core_default_'.$code)) {
				unlink(ROOT.DS.'app'.DS.'tmp'.DS.'cache'.DS.'persistent'.DS.'cake_core_default_'.$code);
	        }

	        // at some point there will need to be cache deletes added in here for the daemons_function languages
		}
	}
}
?>