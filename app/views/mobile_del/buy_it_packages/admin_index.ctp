<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="bidPackages index">
<h2><?php __('Buy It Packages');?></h2>

<?php if($paginator->counter() > 0):?>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('username');?></th>
	<th><?php echo $paginator->sort('Product', 'name');?></th>
	<th><?php echo $paginator->sort('Purchase Date', 'created');?></th>
	<th><?php echo $paginator->sort('price');?></th>
	<th>No. Of Bids</th>
	<th>Status</th>
</tr>
<?php
$i = 0;
foreach ($packages as $package):
//var_dump($package);
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $package['User']['username']; ?>
		</td>
		<td>
			<?php echo $package['BuyItPackage']['name']; ?>
		</td>
		<td>
			<?php echo $time->niceShort($package['BuyItPackage']['created']); ?>
		</td>
		<td>
			<?php echo $number->currency($package['BuyItPackage']['price'], $appConfigurations['currency']); ?>
		</td>
		<td>
			<?php
			App::import("Model", "BuyItPackage");
			$BIPModel = new BuyItPackage();
			$userID = $package['BuyItPackage']['user_id'];
			$auctionID = $package['BuyItPackage']['auction_id'];
			$textFromModel = $BIPModel->GetBidCount($userID,$auctionID);
			echo $textFromModel; ?>
		</td>
		<td>
			<?php
			App::import("Model", "BuyItPackage");
			$BIPModel = new BuyItPackage();
			$status_id = $package['BuyItPackage']['status_id'];
			$textFromModel = $BIPModel->GetSatus($status_id);
			echo $textFromModel; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('admin/pagination'); ?>

<?php else:?>
	<p><?php __('There are no packages at the moment.');?></p>
<?php endif;?>
</div>
