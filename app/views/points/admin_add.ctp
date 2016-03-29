<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(__('Users', true), '/admin/users');
$html->addCrumb(__('Rewards Points', true), '/admin/points/user/' . $user['User']['id']);
$html->addCrumb(__('Add', true), '/admin/points/add/' . $user['User']['id']);
echo $this->element('admin/crumb');
?>

<h2><?php __('Add a Points Transaction'); ?></h2>

<div class="col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
    <p>
        <?php __('To manually enter in a points transaction fill out the form below.'); ?>
        <?php __('A positive total will add points to the users account (i.e. credit their account).'); ?>
        <?php __('Use a negative number to subtract points (i.e. debit) the users bid account.'); ?>
    </p>
</div>


<?php echo $form->create(null, array('url' => '/admin/points/add/' . $user['User']['id'])); ?>
<fieldset>
    <?php
    echo $form->input('description', array('label' => __('Description *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
    echo $form->input('total', array('label' => __('Total *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
    ?>
</fieldset>
<?php echo $form->end(__('Add Transaction', true)); ?>

<div class="actions">
    <ul>
        <li><?php echo $html->link(__('<< Back to the users rewards', true), array('action' => 'user', $user['User']['id'])); ?> </li>
    </ul>
</div>