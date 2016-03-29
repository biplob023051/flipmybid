<div class="col-md-3 col-sm-12 col-xs-12 g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-9 col-sm-12 col-xs-12 g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Update an Address');?></h2>
		</div>
		<div class="account">
			<div class="">
				<?php echo $form->create(null, array('url' => '/addresses/edit/'.$addressType['UserAddressType']['id']));?>
					<fieldset>
					<?php
						echo $form->input('id');
						echo $form->input('name', array('label' => __('Name *', true), 'class' => 'form-control'));
						echo $form->input('address_1', array('label' => __('Address (line 1) *', true), 'class' => 'form-control'));
						echo $form->input('address_2', array('label' => __('Address (line 2)', true), 'class' => 'form-control'));
						echo $form->input('suburb', array('label' => __('Town', true), 'class' => 'form-control'));
						echo $form->input('city', array('label' => __('County *', true), 'class' => 'form-control'));
						echo $form->input('postcode', array('label' => __('Postcode', true), 'class' => 'form-control'));
						echo $form->input('country_id', array('label' => __('Country *', true), 'empty' => 'Select', 'class' => 'form-control'));
						echo $form->input('phone', array('label' => __('Phone', true), 'class' => 'form-control'));
						echo $form->input('update_all', array('type' => 'checkbox', 'label' => '&nbsp;', 'after' => __('Make all your addresses this address.', true)));
						echo $form->submit(__('Save Changes', true), array('class' => 'submit center-button', 'div' => false));
						echo $form->end();
					?>
					</fieldset>


				<p><?php echo $html->link(__('<< Back to your addresses', true), array('action' => 'index'), array('class' => 'backButton'));?></p>

				</div>
			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>
