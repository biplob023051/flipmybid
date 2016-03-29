<?php
class ImagesController extends AppController {

	var $name = 'Images';

	function admin_index($product_id = null) {
		if(empty($product_id)) {
			$this->Session->setFlash(__('The product ID was invalid.', true));
			$this->redirect(array('controller' => 'products', 'action'=>'index'));
		}
		$product = $this->Image->Product->read(null, $product_id);

		if(empty($product)) {
			$this->Session->setFlash(__('The product ID was invalid.', true));
			$this->redirect(array('controller' => 'products', 'action'=>'index'));
		}
		$this->set('product', $product);

		$this->paginate = array('conditions' => array('product_id' => $product_id), 'limit' => $this->appConfigurations['adminPageLimit'], 'order' => array('order' => 'asc'));
		$this->set('images', $this->paginate());
	}

	function admin_add($product_id = null) {
		if(empty($product_id)) {
			$this->Session->setFlash(__('The product ID was invalid.', true));
			$this->redirect(array('controller' => 'products', 'action'=>'index'));
		}
		$product = $this->Image->Product->read(null, $product_id);
		if(empty($product)) {
			$this->Session->setFlash(__('The product ID was invalid.', true));
			$this->redirect(array('controller' => 'products', 'action'=>'index'));
		}
		$this->set('product', $product);

		if (!empty($this->data)) {
			$this->data['Image']['product_id'] = $product_id;
			$this->data['Image']['order'] 	   = $this->Image->getLastOrderNumber($product_id);
			$this->Image->create();
			if ($this->Image->save($this->data)) {
				$this->Session->setFlash(__('The image has been added successfully.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index', $product_id));
			} else {
				$this->Session->setFlash(__('There was a problem adding the image please review the errors below and try again.', true));
			}
		}
	}

	function admin_saveorder($product_id = null) {
		Configure::write('debug', 0);
		$this->layout = 'js/ajax';
		if(!empty($product_id)){
			if(!empty($_POST)){
				$data = $_POST;

				foreach($data['image'] as $order => $id){
					$image['Image']['id'] = $id;
					$image['Image']['product_id'] = $product_id;
					$image['Image']['order'] = $order;

					// Turn off the validation since the upload image behavior
					// block the saving
					$this->Image->save($image, false);
				}
			}
			$this->set('message', __('The image order has been saved successfully.', true), 'default', array('class' => 'success'));
		}else{
			$this->set('message', __('Invalid product id', true));
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Image', true));
			$this->redirect(array('controller' => 'products', 'action'=>'index'));
		}
		$image = $this->Image->read(null, $id);
		if(empty($image)) {
			$this->Session->setFlash(__('The image ID was invalid.', true));
			$this->redirect(array('controller' => 'products', 'action'=>'index'));
		}

		if ($this->Image->delete($id)) {
			$this->Session->setFlash(__('The image was successfully deleted.', true), 'default', array('class' => 'success'));
		} else {
			$this->Session->setFlash(__('There was a problem deleting the image.', true));
		}
		$this->redirect(array('action'=>'index', $image['Product']['id']));
	}

	function admin_resize() {
		$weeds = array('.', '..', '.svn'); // these are directories I don't want to include
		$dir = WWW_ROOT.'img'.DS.'product_images'.DS;
		$images = array_diff(scandir($dir), $weeds);

		foreach($images as $image) {
			if(file($dir.$image)) {
				if(file_exists($dir.'thumbs'.DS.$image)) {
					unlink($dir.'thumbs'.DS.$image);
				}
				$this->admin_generate_thumbnail($dir.$image, $dir.'thumbs'.DS.$image, array('w' => $this->Setting->get('thumb_image_width'), 'h' => $this->Setting->get('thumb_image_height')), true);
				if(file_exists($dir.'max'.DS.$image)) {
					unlink($dir.'max'.DS.$image);
				}
				$this->admin_generate_thumbnail($dir.$image, $dir.'max'.DS.$image, array('w' => $this->Setting->get('max_image_width'), 'h' => $this->Setting->get('max_image_height')), true);
			}
		}

		$this->Session->setFlash(__('The images have been successfully thumbnailed.', true));
		$this->redirect(array('action'=>'index'));
	}

	function admin_generate_thumbnail($source = null, $target = null, $presets = null, $overwrite = true, $display = false)
	{
		$target_dir = substr($target, 0, -(strpos(strrev($target),'/')));

		if($source == null OR $target == null){//check correct params are set
			$this->addError("Both source[$source] and target[$target] must be set");
			return false;/*
		}elseif(!is_file($source)){//check source is a file
			$this->addError("Source[$source] is not a valid file");
			return false;
		}elseif(in_array($this->ImageTypeToMIMEtype($source), $this->allowed_mime_types)){//and is of allowed type
			$this->addError("Source[$source] is not a valid file type");
			return false;*/
		}elseif(!is_writable($target_dir)){//check if target directory is writeable
			$this->addError("Can not write to target directory [$target_dir]");
			return false;
		}elseif(is_file($target) AND !$overwrite){//check if target is a file already and not ok to be over written
			$this->addError("Target[$target] exsists and overwrite is not true");
			return false;
		}elseif(is_file($target) AND !is_writable($target)){
			$this->addError("Can not overwrite Target[$target]");
			return false;
		}

		//load PhpThumb
		App::import('Vendor', 'phpthumb'.DS.'phpthumb'); //update to this when RC2
		//vendor('phpthumb'.DS.'phpthumb');

		$phpThumb = new phpThumb();

		//set presets
		$phpThumb->config_nohotlink_enabled = false;
		$phpThumb->config_nooffsitelink_enabled = false;
		$phpThumb->config_prefer_imagemagick = true;
		$phpThumb->config_output_format = 'jpeg';
		$phpThumb->config_error_die_on_error = true;
		$phpThumb->config_allow_src_above_docroot = true;

		//optionals
		if(isset($this->max_cache_size)) $phpThumb->config_cache_maxsize = $this->max_cache_size;

		//load in source image
		$phpThumb->setSourceFilename($source);

		// lets set the default parameters
		$this->presets = array();
		$this->presets['q'] = 95; 			// jpeg output Quality - this can't be 100, 95 is the highest
		$this->presets['zc'] = 0;			// Zoom Crop
		$this->presets['far'] = 1;			// Fixed Aspect Ratio
		$this->presets['aoe'] = 1;			// Allow Uutput Enlargment

		if(!empty($presets)) {
			foreach($presets as $key => $preset) {
				$this->presets[$key] = $preset;
			}
		}

		foreach($this->presets as $key => $value) {
			if(isset($_GET[$key])) {
				$phpThumb->setParameter($key, $_GET[$key]);
			} else {
				if($value !== null) {
					$phpThumb->setParameter($key, $value);
				}
			}
		}

		//create the thumbnail
		if($phpThumb->generateThumbnail()){
			if(!$phpThumb->RenderToFile($target)){
				$this->addError('Could not render file to: '.$target);
			}elseif($display==true){
				$phpThumb->OutputThumbnail();
				die();//not perfect, i know but it insures cake doenst add extra code after the image.
			}
		} else {
			$this->addError('could not generate thumbnail');
		}

        // Change thumb permission, on suphp environment apache will not able to read the image
        // if the user not giving it (at least) 664 permission
        chmod($target, 0644);

		// if we have any errors, remove any thumbnail that was generated and return false
		if(!empty($this->errors)) {
		if(count($this->errors)>0){
				if(file_exists($target)){
					unlink($target);
				}
				return false;
			} else return true;
		} else return true;
	}
}
?>