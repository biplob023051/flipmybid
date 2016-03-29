<div class="col-md-3 userform">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-8 auctions">
		<!-- <div id="auctions" class="rounded"> -->
			<div class="nav nav-tabs nav-justified m-none">
				<h2 style="margin: 9px 20px;"><?php __('Edit Profile');?></h2>
			</div>
		<div class="auction-content">
				<?php echo $form->create('User');?>
				<fieldset>
					<?php
						echo $form->input('first_name', array('label' => 'First Name *'));
						echo $form->input('last_name', array('label' => 'Last Name *'));
						echo $form->input('email', array('label' => 'Email *'));
						echo $form->input('date_of_birth', array('label' => 'Date of Birth',  'minYear' => $appConfigurations['Dob']['year_min'], 'maxYear' => $appConfigurations['Dob']['year_max']));
						echo $form->input('gender_id', array('label' => 'Gender *'));
						echo $form->submit(__('Save Changes', true), array('class' => 'submit', 'div' => false));
						echo $form->end();
					?>
				</fieldset>
			
		</div>
		<div class="inner">
			<h4 class="heading"><a href="/users/changepassword">Change password</a></h4>
		<h4 class="heading"><a href="/addresses">Change address</a></h4>

</div>
	</div>
	<!--/ Auctions -->
</div>
