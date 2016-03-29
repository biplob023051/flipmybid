<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>
<?php __('Add a Membership Level');?></h2>
<div class="memberships form">

<?php echo $form->create('Membership', array('type' => 'file'));?>
	<fieldset>
	<?php
		echo $form->input('name', array('label' => __('Name *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('description');
		echo $form->input('rank', array('label' => __('Rank *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('default', array('label' => __('Default Membership - the initial membership level when users register.', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));

		if($this->requestAction('settings/enabled/reward_points')) {
			echo $form->input('points', array('label' => __('Reward Points Required *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));

			if($this->requestAction('settings/get/rewards_store ')) {
				echo $form->input('rewards', array('label' => __('Users can purchase from the rewards store', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
			}
		}

		if($this->requestAction('settings/get/beginner_auctions')) {
			echo $form->input('beginner', array('label' => __('Users can bid on beginner auctions', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		}
	?>
	<?php echo $form->input('image', array('type' => 'file'));?>
	</fieldset>
<?php echo $form->end(__('Add Membership >>', true));?>
</div>

<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to categories', true), array('action' => 'index'));?></li>
	</ul>
</div>
