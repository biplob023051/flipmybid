<?php
/*
CakePHP captcha Helper for Captcha Component :: Cakecaptcha
Version		:	1.0
Author		:	Ramandeep Singh
Website		:	http://www.designaeon.com
Created 	:	12 july 2012
compatible	:	cakePHP1.3

Description	:
This Helper is used with cakePHP captcha component to generate captchas.

*/
class CaptchaHelper extends AppHelper{

	var $helpers = array('Html', 'Form');
	private $captchaerror;	
	function __construct($settings = array()){
		if(isset(ClassRegistry::getObject('view')->viewVars['captchaerror'])){
			$this->viewVars = ClassRegistry::getObject('view')->viewVars['captchaerror'];
			$this->captchaerror=$this->viewVars;
			}
		else{
			$this->captchaerror=false;
			}		
	
	}

	function input($controller=null){
		if(is_null($controller)) { 
            $controller = $this->params['controller']; 
        } 
		$output=$this->writeCaptcha($controller);
		return $output;
	}
	protected function writeCaptcha($controller){
		echo $this->Html->image($this->Html->url(array('controller'=>$controller,'action'=>'captcha'),true),array('id'=>'cakecaptcha', 'style' => ''));
		echo "<br/>";
		?>
		
		
        <span style="">Please enter the code above</span><a href="#captcha" onclick="document.getElementById('cakecaptcha').src='<?php echo $this->Html->url(array('controller'=>$controller,'action'=>'captcha')); ?>?'+Math.random();
    document.getElementById('captcha-form').focus();"
    id="change-image">Reload Image</a><br/>
        <?php
            echo $this->Form->input('cakecaptcha',array('id'=>'captcha-form','name'=>'data[cakecaptcha][captcha]','label'=>''));
            if($this->captchaerror) {echo "<div class='error'><div class='error-message'>".$this->captchaerror."</div></div>";}
            
            
	}
}
?>