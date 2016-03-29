<?php
/**
 * Custom error handler which support themeable view
 */
class AppError extends ErrorHandler {
	function __construct($method, $messages) {
        $this->controller = new AppController();
		$params = Router::getParams();

		App::import('Controller','Settings');
		$this->SettingsController = new SettingsController();
		$this->SettingsController->constructClasses();

        // Setup the view path using main theme
        $viewPath = 'errors';
        if($this->controller->view == 'Theme') {
			$theme 	= $this->SettingsController->get('theme');

			if(!empty($theme)) {
				$viewPath = 'themed'.DS.$theme.DS.'errors';
			} else {
				$viewPath = 'errors';
			}
        }

		$this->appConfigurations['name'] = $this->SettingsController->get('site_name');
		$this->controller->set('appConfigurations', $this->appConfigurations);

        // If debug equal to 0 then all error should be 404
        if($this->SettingsController->get('debug') == 0){
            $method = 'error404';
        }

        $checkView = VIEWS.$viewPath.DS.Inflector::underscore($method).'.ctp';
		if (file_exists($checkView)) {
            $this->controller->_set(Router::getPaths());
			$this->controller->viewPath  = $viewPath;
            $this->controller->theme     = $theme;
			$this->controller->set('title_for_layout', __('Error', true));
            // Set the message to error page
            $this->controller->set('message', $messages[0]['url']);

			$this->controller->render($method);
			e($this->controller->output);
		}else{
            parent::__construct($method, $messages);
        }
	}
}
?>