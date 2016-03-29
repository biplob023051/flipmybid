<div class="col-md-12 auctions">
<div class="nav nav-tabs nav-justified">
<h2 style="margin: 9px 20px;"><?php __('Password Reminder');?></h2>
</div>
<div class="auction-content">
        <p><?php __('If you have forgotten your username or password simply enter in your email address below.');?></p>

		<p><?php __('We will email your username and a new password to you.');?></p>

		<?php echo $form->create('User', array('action' => 'reset','class'=>'form-horizontal'));?>
			<fieldset>
			
			<div class="form-group">
				<div class="col-sm-4 inner">
				<label for="UserEmail" class="control-label">Email Address <span>*</span></label>
				</div>
				<div class="col-sm-8 inner">
				<input name="data[User][email]" type="text" maxlength="80" value="" id="UserEmail" class="form-control input-md">				</div>
			</div>
			
			
			
			
			<div class="form-group">
			  <label class="col-md-4 control-label" for=""></label>
			  <div class="col-md-4">
				<input class="submit btn btn-register" type="submit" value="Retrieve Password" style="margin:0 auto;padding:12px !important;width:250px !important;">
			  </div>
			</div>			
			

				

			</fieldset>
		<?php echo $form->end();?>

		<p>
			<?php echo sprintf(__('%s ', true), $html->link(__('Register now', true), array('action'=>'register')));?>
			<?php echo sprintf(__('or %s.', true), $html->link(__('login to the website', true), array('action'=>'login')));?>
		</p>

	</div>
</div>
