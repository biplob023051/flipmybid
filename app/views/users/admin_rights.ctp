<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Admin Rights', true), '/admin/'.$this->params['controller'].'/rights/'.$this->data['User']['id']);
echo $this->element('admin/crumb');
?>
<h2><?php __('Edit a User');?></h2>
<?php echo $form->create('User', array('url' => '/admin/users/rights/'.$this->data['User']['id']));?>
	<fieldset>
	<?php
		echo $form->input('id');
		if($this->data['User']['id'] !== $session->read('Auth.User.id')) {
			echo $form->input('admin', array('label' => 'Grant this user admin rights?'));
		}
		echo $form->input('translator', array('label' => 'Grant this user translator rights?'));
	?>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>

<div class="actions">
	<ul>
		<?php echo $this->element('admin/user_links', array('id' => $this->data['User']['id'])); ?>
	</ul>
</div>
