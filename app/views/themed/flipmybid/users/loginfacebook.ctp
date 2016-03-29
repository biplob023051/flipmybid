<div class="g1">
        <div id="auctions-easyview" class="rounded">
            <div id="tabs">
                <h2>Login or Register!</h2>
            </div>
            <div class="g2 left">
				<?php echo $testvar; ?>
				<?php echo $form->create('User', array('action' => 'facebook'));?>
					<?php echo $form->submit('Sign in With Facebook',array('div'=>false, 'class'=>'facebook-btn'));?></li>
				<?php echo $form->end(); ?>
				<!--<button class="facebook-btn" href="#">Sign in with Facebook</button>-->
				<?php echo $this->Html->link('Sign in with Facebook',array('controller' => 'users',	'action' => 'facebook',	'full_base' => true,),array('class' => 'facebook-btn'));?>
            </div>
            <div class="g2">

            </div>
        </div>
        <!--/ Auctions -->
    </div>
