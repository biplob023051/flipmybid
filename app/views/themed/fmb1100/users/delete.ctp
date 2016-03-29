<div class="col-md-12 auctions">
<div class="nav nav-tabs nav-justified">
<h2 style="margin: 9px 20px;"><?php __('Delete Account');?></h2>
		</div>
		<div class="auction-content">
			
				<p><?php __('Are you sure you want to delete your account?');?></p>

				<p><?php __('This action cannot be undone and any remaining bids in your account will be lost.');?></p>

				<p><?php __('Please confirm your password to delete your account:');?></p>


			
			
		
			<fieldset>
				<?php echo $form->create('User', array('url' => '/users/delete','class'=>'form-horizontal'));?>
			<div class="form-group">
				<div class="col-sm-4 inner">
				<label for="UserOldPassword" class="control-label">Confirm Password</label>
				</div>
				<div class="col-sm-8 inner">
				<input name="data[User][old_password]" type="password" maxlength="80" value="" id="UserOldPassword" class="form-control input-md">				</div>
			</div>
			
			
			
			
			<div class="form-group">
			  <label class="col-md-4 control-label" for=""></label>
			  <div class="col-md-4">
				<input class="submit btn btn-register" type="submit" value="Delete my account now" style="margin:0 auto;padding:12px !important;width:250px !important;">
			  </div>
			</div>			
			

				
				<?php echo $form->end();?>
			</fieldset>
		


		
		</div>
	</div>
	<!--/ Auctions -->
</div>