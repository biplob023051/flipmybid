<?php class FckHelper extends Helper {
    
    var $helpers = Array('Html');
    
    function input($field, $width = 400) {
        $field = explode('.', $field);
        if(empty($field[1])) {
        	// need to know how to call a model from a helper
        } else {
        	$model = $field[0];
        	$controller = $field[1];
        }
        
        require_once WWW_ROOT.DS.'js'.DS.'fckeditor'.DS.'fckeditor.php';
		$oFCKeditor = new FCKeditor('data['.$model.']['.$controller.']') ;
		$oFCKeditor->BasePath	= '/js/fckeditor/';
		$oFCKeditor->Value		= $this->data[$model][$controller];
		$oFCKeditor->Height		= $width;
		$oFCKeditor->Create();   
    }
}
?>