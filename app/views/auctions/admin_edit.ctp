<?php
$html->addCrumb('Manage Auctions', '/admin/auctions');
$html->addCrumb($product['Product']['title'], '/admin/products/edit/'.$product['Product']['id']);
$html->addCrumb('Edit Auction', '/admin/'.$this->params['controller'].'/edit/'.$this->data['Auction']['id']);
echo $this->element('admin/crumb');
?>
<?php $dummySet = 0; ?>

<div class="auctions form">
<?php echo $form->create('Auction', array('url' => '/admin/auctions/edit/'.$this->data['Auction']['id']));?>
	<fieldset>
 		<legend><?php echo sprintf(__('Edit an Auction for: %s', true), $product['Product']['title']);?></legend>
		<?php
			echo $form->input('id');
		echo $form->input('start_time', array('timeFormat' => '24', 'label' =>  __('Start Time *', true),
			'separator' => '<div style="padding-top:2px;"> - </div>', 'class' => 'form-control',
			'div' => array('class' => 'col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4')));
		echo '<div class="clearfix"></div>';
		echo $form->input('end_time', array('timeFormat' => '24', 'label' => __('End Time *', true), 'class' => 'form-control', 'div' => array('class' => 'col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4')));
		echo '<div class="clearfix"></div>';

			if($this->requestAction('/settings/enabled/win_limits') || $dummySet) {
				echo $form->input('limit_id', array('label' => __('Win Limits', true), 'empty' => __('None', true), 'class' => 'form-control', 'div' => array('class' => 'col-sm-4 col-md-4')));
			}

			if($this->requestAction('/settings/enabled/memberships') || $dummySet) {
				echo $form->input('membership_id', array('label' => __('Membership Level', true), 'empty' => __('None', true), 'class' => 'form-control', 'div' => array('class' => 'col-sm-3 col-md-3')));
			}

		if(($this->requestAction('/settings/enabled/max_auction_time') && $this->requestAction('/settings/get/max_auction_time')) || $dummySet) {
			echo $form->input('max_time', array('label' => __('Max Auction Time', true),'style' => 'margin-top:-2px;', 'class' => 'form-control', 'div' => array('class' => 'col-sm-3 col-md-3')));
		}

			if($this->requestAction('/settings/get/reserve_price') || $dummySet) :
				echo '<div class="clearfix"></div>';
				echo $form->input('reserve', array('id' => 'reserve', 'style' => 'float:left;', 'label' => __('Reserve - set a reserve price on the auction', true), 'class' => 'form-control', 'div' => array('class' => 'col-sm-6 col-md-6')));
				?>
				<div id="reserveBlock" style="display: none">
					<div class="clearfix"></div>
					<?php echo $form->input('reserve_price', array('label' => __('Reserve Price', true), 'class' => 'form-control', 'div' => array('class' => 'col-sm-4 col-md-4'))); ?>
				</div>
				<?php
			endif;
			?>
		</fieldset>
	<fieldset class="col-md-12 auction-settings" style="text-align: left; padding-left:20px;" >
		<div class="col-md-12">
			<?php
			if($this->requestAction('/settings/enabled/autolisting') || $dummySet) :
				echo $form->input('autolist', array(
					'id' => 'autolist',
					'label' => __('Autolist this auction - it will be automatically listed once it closes.', true)
				,'style' => 'margin-top:-2px;'
					));
				?>
				<div id="autolistBlock" style="display: none">
					<?php echo $form->input('autolist_time', array(
						'type' => 'time',
						'timeFormat' => '24',
						'label' => __('Daily End Time', true),'style' => 'margin-top:6px;')); ?>
					<?php echo $form->input('autolist_minutes', array('label' => __('Auto relist x minutes later', true),'class' => 'form-control','style' => 'margin-top:-2px;')); ?>
				</div>
				<?php
			endif;

			if($this->requestAction('/settings/enabled/testing_mode') || $dummySet) :
				echo $form->input('autobid', array('id' => 'autobid', 'label' => __('Testing Mode - allow autobidders to bid on this auction', true),'style' => 'margin-top:-2px;'));
				?>
				<div id="autobidBlock" style="display: none">
					<p><?php __('Testing mode allows you to set test auctions with automatic bidding. The auction will run until either the number of autobid bids are meet or the number of real bids are meet.'); ?></p>

					<p><?php __('By setting the autobids to zero the auction will continue until a real user wins.  Likewise by setting the real bids to zero will only allow an autobidder to win.'); ?></p>

					<?php echo $form->input('autobids', array('label' => __('Number of autobids', true), 'class' => 'form-control')); ?>
					<?php echo $form->input('realbids', array('label' => __('Number of real bids', true), 'class' => 'form-control')); ?>

					<?php if($this->requestAction('/settings/get/randomize_autobids')): ?>
						<?php echo $form->input('min_autobids', array('label' => __('Minimum Number of autobids', true),'class' => 'form-control','style' => 'margin-top:-2px;')); ?>
						<?php echo $form->input('max_autobids', array('label' => __('Maximum Number of autobids', true),'class' => 'form-control','style' => 'margin-top:-2px;')); ?>

						<?php echo $form->input('min_realbids', array('label' => __('Minimum Number of real bids', true),'class' => 'form-control','style' => 'margin-top:-2px;')); ?>
						<?php echo $form->input('max_realbids', array('label' => __('Maximum Number of real bids', true),'class' => 'form-control','style' => 'margin-top:-2px;')); ?>
					<?php else: ?>
						<?php echo $form->input('autobids', array('label' => __('Number of autobids', true),'style' => 'margin-top:-2px;')); ?>
						<?php echo $form->input('realbids', array('label' => __('Number of real bids', true),'style' => 'margin-top:-2px;')); ?>
					<?php endif;
					if($this->requestAction('/settings/get/allow_zero') || $dummySet) {
							echo $form->input('allow_zero', array('label' => __('Allow this auction to close with no bids being placed.', true),'style' => 'margin-top:-2px;'));
						}
					?>
				</div>
				<?php
			endif;


			if($this->requestAction('/settings/get/beginner_auctions') || $dummySet) {
				echo $form->input('beginner', array('label' => __('Beginner Auction - Only allow users who have not won before to win.', true),'style' => 'margin-top:-2px;'));
			}

			if($this->requestAction('/settings/get/nail_biters') || $dummySet) {
				echo $form->input('nail_biter', array('label' => __('Nail Biter - Bid Buddies will not be allowed on this auction.', true),'style' => 'margin-top:-2px;'));
			}

			if($this->requestAction('/settings/get/free_auctions') || $dummySet) {
				echo $form->input('free', array('label' => __('Free Auction - The winner is not required to pay for this auction.', true),'style' => 'margin-top:-2px;'));
			}

			if($this->requestAction('/settings/get/reverse_auctions') || $dummySet) {
				echo $form->input('reverse', array('id' => 'reverse', 'label' => __('Reverse Auction - Make this auction a reverse auction.', true),'style' => 'margin-top:-2px;'));
				?>
				<div id="reverseBlock" style="display: none">
					<?php echo $form->input('price_past_zero', array('label' => __('Allow the price to go into the negatives - i.e the website will pay the user the money back!', true),'style' => 'margin-top:-2px;')); ?>
					<?php echo $form->input('reverse_extend', array('label' => __('Limit time after zero', true),'class' => 'form-control', 'after' => __(' seconds - Set to 0 for no time limit.', true),'style' => 'margin-top:-2px;')); ?>
				</div>
				<?php
			}

			if($this->requestAction('/settings/get/bids_back_winner') || $dummySet) {
				echo $form->input('bids_back_winner', array('label' => __('Bids Back Winner - give the winner there bids back.', true),'style' => 'margin-top:-2px;'));
			}

			if($this->requestAction('/settings/get/bids_back_most_bids') || $dummySet) {
				echo $form->input('bids_back_most_bids', array('label' => __('Bids Back Most Bids - give the user who bid the most there bids back.', true),'style' => 'margin-top:-2px;'));
			}

			if($this->requestAction('/settings/get/bids_back_random') || $dummySet) {
				echo $form->input('bids_back_random', array('id' => 'bidsBack', 'label' => __('Bids Back Random - give a random user there bids back.', true),'style' => 'margin-top:-2px;'));
				?>
				<div id="bidsBackBlock" style="display: none">
					<?php echo $form->input('bids_back_total', array('label' => __('Total Bids Back', true), 'after' => __(' Set to 0 to give the users total bids back', true),'class' => 'form-control','style' => 'margin-top:-2px;')); ?>
				</div>
				<?php
			}

			if($this->requestAction('/settings/get/charity_auctions') || $dummySet) {
				echo $form->input('charity', array('label' => __('Set this auction as a Charity Auction', true),'style' => 'margin-top:-2px;'));
			}

			echo $form->input('featured', array('label' => __('Featured Auction - Show this auction on the home page.', true),'style' => 'margin-top:-2px;'));
			echo $form->input('active', array('label' => __('Active - show this auction on the website.', true),'style' => 'margin-top:-2px;'));

			if($this->requestAction('/settings/enabled/auction_increments') || $dummySet) {
				echo $form->input('increments', array('type' => 'checkbox', 'label' => __('Set dynamic auction increments on this auction.', true),'style' => 'margin-top:-2px;'));
			}
			
			// Change by Andrew Buchan - add elements for the buy it price functionality
			echo $form->input('buy_it', array('id' => 'buy_it', 'label' => __('Buy It - Enable Buy It Price on this auction.', true),'style' => 'margin-top:-2px;'));
			?>
			<div id="buy_itblock" style="display: none">
			<?php echo $form->input('buy_it_reduction_amount', array('label' => __('', true), 'after' => __(' Amount to deduct per user bid.', true),'class' => 'form-control','style' => 'margin-top:2px;')); ?>
			</div>
			<?php
			// End Change
			
		?>
	</fieldset>
