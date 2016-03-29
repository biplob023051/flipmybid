<div class="col-md-12 auctions">
<div class="nav nav-tabs nav-justified">
<h2 style="margin: 9px 20px;"><?php __('My Addresses');?></h2>
		</div>
		<div class="auction-content">
			<div class="">
				<?php if(!empty($address)) : ?>
					<?php foreach($address as $name => $address) : ?>
						<h2><?php __('Address'); ?> <?php echo $name; ?></h2>
						<?php if(!empty($address['Address']['id'])) : ?>
						<div class="table-responsive">
							<!-- <table class="default-table" width="100%" border="0" cellspacing="0" cellpadding="0"> -->
							<table class="table">
							<tr class="headings">
								<td><?php __('Name');?></td>
								<td><?php __('Address');?></td>
								<td><?php __('Town');?></td>
								<td><?php __('County');?></td>
								<td><?php __('Postcode');?></td>
								<td><?php __('Country');?></td>
								<td><?php __('Phone Number');?></td>
								<td class="actions"><?php __('Options');?></td>
							</tr>

							<tr>
								<td><?php echo $address['Address']['name']; ?></td>
								<td><?php echo $address['Address']['address_1']; ?><?php if(!empty($address['Address']['address_2'])) : ?>, <?php echo $address['Address']['address_2']; ?><?php endif; ?></td>
								<td><?php if(!empty($address['Address']['suburb'])) : ?><?php echo $address['Address']['suburb']; ?><?php else: ?><?php __('n/a'); ?><?php endif; ?></td>
								<td><?php echo $address['Address']['city']; ?></td>
								<td><?php echo $address['Address']['postcode']; ?></td>
								<td><?php echo $address['Country']['name']; ?></td>
								<td><?php if(!empty($address['Address']['phone'])) : ?><?php echo $address['Address']['phone']; ?><?php else: ?><?php __('n/a'); ?><?php endif; ?></td>
								<td><a href="/addresses/edit/<?php echo $address['Address']['user_address_type_id']; ?>"><?php __('Edit'); ?></a></td>
							</tr>
							</table>
						<?php else: ?>
							<p><a href="/addresses/add/<?php echo $address['Address']['user_address_type_id']; ?>"><?php echo sprintf(__('Add a %s address', true), $name); ?></a></p>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>
