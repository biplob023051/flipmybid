<p style="margin: 20px 0 0 0;">
	<?php echo $html->image('banner-how-it-works.png');?>
</p>

<div id="register-form" class="boxed" style="background-position:bottom; background-repeat:repeat-x;">

<div class="content">
	<div class="form">
		<?php echo $form->create('User', array('action' => 'register'));?>
		<div class="col1">
			<?php if($this->requestAction('/settings/enabled/facebook_login') && $this->requestAction('/settings/get/facebook_app_id')) : ?>
				<h2><?php __('Register with your Facebook Details'); ?></h2>
				<p><a href="/users/facebook"><?php echo $html->image('facebook-icon.gif'); ?></a></p>
				<hr size="1">
			<?php endif; ?>

			<fieldset>
				<?php
					echo $form->input('username', array('label' => 'Username <span class="required">*</span>', 'div' => 'input text required', 'after' => '<div id="usernameCheck" class="error-message"></div>'));
					echo $form->input('gender_id', array('type' => 'select', 'label' => 'Gender'));
					echo $form->input('first_name', array('label' => 'First Name <span class="required">*</span>', 'div' => 'input text required'));
					echo $form->input('last_name', array('label' => 'Last Name <span class="required">*</span>', 'div' => 'input text required'));
					echo $form->input('before_password', array('value' => '', 'type' => 'password', 'label' => 'Password <span class="required">*</span>', 'div' => 'input text required', 'after' => '<div id="passwordCheck" class="error-message"></div>'));
					echo $form->input('retype_password', array('value' => '', 'type' => 'password', 'label' => 'Retype Password <span class="required">*</span>', 'div' => 'input text required', 'after' => '<div id="retypePasswordCheck" class="error-message"></div>'));
					echo $form->input('newsletter', array('label' => 'Sign up for the newsletter?'));
					echo $form->input('terms', array('type' => 'checkbox', 'label' => 'Read & accept the <a rel="facebox" href="#terms-text">terms</a>?'));
					echo $form->input('email', array('label' => 'Email <span class="required">*</span>', 'div' => 'input text required', 'after' => '<div id="emailCheck" class="error-message"></div>'));
					echo $form->input('confirm_email', array('label' => 'Confirm Email <span class="required">*</span>', 'div' => 'input text required', 'after' => '<div id="confirmEmailCheck" class="error-message"></div>'));
					echo $form->input('date_of_birth', array('minYear' => $appConfigurations['Dob']['year_min'], 'maxYear' => $appConfigurations['Dob']['year_max'], 'label' => 'Date of Birth'));

					if($this->requestAction('/settings/enabled/referrals') && empty($this->data['User']['hideReferral'])) {
						echo $form->input('referrer', array('label' => 'Referred By (optional)', 'div' => 'input text required', 'after' => '<div id="usernameCheck" class="error-message"></div>'));
					}
					?>

					<?php if($this->requestAction('/settings/get/registration_options') && empty($registerTracking) && $this->requestAction('/referrals/show_sources')) : ?>
						<div class="input text required">
							<label><?php __('How did you find us? <span class="required">*</span>');?></label>
							<div class="radio-group">
								<?php echo $form->hidden('source_id', array('value' => ''));?>
								<?php foreach($sources as $source):?>
									<input type="radio" <?php if(!empty($this->data['User']['source_id']) && $this->data['User']['source_id'] == $source['Source']['id']) echo 'checked="checked"';?> title="<?php echo $source['Source']['extra'];?>" id="source_<?php echo $source['Source']['id'];?>" name="data[User][source_id]" value="<?php echo $source['Source']['id'];?>"/>
									<?php echo $source['Source']['name'];?> <br />
								<?php endforeach;?>
								<?php echo $form->error('source_id');?>

								<div id="sourceExtraBlock" style="display: none">
									<?php echo $form->input('source_extra', array('id' => 'sourceExtra', 'label' => __('Site Name *', true)));?>
								</div>
							</div>
						</div>
					<?php endif; ?>
			</fieldset>
		</div>

		<div class="submit clearfix">
			<?php echo $form->submit('b-register-b.png', array('div' => false, 'value' => __('Register Now', true)));?>
		</div>
		<?php echo $form->end();?>
	</div>

	<div id="terms-text" style="display: none;">
		<h3>Terms &amp; Conditions</h3>
		<?php $terms = $this->requestAction('/pages/getpage/terms-and-conditions'); ?>
		<?php if(!empty($terms)) : ?>
			<?php echo $terms['Page']['content']; ?>
		<?php endif; ?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.radio-group input').click(function(){
			if($(this).attr('title')){
				if($(this).attr('title') == 1){
					$('#sourceExtraBlock').show(1);
				}else{
					$('#sourceExtraBlock').hide(1);
					$('#sourceExtra').val('');
				}
			}
		});

		if($('.radio-group input:checked').attr('title') == 1){
			$('#sourceExtraBlock').show(1);
		}

		$('#UserUsername').change(function(){
			var content = 'content=' + $('#UserUsername').val();
			$.ajax({
				url: '/users/ajaxCheck/username',
                type: 'POST',
				dataType: 'json',
                data: content,
                success: function(data){
					if(data.result == 1){
						$('#usernameCheck').html('<img src="/img/tick.png" alt="Username Available"/>' + data.message);
					}else{
						$('#usernameCheck').html('<img src="/img/cross.png" alt="Username Already Taken"/>' + data.message);
					}
				}
			});
		});

		$('#UserBeforePassword').change(function(){
			var content = 'content=' + $('#UserBeforePassword').val();
			$.ajax({
				url: '/users/ajaxCheck/password',
                type: 'POST',
				dataType: 'json',
                data: content,
                success: function(data){
					if(data.result == 1){
						$('#passwordCheck').html('<img src="/img/tick.png" alt="Password is valid"/>' + data.message);
					}else{
						$('#passwordCheck').html('<img src="/img/cross.png" alt="Password is not valid"/>' + data.message);
					}
				}
			});
		});

		$('#UserRetypePassword').change(function(){
			var content = 'content=' + $('#UserRetypePassword').val() + '&content2=' + $('#UserBeforePassword').val();
			$.ajax({
				url: '/users/ajaxCheck/retypePassword',
                type: 'POST',
				dataType: 'json',
                data: content,
                success: function(data){
					if(data.result == 1){
						$('#retypePasswordCheck').html('<img src="/img/tick.png" alt="Password and Retype Password Match"/>' + data.message);
					}else{
						$('#retypePasswordCheck').html('<img src="/img/cross.png" alt="Password and Retype Password Not Match"/>' + data.message);
					}
				}
			});
		});

		$('#UserEmail').change(function(){
			var content = 'content=' + $('#UserEmail').val();
			$.ajax({
				url: '/users/ajaxCheck/email',
                type: 'POST',
				dataType: 'json',
                data: content,
                success: function(data){
					if(data.result == 1){
						$('#emailCheck').html('<img src="/img/tick.png" alt="Email Available"/>' + data.message);
					}else{
						$('#emailCheck').html('<img src="/img/cross.png" alt="Email Already Used by Another User"/>' + data.message);
					}
				}
			});
		});

		$('#UserConfirmEmail').change(function(){
			var content = 'content=' + $('#UserConfirmEmail').val() + '&content2=' + $('#UserEmail').val();
			$.ajax({
				url: '/users/ajaxCheck/confirmEmail',
                type: 'POST',
				dataType: 'json',
                data: content,
                success: function(data){
					if(data.result == 1){
						$('#confirmEmailCheck').html('<img src="/img/tick.png" alt="Email and Confirm Email Match"/>' + data.message);
					}else{
						$('#confirmEmailCheck').html('<img src="/img/cross.png" alt="Email and Confirm Email Not Match"/>' + data.message);
					}
				}
			});
		});
	});
</script>