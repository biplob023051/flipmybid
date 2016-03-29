<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
if(!empty($parents)) :
	foreach($parents as $parent) :
		$html->addCrumb($parent['Category']['name'], '/admin/categories/index/'.$parent['Category']['id']);
	endforeach;
endif;

echo $this->element('admin/crumb');
?>

<div class="categories index">

<h2><?php __('Categories');?></h2>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Create a new category', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<?php if($paginator->counter() > 0):?>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($categories as $category):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $category['Category']['name']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('admin' => false, 'action'=>'view', $category['Category']['id']), array('target' => '_blank')); ?>
			<?php if($this->requestAction('/settings/enabled/multi_languages')) : ?>
				/ <?php echo $html->link(__('Edit', true), array('action'=>'translations', $category['Category']['id'])); ?>
			<?php else : ?>
				/ <?php echo $html->link(__('Edit', true), array('action'=>'edit', $category['Category']['id'])); ?>
			<?php endif; ?>

			<?php if(!empty($category['ChildCategory'])) : ?>
         		/ <?php echo $html->link(__('Child Categories', true), array('action' => 'index', $category['Category']['id'])); ?>
         	<?php elseif(empty($category['Auction'])) : ?>
				/ <?php echo $html->link(__('Delete', true), array('action'=>'delete', $category['Category']['id']), null, sprintf(__('Are you sure you want to delete the category named: %s?', true), $category['Category']['name'])); ?>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('admin/pagination'); ?>

<?php else:?>
	<p><?php __('There are no categories at the moment.');?>
<?php endif;?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Create a new category', true), array('action' => 'add')); ?></li>
	</ul>
</div>
