<?php
$html->addCrumb('Manage Auctions', '/admin/auctions');
$html->addCrumb($auction['Product']['title'], '/admin/auctions/edit/'.$auction['Auction']['id']);
$html->addCrumb(__('Auction Increments', true), '/admin/increments/auction/'.$auction['Auction']['id']);
$html->addCrumb(__('Add Increment', true), '/admin/'.$this->params['controller'].'/add/'.$auction['Auction']['id']);
echo $this->element('admin/crumb');
?>
<h2><?php echo sprintf(__('Add an Increment for: %s', true), $auction['Product']['title']);?></h2>
<div class="auctions form">
<?php echo $form->create('Increment', array('action' => 'add/'.$auction['Auction']['id']));?>
	<fieldset>
		<?php
			echo $form->input('bid', array('label' => __('Bid Increment (bids)', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
			echo $form->input('price', array('label' => __('Price Increment (per bid)', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
			echo $form->input('time', array('label' => __('Time Increment (seconds)', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		?>
			<h2><?php __('Price Range'); ?></h2>

			<p><?php __('Set auction increments across different price ranges. For example, between 0.00 and 10.00, 10.00 and 20.00, 20.00 and 30.00 and so on.'); ?></p>
		<?php
			echo $form->input('low_price', array('label' => __('Low Price Range', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
			echo $form->input('high_price', array('label' => __('High Price Range', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		?>
	</fieldset>
<?php echo $form->end(__('Add Increment >>', true));?>
</div>
<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to increments', true), array('action' => 'auction', $auction['Auction']['id']));?></li>
	</ul>
</div>