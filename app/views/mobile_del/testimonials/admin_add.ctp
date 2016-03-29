<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>

<div class="auctions form">
<?php echo $form->create('Testimonial');?>
	<fieldset>
 		<legend><?php __('Add a Testimonial');?></legend>

		<?php
			echo $form->input('auction_id', array('label' => 'Auction *', 'empty' => 'Select'));
			echo $form->input('name', array('label' => 'Name *'));
			echo $form->input('location', array('label' => 'Location *'));
			echo $form->input('testimonial', array('label' => 'Testimonial *'));
		?>
	</fieldset>
<?php echo $form->end(__('Add Testimonial >>', true));?>
</div>
<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to testimonials', true), array('action' => 'index'));?></li>
	</ul>
</div>