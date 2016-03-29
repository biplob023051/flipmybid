<div id="left">
    <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Edit Profile');?></h1>
		<?php echo $form->create('User');?>
		<fieldset>
			<?php
				echo $form->input('first_name', array('label' => 'First Name *'));
				echo $form->input('last_name', array('label' => 'Last Name *'));
				echo $form->input('email', array('label' => 'Email *'));
				echo $form->input('date_of_birth', array('label' => 'Date of Birth',  'minYear' => $appConfigurations['Dob']['year_min'], 'maxYear' => $appConfigurations['Dob']['year_max']));
				echo $form->input('gender_id', array('label' => 'Gender *'));
				echo $form->end('Save Changes');
			?>
		</fieldset>
	</div>
</div>
