<?php if($this->requestAction('/settings/enabled/live_support') && $this->requestAction('/settings/get/live_support_license')) : ?>
	<?php $license = explode('-', $this->requestAction('/settings/get/live_support_license')); ?>

	<script type='text/javascript'>
		var __wtw_lucky_ref_id = <?php echo $license[0]; ?>;
		var __wtw_lucky_res_id = <?php echo $license[1]; ?>;
		var __wtw_lucky_site_id = <?php echo $license[2]; ?>;

		(function() {
			var wa = document.createElement('script'); wa.type = 'text/javascript'; wa.async = true;
		    wa.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://w1') + '.livestatserver.com/w.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(wa, s);
		})();
    </script>
<?php endif; ?>