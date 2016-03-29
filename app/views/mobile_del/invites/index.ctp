<div id="left">
    <?php echo $this->element('menu_user', array('cache' => Configure::read('Cache.time')));?>
</div>
<div id="right" class="boxed">
	<div class="content">
		<h1><?php __('Invite My Friends');?></h1>
		<div class="invites form">
			<h3><?php __('Fill your friends email addresses, separate email by comma (,)');?></h3>
			<div>example: friend1@mail.com, friend2@mail.com, friend3@mail.com</div>
			<?php echo $form->create('Invite', array('action' => 'index')); ?>
			<?php echo $form->textarea('friends_email', array('id'=>'recipient_list','div' => false, 'label' => false,'cols'=> 50,'rows'=>10)); ?>
			<div>
				<?php echo $form->label(__('Invite Message', true));?><br/>
				<?php echo $form->textarea('message', array('div' => false, 'label' => false,'cols'=> 50,'rows'=>10)); ?>
			</div>
			<?php echo $form->end(__('Invite Now', true)); ?>

			<?php if($this->requestAction('/settings/get/import_contacts')) : ?>
				<div id="importer">
					<p><?php __('Import your contact from webmail services');?></p>
					<?php echo $html->link($html->image('aol.gif'), array('action' => 'import', 'aol'), array('class' => 'importAction', 'title' => 'aol.com', 'escape' => false));?>
					<?php echo $html->link($html->image('gmail.gif'), array('action' => 'import', 'gmail'), array('class' => 'importAction', 'title' => 'gmail.com', 'escape' => false));?>
					<?php echo $html->link($html->image('hotmail.gif'), array('action' => 'import', 'hotmail'), array('class' => 'importAction', 'title' => 'hotmail.com', 'escape' => false));?>
					<?php echo $html->link($html->image('msn_mail.gif'), array('action' => 'import', 'msn_mail'), array('class' => 'importAction', 'title' => 'msn.com', 'escape' => false));?>
					<?php echo $html->link($html->image('yahoo.gif'), array('action' => 'import', 'yahoo'), array('class' => 'importAction', 'title' => 'yahoo.com', 'escape' => false));?>
				</div>
				<div id="importer_form" style="display: none">
				<fieldset>
					<?php echo $form->create('User', array('action' => 'import'));?>
						<?php echo $form->input('login', array('class' => 'importerLogin', 'after' => '@<span id="importer_service">&nbsp;</span>'));?>
						<?php echo $form->input('password', array('class' => 'importerPassword'));?>
						<?php echo $form->submit(__('Import', true), array('class' => 'importerSubmit'));?>
					<?php echo $form->end();?>
				</fieldset>
				</div>
				<div id="importer_inprogress" style="display: none">
					<?php echo $html->image('spinner2.gif');?><?php __('Please wait while we import your contacts...');?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php echo $javascript->link('importer');?>
