<div class="payment-redirect">
    <h1><?php __('Please wait while we transfer you to the payment gateway.');?></h1>

    <form id="frmDalpay" name="frmDalpay" action="<?php echo $gateway['url']; ?>" method="post">
    	<?php foreach ($dalpay as $name => $value) : ?>
    		<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
    	<?php endforeach; ?>

    	<div class="submit">
    		<input type="submit" value="Click here if this page appear more than 5 seconds" />
    	</div>
    </form>
    <script type="text/javascript">
        document.getElementById('frmDalpay').submit();
    </script>
</div>