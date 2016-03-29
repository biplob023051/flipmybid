<div class="languages index">

<h2><?php __('Languages');?></h2>

<?php if($paginator->counter() > 0):?>

<?php echo $this->element('pagination'); ?>

<table width="100%" class="table" cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('default');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($languages as $language):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $language['Language']['name']; ?>
		</td>
		<td>
			<?php if(!empty($language['Language']['default'])) : ?><?php __('Yes'); ?><?php else : ?><?php __('No'); ?><?php endif; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Translate Site Text', true), array('controller' => 'translations', 'action'=>'view', $language['Language']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('pagination'); ?>

<?php else:?>
	<p><?php __('There are no languages at the moment');?></p>
<?php endif;?>
</div>
