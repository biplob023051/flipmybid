<div id="lefthelp" class="rounded col-xs-12 col-sm-6 col-md-3">
    <div class="tabs">
        <h2><?php __('Help Topics'); ?></h2>
    </div>

    <div class="h-content">
        <?php echo $this->element('menu_help', array('id' => $id, 'question_id' => $question_id)); ?>
    </div>
</div>
<div id="right-quicklinks" class="rounded col-xs-12 col-sm-6 col-md-3">
    <div class="tabs">
        <h2><?php __('Quick Links'); ?></h2>
    </div>

    <div class="h-content">
        <?php echo $this->element('menu_quicklinks'); ?>
    </div>
</div>
<div id="middle" class="boxed rounded col-xs-12 col-sm-12 col-md-6">
    <?php if (!empty($question)) : ?>
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
            <?php if (!empty($page['Page']['content'])) : ?>
                <?php echo $page['Page']['content']; ?>
            <?php endif; ?>

        </div>
    <?php endif; ?>

    <div class="tabs" id="help-contact">
        <h2>Contact us</h2>
    </div>

    <div class="h-content">
    <?php echo $form->create(null, array('url' => '/contact')); ?>

    <fieldset>
        <?php echo $form->input('name', array('label' => 'Full Name <span class="required">*</span>', 'class' => 'form-control'));?>
        <?php echo $form->input('email', array('label' => 'Email Address<span class="required">*</span>', 'class' => 'form-control')); ?>
        <?php
        if(!empty($departments)) :
            echo $form->input('department_id', array('label' => 'Department *', 'empty' => 'Select', 'class' => 'form-control' ));
        endif;
        ?>
        <?php echo $form->input('phone', array('label' => 'Phone Number', 'class' => 'form-control')); ?>
        <?php echo $form->input('subject', array('label' => 'Subject', 'class' => 'form-control')); ?>
        <?php echo $form->input('message', array('label' => 'Your Message <span class="required">*</span>', 'class' => 'form-control', 'type' => 'textarea'));?>
        <?php echo $form->submit('Contact Us', array('class'=>'submit center-button', 'div'=>false)); ?>
        <?php echo $form->end(); ?>
    </fieldset>
        </div>
</div>


