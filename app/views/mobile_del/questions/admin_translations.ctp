<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(__('Sections', true), '/admin/sections');
$html->addCrumb('Question', '/admin/questions/view/'.$question['Section']['id']);
$html->addCrumb(__('Translations', true), '/admin/'.$this->params['controller'].'/translations/'.$question['Question']['id']);
echo $this->element('admin/crumb');
?>

<table cellpadding="0" cellspacing="0">
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

			echo $html->link(__('Edit Translation', true), array('action'=>'edit', $question['Question']['id'], $language['Language']['code'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>


<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to questions', true), array('action'=>'view', $question['Section']['id']));?></li>
	</ul>
</div>