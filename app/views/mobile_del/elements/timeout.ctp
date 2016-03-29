<?php if($this->requestAction('/settings/enabled/idle_timeout') && $this->requestAction('/settings/get/timeout')): ?>
	<!-- dialog window markup -->
	<div id="dialog" title="Your session is about to expire!">
		<p>
			<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
			<?php echo sprintf(__('You will be timed out in %s seconds.', true), '<span id="dialog-countdown" style="font-weight:bold"></span>');?>
		</p>

		<p><?php __('Do you want to continue your session?'); ?></p>
	</div>

	<script src="/js/jquery.idletimer.js" type="text/javascript"></script>
	<script src="/js/jquery.idletimeout.js" type="text/javascript"></script>

	<script type="text/javascript">
	// setup the dialog
	$("#dialog").dialog({
		autoOpen: false,
		modal: true,
		width: 400,
		height: 200,
		closeOnEscape: false,
		draggable: false,
		resizable: false,
		buttons: {
			'Yes, Return to Page': function(){
				$(this).dialog('close');
			},
			'No, Timeout': function(){
				// fire whatever the configured onTimeout callback is.
				// using .call(this) keeps the default behavior of "this" being the warning
				// element (the dialog in this case) inside the callback.
				$.idleTimeout.options.onTimeout.call(this);
			}
		}
	});

	// cache a reference to the countdown element so we don't have to query the DOM for it on each ping.
	var $countdown = $("#dialog-countdown");

	// start the idle timer plugin
	$.idleTimeout('#dialog', 'div.ui-dialog-buttonpane button:first', {
		idleAfter: <?php echo $this->requestAction('/settings/get/timeout'); ?>,
		pollingInterval: 2,
		keepAliveURL: 'keepalive.php',
		serverResponseEquals: 'OK',
		onTimeout: function(){
			window.location = "/auctions/timeout/<?php echo base64_encode($this->params['url']['url']); ?>";
		},
		onIdle: function(){
			$(this).dialog("open");
		},
		onCountdown: function(counter){
			$countdown.html(counter); // update the counter
		}
	});

	</script>
<?php endif; ?>