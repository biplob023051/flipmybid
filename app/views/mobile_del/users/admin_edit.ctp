<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$this->data['User']['id']);
echo $this->element('admin/crumb');
?>

<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit a User');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('username');
		echo $form->input('first_name');
		echo $form->input('last_name');
		echo $form->input('email');

		if($this->requestAction('/settings/enabled/memberships')) {
			echo $form->input('membership_id', array('label' => __('Membership Level', true), 'empty' => __('None', true)));
		}

		echo $form->input('date_of_birth', array('minYear' => $appConfigurations['Dob']['year_min'], 'maxYear' => $appConfigurations['Dob']['year_max'], 'label' => 'Date of Birth'));
		echo $form->input('gender_id', array('type' => 'select', 'label' => 'Gender'));
		echo $form->input('newsletter', array('label' => 'Receive the newsletter?'));

		if($this->data['User']['id'] !== $session->read('Auth.User.id')) :
			echo $form->input('active');
			echo $form->input('deleted');
		endif;
	?>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>

<div class="actions">
	<ul>
		<?php echo $this->element('admin/user_links', array('id' => $this->data['User']['id'])); ?>
	</ul>
</div>
