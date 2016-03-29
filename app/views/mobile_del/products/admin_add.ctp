<?php
$html->addCrumb(__('Manage Auctions', true), '/admin/auctions');
$html->addCrumb(__('Products', true), '/admin/products');
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>

<div class="auctions form">
<?php echo $form->create('Product');?>
	<fieldset>
 		<legend><?php __('Add a Product');?></legend>

		<?php
			echo $form->input('title', array('label' => 'Title *'));
			echo $form->input('brief');
		?>

		<label for="PageContent"><?php __('Description');?></label>
		<?php echo $fck->input('Product.description'); ?>
		<p>&nbsp;</p>

		<?php
			echo $form->input('category_id', array('label' => 'Category *', 'empty' => 'Select Category'));
			echo $form->input('status_id', array('label' => 'Payment Status', 'empty' => 'Default', 'after' => ' The status the auction will be updated to after the payment has been made.'));
			echo $form->input('rrp', array('label' => 'RRP'));
			echo $form->input('start_price', array('label' => 'Start Price *'));

			if($this->requestAction('/settings/get/fixed_priced_auctions')) {
				echo $form->input('fixed', array('type' => 'checkbox', 'label' => 'Fixed Price Auction - The winner only pays the price you set here'));
				?>
				<div id="FixedPriceBlock"><?php echo $form->input('fixed_price');?></div>
				<?php
			}

			echo $form->input('delivery_cost');
			echo $form->input('delivery_information');
			echo $form->input('meta_description');
			echo $form->input('meta_keywords');
			echo $form->input('bids', array('label' => 'Free Bids'));
			echo $form->input('cash', array('label' => 'Cash Auction'));
			if($this->requestAction('/settings/enabled/buy_now')) {
				echo $form->input('exchange', array('label' => 'Buy Now Price'));
			}

			if($this->requestAction('/settings/enabled/reward_points')) {
				if($this->requestAction('/settings/get/rewards_store')) {
					echo $form->input('reward', array('type' => 'checkbox', 'label' => 'Reemable in Rewards Store'));
					?>
					<div id="RewardPointsBlock"><?php echo $form->input('reward_points');?></div>
					<?php
				}

				if($this->requestAction('/settings/get/win_points')) {
					echo $form->input('win_points', array('label' => __('Reward Points for Winning', true)));
				}
			}
		?>

	</fieldset>
<?php echo $form->end(__('Add Product >>', true));?>
</div>
<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to products', true), array('action' => 'index'));?></li>
	</ul>
</div>