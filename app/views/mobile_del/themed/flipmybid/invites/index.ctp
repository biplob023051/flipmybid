<div class="g7">
	<?php echo $this->element('menu_user'); ?>
</div>
<!--/ sidebar -->
<div class="g5">
	<div id="auctions" class="rounded">
		<div id="tabs">
			<h2><?php __('Invite My Friends');?></h2>
		</div>
		<div class="account">
			<div class="">
				<h3><?php __('Fill your friends email addresses, separate email by comma (,)');?></h3>
					<div>example: friend1@mail.com, friend2@mail.com, friend3@mail.com</div>
					<?php echo $form->create('Invite', array('action' => 'index')); ?>
					<?php echo $form->textarea('friends_email', array('id'=>'recipient_list','div' => false, 'label' => false,'cols'=> 50,'rows'=>10)); ?>
					<div>&nbsp;</div>
					<div>
						<?php echo $form->textarea('message', array('div' => false, 'label' => false,'cols'=> 50,'rows'=>10)); ?>
					</div>
					<?php echo $form->submit(__('Invite Now', true), array('class' => 'submit', 'div' => false));?>
					<?php echo $form->end();?>

					<?php if($this->requestAction('/settings/get/import_contacts')) : ?>
						<div id="importer">
							<p><?php __('Import your contact from webmail services');?></p>
							<?php echo $html->link($html->image('aol.gif'), array('action' => 'import', 'aol'), array('class' => 'importAction', 'title' => 'aol.com', 'escape' => false));?>
							<?php echo $html->link($html->image('gmail.gif'), array('action' => 'import', 'gmail'), array('class' => 'importAction', 'title' => 'gmail.com', 'escape' => false));?>
							<?php echo $html->link($html->image('hotmail.gif'), array('action' => 'import', 'hotmail'), array('class' => 'importAction', 'title' => 'hotmail.com', 'escape' => false));?>
							<?php echo $html->link($html->image('msn_mail.gif'), array('action' => 'import', 'msn_mail'), array('class' => 'importAction', 'title' => 'msn.com', 'escape' => false));?>
							<?php echo $html->link($html->image('yahoo.gif'), array('action' => 'import', 'yahoo'), array('class' => 'importAction', 'title' => 'yahoo.com', 'escape' => false));?>
						</div>

						<fieldset>
							<?php echo $form->create('Invite', array('action' => 'import'));?>
								<?php echo $form->input('login', array('class' => 'importerLogin', 'after' => '@<span id="importer_service">&nbsp;</span>'));?>
								<?php echo $form->input('password', array('class' => 'importerPassword'));?>
								<?php echo $form->submit(__('Import', true), array('class' => 'submit', 'div' => false));?>
							<?php echo $form->end();?>
						</fieldset>

						<div id="importer_inprogress" style="display: none">
							<?php echo $html->image('spinner2.gif');?><?php __('Please wait while we import your contacts...');?>
						</div>
					<?php endif; ?>
			</div>
		</div>
	</div>
	<!--/ Auctions -->
</div>


<?php echo $javascript->link('importer');?>
