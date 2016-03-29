<div class="col-md-12 auctions">
	<div class="">
	<h2 style="margin: 9px 20px;"><?php __('Change Password');?></h2>
		</div>
		<div class="auction-content">
			<div class="">
			<fieldset>
			<?php echo $form->create('User', array('url' => '/users/changepassword'));?>
			<div style="display:none;"><input type="hidden" name="_method" value="PUT"></div>
			<p><?php echo __('To change your password enter in your old password and your new password twice.'); ?></p>
			
			<div class="form-group input password required error">
				<div class="col-sm-4 inner"><label for="UserOldPassword" class="control-label">Old Password</label></div>
				<div class="col-sm-8 inner"><input name="data[User][old_password]" type="password" value="" id="UserOldPassword" class="form-control input-md form-error"></div>
				<!--<div class="error-message">Please enter in your old password.</div>-->
			</div>
			
			<div class="form-group">
				<div class="col-sm-4 inner"><label for="UserBeforePassword" class="control-label">New Password</label></div>
				<div class="col-sm-8 inner"><input name="data[User][old_password]" type="password" value="" id="UserOldPassword" class="form-control input-md form-error"></div>
				<!--<div class="error-message">Password is a required field.</div>-->
			</div>			

			<div class="form-group">
				<div class="col-sm-4 inner"><label for="UserRetypePassword" class="control-label">Retype Password</label></div>
				<div class="col-sm-8 inner"><input name="data[User][old_password]" type="password" value="" id="UserOldPassword" class="form-control input-md form-error"></div>
				<!--<div class="error-message">Retype Password is a required field.</div>-->
			</div>				

			<div class="form-group">
			<div class="col-md-6">
				<button type="submit" class="btn btn-register" style="margin:0 auto;padding:12px !important;width:250px !important;">Change Password</button>
			</div>
			</div>
			
			</fieldset>				
				
			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>
