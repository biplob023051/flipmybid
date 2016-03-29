<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(__('Landing Pages', true), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$this->data['Landing']['id']);
echo $this->element('admin/crumb');
?>

<div class="landings form">
<?php echo $form->create();?>
	<fieldset>
 		<legend><?php __('Edit a Landing Page');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('title', array('label' => __('Title *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('slug', array('label' => __('Slug *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('description', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4', 'style' => 'margin-bottom:10px;')));
		echo $form->input('product_id', array('label' => __('Product *', true), 'empty' => __('Select Product', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('meta_title', array('label' => __('Meta Title', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('meta_description', array('label' => __('Meta Description', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('meta_keywords', array('label' => __('Meta Keywords', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));

		?>
		<div class="clearfix"></div>
		<label for="LandingContent"><?php __('Content *');?></label>
		<?php
		echo $fck->input('Landing.content');
		echo $form->input('footer', array('label' => __('Footer', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		echo $form->input('show_auctions', array('label' => __('Show the ending soon auctions', true)));
		echo $form->input('closed_price', array('label' => __('Closed Auction Price', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
	?>
	</fieldset>
<?php echo $form->end(__('Save Changes', true));?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to landing page', true), array('action' => 'index'));?></li>
	</ul>
</div>
