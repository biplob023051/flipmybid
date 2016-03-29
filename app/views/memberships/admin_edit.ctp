<?php
$html->addCrumb(__('Settings', true), '/admin/settings');
$html->addCrumb(Inflector::humanize($this->params['controller']), '/admin/' . $this->params['controller']);
$html->addCrumb(__('Edit', true), '/admin/memberships/edit/' . $id . '/' . $language);
echo $this->element('admin/crumb');
?>

<div class="categories form">
    <?php echo $form->create('Membership', array('type' => 'file', 'url' => '/admin/' . $this->params['controller'] . '/edit/' . $id . '/' . $language)); ?>
    <fieldset>
        <legend><?php __('Edit a Membership'); ?></legend>

        <?php
        echo $form->input('name', array('label' => __('Name *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
        echo $form->input('description', array('class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));

        if (empty($language)) {
            echo $form->input('rank', array('label' => __('Rank *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
            echo $form->input('default', array('label' => __('Default Membership - the initial membership level when users register.', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));

            if ($this->requestAction('settings/enabled/reward_points')) {
                echo $form->input('points', array('label' => __('Reward Points Required *', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));

                if ($this->requestAction('settings/get/rewards_store ')) {
                    echo $form->input('rewards', array('label' => __('Users can purchase from the rewards store', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
                }
            }

            if ($this->requestAction('settings/get/beginner_auctions')) {
                echo $form->input('beginner', array('label' => __('Users can bid on beginner auctions', true), 'class' => 'form-control', 'div' => array('class' => 'col-md-offset-4 col-sm-offset-4 col-sm-4 col-md-4')));
            }
        }
        ?>

        <?php if (!empty($this->data['Membership']['image']) && (!is_array($this->data['Membership']['image']))) : ?>
            <div class="clearfix"></div>
            <label><?php __('Current Image'); ?>:</label>
            <div><?php echo $html->image('product_images/max/' . $this->data['Membership']['image']); ?></div>
            <label>&nbsp;</label>
            <?php echo $form->checkbox('image_delete', array('value' => $this->data['Membership']['id'])); ?> Delete this image?
        <?php endif; ?>

        <?php if (empty($language)) {
            echo $form->input('image', array('type' => 'file'));
        } ?>

    </fieldset>
    <?php echo $form->end(__('Save Changes', true)); ?>
</div>

<?php echo $this->element('admin/required'); ?>

<div class="actions">
    <ul>
        <li><?php echo $html->link(__('<< Back to memberships', true), array('action' => 'index')); ?></li>
    </ul>
</div>
