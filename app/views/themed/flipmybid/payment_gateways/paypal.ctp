<div class="rounded contact">
    <div id="tabs">
    	<h2><?php __('Please wait while we transfer you to PayPal.');?></h2>
    </div>
    <div class="c-content">
    <?php echo $paypal->submit(__('Click here if this page appears for more than 5 seconds', true), $paypalData);?>
    <script type="text/javascript">
		$(document).ready(function()
		{
			$('.submit').removeClass('submit');
			//$('.submit').css('');
		});
        document.getElementById('frmPaypal').submit();
    </script>
    </div>
</div>