<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb('Forum', '/admin/'.$this->params['controller']);
echo $this->element('admin/crumb');
?>

<div class="news index">

<h2><?php __('Forum'); ?></h2>

<?php if($paginator->counter() > 0):?>

<?php echo $this->element('admin/pagination'); ?>

<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php __('Post'); ?></th>
	<th><?php __('Thread'); ?></th>
	<th><?php echo $paginator->sort(__('Posted by', true), 'User.username');?></th>
	<th><?php echo $paginator->sort(__('Date posted', true), 'Post.created');?></th>
	<th class="actions"><?php __('Options');?></th>
</tr>
<?php
$i = 0;
foreach ($posts as $post):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td><?php echo nl2br($post['Post']['content']); ?></td>
		<td>
		<?php if(!empty($post['Post']['title'])) : ?>
			<strong><?php __('Thread:'); ?></strong> <a target="_blank" href="/posts/view/<?php echo $post['Post']['id']; ?>"><?php echo $post['Post']['title']; ?></a>
		<?php else : ?>
			<?php $thread = $this->requestAction('/posts/getthread/'.$post['Post']['post_id']);?>
			<a target="_blank" href="/posts/view/<?php echo $post['Post']['post_id']; ?>"><?php echo $thread['Post']['title']; ?></a>
		<?php endif; ?>
		</td>

		<td>
			<?php if(!empty($post['User']['username'])) : ?>
				<?php echo $html->link($post['User']['username'], array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?>
			<?php else : ?>
				<em>Admin</em>
			<?php endif; ?>
		</td>
		<td><?php echo $time->niceShort($post['Post']['created']); ?></td>
		<td class="actions">
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $post['Post']['id']), null, 'Are you sure you want to delete the post?'); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>

<?php echo $this->element('admin/pagination'); ?>

<?php else:?>
	<p><?php __('There are no posts at the moment.');?></p>
<?php endif;?>
</div>