<?php //echo $form->end(__('Save Changes >>', true));?>
	<div class="clearfix"></div>
	<div class="submit">
		<input type="submit" value="Save Changes >>" style="margin-left:auto;padding:10px;text-align: center;">
	</div>
</div>
<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to products', true), array('controller' => 'products', 'action' => 'index'));?></li>
		<li><?php echo $html->link(__('<< Back to auctions', true), array('action' => 'index'));?></li>
	</ul>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#reserve').click(function(){
			if($('#reserve').is(':checked')){
				$('#reserveBlock').show(0);
			}else{
				$('#reserveBlock').hide(0);
			}
		});

		if($('#reserve').is(':checked')){
			$('#reserveBlock').show(0);
		}else{
			$('#reserveBlock').hide(0);
		}
		
		$('#buy_it').click(function(){
			if($('#buy_it').is(':checked')){
				$('#buy_itblock').show(0);
			}else{
				$('#buy_itblock').hide(0);
			}
		});

		if($('#buy_it').is(':checked')){
			$('#buy_itblock').show(0);
		}else{
			$('#buy_itblock').hide(0);
		}

		$('#autobid').click(function(){
			if($('#autobid').is(':checked')){
				$('#autobidBlock').show(0);
			}else{
				$('#autobidBlock').hide(0);
			}
		});

		if($('#autobid').is(':checked')){
			$('#autobidBlock').show(0);
		}else{
			$('#autobidBlock').hide(0);
		}

		$('#autolist').click(function(){
			if($('#autolist').is(':checked')){
				$('#autolistBlock').show(0);
			}else{
				$('#autolistBlock').hide(0);
			}
		});

		if($('#autolist').is(':checked')){
			$('#autolistBlock').show(0);
		}else{
			$('#autolistBlock').hide(0);
		}

		if($('#reverse').is(':checked')){
			$('#reverseBlock').show(0);
		}else{
			$('#reverseBlock').hide(0);
		}

		$('#bidsBack').click(function(){
			if($('#bidsBack').is(':checked')){
				$('#bidsBackBlock').show(0);
			}else{
				$('#bidsBackBlock').hide(0);
			}
		});

		if($('#bidsBack').is(':checked')){
			$('#bidsBackBlock').show(0);
		}else{
			$('#bidsBackBlock').hide(0);
		}
	});
</script>