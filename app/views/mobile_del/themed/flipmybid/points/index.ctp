<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('My Reward Points');?></h2>
		</div>
		<div class="account">
			<div class="">
					<?php if(!empty($points)): ?>
                    	<div class="paging-auct">
							<?php echo $this->element('pagination'); ?>
						</div>
                        
						<table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr class="headings">
						<td><?php echo $paginator->sort(__('Date', true), 'Point.created');?></td>
							<td><?php echo $paginator->sort(__('Description', true), 'description');?></td>
							<td><?php echo $paginator->sort(__('Debit', true), 'debit');?></td>
							<td><?php echo $paginator->sort(__('Credit', true), 'credit');?></td>
						</tr>

						<tr>
							<td colspan="3"><strong><?php __('Current Balance');?></strong></td>
							<td><strong><?php echo $balance; ?></strong></td>
						</tr>
						<?php
						$i = 0;
						foreach ($points as $point):
							$class = null;
							if ($i++ % 2 == 0) {
								$class = ' class="altrow"';
							}
						?>
							<tr<?php echo $class;?>>
								<td>
									<?php echo $time->niceShort($point['Point']['created']); ?>
								</td>
								<td>
									<?php echo $point['Point']['description']; ?>
								</td>
								<td>
									<?php if($point['Point']['debit'] > 0) : ?><?php echo $point['Point']['debit']; ?><?php else: ?>&nbsp;<?php endif; ?>
								</td>
								<td>
									<?php if($point['Point']['credit'] > 0) : ?><?php echo $point['Point']['credit']; ?><?php else: ?>&nbsp;<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
						</table>

						<div class="paging-auct">
							<?php echo $this->element('pagination'); ?>
						</div>

					<?php else:?>
						<p><?php __('You have no reward points at the moment.');?></p>
					<?php endif;?>

			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>
<div class="g5" style="margin-top: 20px;">
	<div id="" class="rounded">
		<div id="" style="background-color: #eaeaea; height: 40px; padding: 12px 0 0 5px;">
			<h2 style="margin: 0 20px;"><?php __('FMB Tweet');?></h2>
		</div>
		<div class="account" style="background-color: #fff;"><br />
		<?php
			if(!$tweetexists)
			{
				?>
				<p><a href="points/tweet">Tweet about Flip My Bid</a> and receive 1 bid credit!</p>
				<?php
			}
			else
			{
			?>
				<p>You have already tweeted about Flip My Bid and redeemed 1 bid credit!</p>
			<?php
			}
		?>
		</div>
	</div>
</div>

<div class="g5" style="margin-top: 20px;">

	<div id="" class="rounded">
	
		<div id="" style="background-color: #eaeaea; height: 40px; padding: 12px 0 0 5px;">
			<h2 style="margin: 0 20px;"><?php __('Like us on Facebook');?></h2>
		</div>
		
		<div class="account" style="background-color: #fff;"><br />
		<?php
			if(!$fblikeexists)
			{
				?>
				<p>Like us on Facebook and receive <?php echo $fbpoints; ?> bid <?php if($fbpoints > 1) { echo "credits"; } else { echo "credit"; } ?>!</p>
				<div class="facebook-like-click">
					<div class="fb-like-box" data-href="https://www.facebook.com/FlipMyBid" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="false" data-show-border="true">&nbsp;</div>
				</div>
				<?php
			}
			else
			{
			?>
				<p>You have liked our Facebook page and received <?php echo $fbpoints['Bid']['credit']; ?> bid <?php if($fbpoints['Bid']['credit'] > 1) { echo "credits"; } else { echo "credit"; } ?>!</p>
			<?php
			}
		?>
		</div>
		
	</div>
</div>

<script>

	$(document).ready(function()
	{
		
		var page_like_or_unlike_callback = function(url, html_element) {
		  console.log(url);
		  window.location.href = 'http://www.flipmybid.com/points/fblike';
		}
		setInterval(function(){ FB.Event.subscribe('edge.create', page_like_or_unlike_callback); }, 3000);
	});

</script>