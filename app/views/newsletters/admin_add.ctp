<?php
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/'.$this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/'.$this->params['controller'].'/add');
echo $this->element('admin/crumb');
?>
<h2><?php __('Add Newsletter');?></h2>
<div class="newsletters form">
<?php echo $form->create('Newsletter');?>
	<fieldset>
 		<p>When adding a newsletter, the newsletter will not send until you press 'send' on the main newsletter page.  This will allow you to add a newsletter and edit it later before sending it.</p>

 		<h3>Pre Defined Variables</h3>
		<div class="col-sm-6 col-sm-offset-3">
 		<p>By entering in the following variables in either the subject or body of the newsletter, the variables will be replaced by the users details:<br />
 		First Name: {first_name}<br />
 		Last Name: {last_name}<br />
 		Email Address: {email}<br />
 		Username: {username}
 		</p>
			</div>
	<?php
		echo $form->input('subject', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
	echo "<div class='clearfix'></div>";
		echo $form->label(__('Body', true));
		echo $fck->input('Newsletter.body');
	?>
	</fieldset>
<?php echo $form->end(__('Add Newsletter', true));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Newsletters', true), array('action'=>'index'));?></li>
	</ul>
</div>
