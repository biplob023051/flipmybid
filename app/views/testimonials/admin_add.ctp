<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>
<h2><?php __('Add a Testimonial');?></h2>

<div class="auctions form">
<?php echo $form->create('Testimonial');?>
	<fieldset>
		<?php
			echo $form->input('auction_id', array('label' => 'Auction *', 'empty' => 'Select', 'class' => 'form-control', 'div' => array('class' => 'col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4')));
			echo $form->input('name', array('label' => 'Name *', 'class' => 'form-control', 'div' => array('class' => 'col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4')));
			echo $form->input('location', array('label' => 'Location *', 'class' => 'form-control', 'div' => array('class' => 'col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4')));
			echo $form->input('testimonial', array('label' => 'Testimonial *', 'class' => 'form-control', 'div' => array('class' => 'col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4')));
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