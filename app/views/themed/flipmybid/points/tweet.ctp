<div class="col-md-3 col-sm-12 col-xs-12 g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="col-md-9 col-sm-12 col-xs-12 g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Tweet About Flip My Bid');?></h2>
		</div>
		<div class="account">
			<div class="">
		<?php
			if(!$tweetexists)
			{
				?>
			<a class="twitter-share-button" href="https://twitter.com/share" data-text="Check out www.flipmybid.com for huge discounts on all the latest gadgets now. Its fun and you can win money too! #multivalueauctioning" data-url=" ">Tweet about Flip My Bid</a>
			<p>By tweeting about Flip My Bid you will receive one bid credit which can be used instantly!</p>
<script>
window.twttr=(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],t=window.twttr||{};if(d.getElementById(id))return t;js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);t._e=[];t.ready=function(f){t._e.push(f);};return t;}(document,"script","twitter-wjs"));
</script>
		<?php
		}
		else
		{ ?>
		You have already tweeted about Flip My Bid and redeemed one bid credit.
		<?php
		}
		?>
			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>