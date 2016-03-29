<div id="lefthelp" class="rounded">
	<div class="tabs">
		<h2><?php __('Help Topics'); ?></h2>
   	</div>
    
    <div class="h-content">
	   <?php echo $this->element('menu_help', array('id' => $id, 'question_id' => $question_id));?>
    </div>
</div>
<div id="middle" class="boxed rounded">
		<?php if(!empty($question)) : ?>
        <div class="tabs">
			<h2><?php echo $question['Question']['question']; ?></h2>
        </div>
		
        <div class="h-content">
			<?php echo $question['Question']['answer']; ?>
       </div>
		<?php else : ?>
        <div class="tabs">
			<h2><?php __('Help Section'); ?></h2>
        </div>
		<div class="h-content">
			<?php if(!empty($page['Page']['content'])) : ?>
				<?php echo $page['Page']['content']; ?>
			<?php endif; ?>
        </div>
		<?php endif; ?>
</div>

<div id="right-quicklinks" class="rounded">
	<div class="tabs">
		<h2><?php __('Quick Links'); ?></h2>	
    </div>
    
    <div class="h-content">
		<?php echo $this->element('menu_quicklinks');?>
    </div>
</div>
