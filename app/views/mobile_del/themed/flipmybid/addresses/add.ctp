<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Add an Address');?></h2>
		</div>
		<div class="account">
			<div class="">
				<?php echo $form->create(null, array('url' => '/addresses/add/'.$addressType['UserAddressType']['id']));?>
					<fieldset>
					<?php
						echo $form->input('name', array('label' => __('Name *', true)));
						echo $form->input('address_1', array('label' => __('Address (line 1) *', true)));
						echo $form->input('address_2', array('label' => __('Address (line 2)', true)));
						echo $form->input('suburb', array('label' => __('Town', true)));
						echo $form->input('city', array('label' => __('County *', true)));
						echo $form->input('postcode', array('label' => __('Postcode', true)));
						echo $form->input('country_id', array('label' => __('Country *', true), 'empty' => 'Select'));
						echo $form->input('phone', array('label' => __('Phone', true)));
						echo $form->input('update_all', array('type' => 'checkbox', 'label' => '&nbsp;', 'after' => __('Make all your addresses this address.', true)));
						echo $form->submit(__('Add Address', true), array('class' => 'submit', 'div' => false));
						echo $form->end();
					?>
					</fieldset>


				<p><?php echo $html->link(__('<< Back to your addresses', true), array('action' => 'index'));?></p>

				</div>
			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>