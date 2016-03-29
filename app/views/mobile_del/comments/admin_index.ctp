<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="news index">

<h2>Comments</h2>

<?php if($paginator->counter() > 0):?>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('news_id');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('approved');?></th>
	<th><?php echo $paginator->sort('Date', 'Comment.created');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($comments as $comment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td><?php echo $html->link($comment['News']['title'], array('admin' => false, 'controller' => 'news', 'action' => 'view', $comment['News']['id']), array('target' => '_blank')); ?></td>
		<td><?php echo $html->link($comment['User']['username'], array('controller' => 'users', 'action' => 'view', $comment['User']['id'])); ?></td>
		<td>
			<?php if(!empty($comment['Comment']['approved'])) : ?>
				Yes
			<?php else : ?>
				No
			<?php endif; ?>
		</td>
		<td><?php echo $time->niceShort($comment['Comment']['created']); ?></td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $comment['Comment']['id'])); ?>
			/ <?php echo $html->link(__('Delete', true), array('action' => 'delete', $comment['Comment']['id']), null, 'Are you sure you want to delete the comment?'); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('admin/pagination'); ?>

<?php else:?>
	<p><?php __('There are no comments at the moment.');?></p>
<?php endif;?>
</div>