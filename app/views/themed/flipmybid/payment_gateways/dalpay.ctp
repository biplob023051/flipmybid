<div class="rounded contact">
    <div id="tabs">
    	<h2><?php __('Please wait while we transfer you the payment gateway.');?></h2>
    </div>
    <div class="c-content">
    <form id="frmDalpay" name="frmDalpay" action="<?php echo $gateway['url']; ?>" method="post">
    	<?php foreach ($dalpay as $name => $value) : ?>
    		<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
    	<?php endforeach; ?>

    	<input type="submit" value="Transferring..." />
    </form>
    <script type="text/javascript">
        document.getElementById('frmDalpay').submit();
    </script>
    </div>
</div>