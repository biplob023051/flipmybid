<?php
$html->addCrumb(__('Manage Auctions', true), '/admin/auctions');
$html->addCrumb(__('Products', true), '/admin/products');
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$id.'/'.$language);
echo $this->element('admin/crumb');
?>
<h2><?php __('Edit a Product');?></h2>
<div class="auctions form">
<?php echo $form->create('Product', array('url' => '/admin/products/edit/'.$id.'/'.$language));?>
	<fieldset>
		<?php
			echo $form->input('title', array('label' => 'Title *','class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
			echo $form->input('brief', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
		?>
<div class="clearfix"></div>
		<label for="PageContent"><?php __('Description');?></label>
		<?php echo $fck->input('Product.description'); ?>
		<p>&nbsp;</p>

		<?php
			if(empty($language)) {
				echo $form->input('category_id', array('label' => 'Category *', 'empty' => 'Select Category','class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
				echo $form->input('status_id', array('label' => 'Payment Status', 'empty' => 'Default',
						'after' => '<p style="padding-top:10px;"> The status the auction will be updated to after the payment has been made. </p>', 'class' => 'form-control',
						'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
				echo $form->input('rrp', array('label' => 'RRP', 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
				echo $form->input('start_price', array('label' => 'Start Price *', 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
				if($this->requestAction('/settings/get/fixed_priced_auctions')) {
					echo $form->input('fixed', array('type' => 'checkbox', 'label' => 'Fixed Price Auction - The winner only pays the price you set here'));
					?>
					<div id="FixedPriceBlock"><?php echo $form->input('fixed_price');?></div>
					<?php
				}
				echo $form->input('delivery_cost', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4', 'style' => 'margin-bottom:10px;')));
			}

			echo $form->input('delivery_information', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4', 'style' => 'margin-bottom:10px;')));
			echo $form->input('meta_description', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4', 'style' => 'margin-bottom:10px;')));
			echo $form->input('meta_keywords', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4', 'style' => 'margin-bottom:10px;')));
			if(empty($language)) {
				echo $form->input('bids', array('label' => 'Free Bids', 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4', 'style' => 'margin-bottom:10px;')));
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
			}
		?>
	</fieldset>
<?php echo $form->end(__('Save Changes >>', true));?>
</div>
<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to products', true), array('action' => 'index'));?></li>
	</ul>
</div>