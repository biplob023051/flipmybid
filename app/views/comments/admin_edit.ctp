<?php
$html->addCrumb(__('Manage Content', true), '/admin/pages');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/'.$this->params['controller'].'/edit/'.$this->data['Comment']['id']);
echo $this->element('admin/crumb');
?>
<h2>Edit a Comment for the news: <?php echo $comment['News']['title']; ?></h2>
<div class="auctions form">
<?php echo $form->create('Comment');?>
	<fieldset>
		<?php
			echo $form->input('id');
			echo $form->input('comment', array('label' => 'Comment *', 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
			echo $form->input('approved');

			$freebids = $this->requestAction('/settings/get/comments_free_bids');
			if($freebids == 1) {
				echo $form->input('bids', array('type' => 'checkbox', 'label' => 'Issue 1 free bid for this comment'));
			} elseif($freebids > 0) {
				echo $form->input('bids', array('type' => 'checkbox', 'label' => 'Issue '.$freebids.' free bids for this comment'));
			}
		?>
	</fieldset>
<?php echo $form->end(__('Save Changes >>', true));?>
</div>
<?php echo $this->element('admin/required'); ?>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Back to comments', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('Delete >>', true), array('action' => 'delete', $comment['Comment']['id']), null, 'Are you sure you want to delete the comment?'); ?></li>
	</ul>
</div>