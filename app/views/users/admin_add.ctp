<?php
$html->addCrumb(__('Manage Users', true), '/admin/users');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/' . $this->params['controller']);
$html->addCrumb(__('Add', true), '/admin/' . $this->params['controller'] . '/add');
echo $this->element('admin/crumb');
?>
<h2><?php __('Add a User'); ?></h2>
<div class="col-sm-12">
    <?php echo $form->create('User'); ?>
    <fieldset>
        <?php
        echo $form->input('id');
        echo $form->input('username', array('class' => 'form-control', 'div' => array('class' => 'col-sm-4 col-md-3')));
        echo $form->input('first_name', array('class' => 'form-control', 'div' => array('class' => 'col-sm-4 col-md-3')));
        echo $form->input('last_name', array('class' => 'form-control', 'div' => array('class' => 'col-sm-4 col-md-3')));
        echo $form->input('email', array('class' => 'form-control', 'div' => array('class' => 'col-sm-4 col-md-3')));

        if ($this->requestAction('/settings/enabled/memberships')) {
            echo $form->input('membership_id', array('class' => 'form-control', 'label' => __('Membership Level', true), 'empty' => __('None', true), 'div' => array('class' => 'col-sm-4 col-md-2')));
        }

        echo $form->input('date_of_birth', array('minYear' => $appConfigurations['Dob']['year_min'], 'maxYear' => $appConfigurations['Dob']['year_max'], 'label' => 'Date of Birth', 'class' => 'form-control', 'div' => array('class' => 'col-sm-4 col-md-3')));
        echo $form->input('gender_id', array('type' => 'select', 'label' => 'Gender', 'class' => 'form-control', 'div' => array('class' => 'col-sm-4 col-md-3')));
        if (!empty($appConfigurations['taxNumberRequired'])) {
            echo $form->input('tax_number');
        }
        echo $form->input('goldmember', array('label' => 'This user is a Gold Member', 'class' => 'form-control', 'div' => array('class' => 'col-sm-4 col-md-3')));
        echo $form->input('newsletter', array('label' => 'Receive the newsletter?'));
        ?>
    </fieldset>
    <?php echo $form->end(__('Add User', true)); ?>
</div>
<div class="actions">
    <ul>
        <li><?php echo $html->link(__('<< Back to users', true), array('action' => 'index')); ?> </li>
    </ul>
</div>
