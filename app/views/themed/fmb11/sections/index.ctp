<div class="col-md-12 auctions">
<div class="inner">

<h3><?php __('Help Topics'); ?></h3>

<?php echo $this->element('menu_help', array('id' => $id, 'question_id' => $question_id));?>

<?php if(!empty($question)) : ?>
<?php echo $question['Question']['question']; ?>

		

			<?php echo $question['Question']['answer']; ?>


		<?php else : ?>
				<p></p>
<h3><?php __('Help Section'); ?></h3>
        
		

			<?php if(!empty($page['Page']['content'])) : ?>
				<?php echo $page['Page']['content']; ?>
			<?php endif; ?>

		<?php endif; ?>
		<p></p>
<h3><?php __('Quick Links'); ?></h3>

<?php echo $this->element('menu_quicklinks');?>
		
</div>
</div>
 