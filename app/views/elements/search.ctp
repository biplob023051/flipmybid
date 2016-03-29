<?php if($this->requestAction('/settings/enabled/auction_search')) : ?>
	<div>
		<?php echo $form->create('Auction', array('action' => 'search')); ?>
			<span>
				<?php echo $form->input('search', array('error' => false, 'div' => false, 'label' => false, 'onclick' => "this.value=''", 'class' => 'cleardefault', 'value' => __('Search Auctions', true)));?>
          	</span>
          	<?php echo $form->submit('search-btn.gif', array('id'=>'search-btn', 'div'=>false));?>
        <?php echo $form->end();?>
	</div>
<?php endif; ?>