<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Edit Profile');?></h2>
		</div>
		<div class="account">
			<div class="">
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
		</div>
	</div>
	<!--/ Auctions -->
</div>
