<?php
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/' . $this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/' . $this->params['controller'] . '/edit/' . $this->data['Newsletter']['id']);
echo $this->element('admin/crumb');
?>
<h2><?php __('Edit Newsletter'); ?></h2>
<div class="newsletters form">
    <?php echo $form->create('Newsletter'); ?>
    <fieldset>

        <h3><?php __('Pre Defined Variables', true); ?></h3>

        <div class="col-sm-6 col-sm-offset-3">
            <p><?php __('By entering in the following variables in either the subject or body of the newsletter, the variables will be replaced by the users details:'); ?>
                <br/>
                <?php __('First Name'); ?>: {first_name}<br/>
                <?php __('Last Name'); ?>: {last_name}<br/>
                <?php __('Email Address'); ?>: {email}<br/>
                <?php __('Username'); ?>: {username}
            </p>
        </div>
        <?php
        echo $form->input('id');
        echo $form->input('subject', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
        echo "<div class='clearfix'></div>";
        echo $form->label('Body');
        echo $fck->input('Newsletter.body');
        ?>
    </fieldset>
    <?php echo $form->end(__('Save Changes', true)); ?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Newsletter.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Newsletter.id'))); ?></li>
        <li><?php echo $html->link(__('List Newsletters', true), array('action' => 'index')); ?></li>
    </ul>
</div>
