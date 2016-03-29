<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$this->data['Testimonial']['id']);
echo $this->element('admin/crumb');
?>

<div class="auctions form">
<?php echo $form->create('Testimonial');?>
	<fieldset>
 		<legend><?php __('Edit a Testimonial');?></legend>

		<?php
			echo $form->input('id');
			echo $form->input('name', array('label' => 'Name *'));
			echo $form->input('location', array('label' => 'Location *'));
			echo $form->input('testimonial', array('label' => 'Testimonial *'));

			if($this->requestAction('/settings/get/testimonial_videos')) {
				if(!empty($this->data['Testimonial']['video'])) : ?>
					<p><?php echo $this->data['Testimonial']['video']; ?></p>
				<?php endif;
				echo $form->input('video', array('label' => 'Video'));
			}

			if($this->requestAction('/settings/get/testimonial_images')) {
				if(!empty($this->data['Testimonial']['image'])) : ?>
					<p><img src="/img/product_images/max/<?php echo $this->data['Testimonial']['image']; ?>"></p>
				<?php endif;
			}

			echo $form->input('approved');
		?>
	</fieldset>
<?php echo $form->end(__('Save Changes >>', true));?>
</div>
<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to testimonials', true), array('action' => 'index'));?></li>
	</ul>
</div>