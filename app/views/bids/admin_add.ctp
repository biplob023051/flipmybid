<?php
$html->addCrumb(Inflector::humanize('Users'), '/admin/users');
$html->addCrumb($user['User']['username'], '/admin/users/view/' . $user['User']['id']);
$html->addCrumb(__('Bids', true), '/admin/bids/user/' . $user['User']['id']);
$html->addCrumb(__('Add', true), '/admin/bids/add/' . $user['User']['id']);
echo $this->element('admin/crumb');
?>
<h2><?php __('Add a Bid Transaction'); ?></h2>
<div class="col-sm-8 col-sm-offset-2">
    <p>
        <?php __('To manually enter in a bid transaction fill out the form below.'); ?>
        <?php __('A positive total will add bids to the users account (i.e. credit their account).'); ?>
        <?php __('Use a negative number to subtract bids (i.e. debit) the users bid account.'); ?>
    </p>
</div>

<?php echo $form->create(null, array('url' => '/admin/bids/add/' . $user['User']['id'])); ?>
<fieldset>
    <?php
    echo $form->input('description', array('label' => __('Description *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
    echo $form->input('total', array('label' => __('Total *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
    ?>
</fieldset>
<?php echo $form->end(__('Add Transaction', true)); ?>

<div class="actions">
    <ul>
        <li><?php echo $html->link(__('<< Back to the users bids', true), array('action' => 'user', $user['User']['id'])); ?> </li>
    </ul>
</div>
