<div class="pure-u-1 pure-u-md-1-4 userform">
		<div id="available-bids">
			<div id="available-bids-text"><p>Available bid credits</p></div>

			<div id="available-bids-count"><p class="bid-balance"><?php echo $this->requestAction('/users/bids'); ?></p></div>
		</div>
		<div id="saved">
			<p>Won Items: <?php echo $this->requestAction('/users/wins'); ?></p>
		</div>
		<div id="purchase"><a href="/packages" class="bidbutton bidbuttonsidebar">purchase bids</a></div>
		<ul>
			<li id="menuactive"><a href="/users">my account</a></li>
			<li><a href="/bids">my bid history</a></li>
			<li><a href="/auctions/won">won items</a></li>
		</ul>
	</div>