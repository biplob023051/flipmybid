<?php if(!empty($ep_key)) : ?>
	<<?php echo '?'; ?>xml version="1.0" encoding="ISO-8859-1"<?php echo '?'; ?>>
	<getautoMB_key>
	<ep_status>ok0</ep_status>
	<ep_message>doc gerado</ep_message>
	<ep_cin><?php echo $ep_cin; ?></ep_cin>
	<ep_user><?php echo $ep_user; ?></ep_user>
	<ep_doc><?php echo $ep_doc; ?></ep_doc>
	<ep_key><?php echo $ep_key; ?></ep_key>
	</getautoMB_key>
<?php endif; ?>