<div class="col-md-3 col-sm-12 col-xs-12 g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-9 col-sm-12 col-xs-12 g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Edit Profile');?></h2>
		</div>
		<div class="account">
			<div class="">
				<?php echo $form->create('User');?>
				<fieldset>
					<?php
						echo $form->input('first_name', array('label' => 'First Name *', 'class' => 'form-control'));
						echo $form->input('last_name', array('label' => 'Last Name *', 'class' => 'form-control'));
						echo $form->input('email', array('label' => 'Email *', 'class' => 'form-control'));
						echo $form->input('date_of_birth', array(
								'label' => 'Date of Birth',
								'minYear' => $appConfigurations['Dob']['year_min'],
								'maxYear' => $appConfigurations['Dob']['year_max'],
										'separator' => '<div style="padding-top:2px;"></div>',
								'class' => 'form-control')
						);
						echo $form->input('gender_id', array('label' => 'Gender *', 'class' => 'form-control'));
						echo $form->submit(__('Save Changes', true), array('class' => 'submit center-button', 'div' => false));
						echo $form->end();
					?>
				</fieldset>
			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>
