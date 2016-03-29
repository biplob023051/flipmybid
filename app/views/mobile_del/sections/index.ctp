<div id="lefthelp">
	<h3><?php __('Help Topics'); ?></h3>
   <?php echo $this->element('menu_help', array('id' => $id, 'question_id' => $question_id));?>
</div>
<div id="middle" class="boxed">
	<div class="content">
		<?php if(!empty($question)) : ?>
			<h1><?php echo $question['Question']['question']; ?></h1>

			<?php echo $question['Question']['answer']; ?>
		<?php else : ?>
			<h1><?php __('Help Section'); ?></h1>

			<?php if(!empty($page['Page']['content'])) : ?>
				<?php echo $page['Page']['content']; ?>
			<?php endif; ?>
		<?php endif; ?>
	</div>
</div>

<div id="right-quicklinks">
	<h3><?php __('Quick Links'); ?></h3>
	<?php echo $this->element('menu_quicklinks');?>
</div>
