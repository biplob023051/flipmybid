<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>

<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Add a User');?></legend>
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
		if(!empty($appConfigurations['taxNumberRequired'])) {
			echo $form->input('tax_number');
		}
		echo $form->input('newsletter', array('label' => 'Receive the newsletter?'));
		echo $form->input('goldmember', array('label' => 'This user is a Gold Member'));
	?>
	</fieldset>
<?php echo $form->end(__('Add User', true));?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to users', true), array('action' => 'index')); ?> </li>
	</ul>
</div>
