<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(__('Registration Sources', true), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Translations', true), '/admin/sources/translations/'.$source['Source']['id']);
echo $this->element('admin/crumb');
?>

<table class="table table-condensed table-striped" cellpadding="0" cellspacing="0">
<tr>
	<th><?php __('Language'); ?></th>
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
		<td class="actions">
			<?php if(!empty($language['Language']['default'])) {
				$language['Language']['code'] = '';
			}

			echo $html->link(__('Edit Translation', true), array('action'=>'edit', $source['Source']['id'], $language['Language']['code'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>


<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to sources', true), array('action'=>'index'));?></li>
	</ul>
</div>
