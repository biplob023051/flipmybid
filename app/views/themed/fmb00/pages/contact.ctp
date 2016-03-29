<div class="col-md-12 auctions">
<?php $page = $this->requestAction('/pages/getpage/contact-us'); ?>
<?php if(!empty($page)) : ?>
<div class="nav nav-tabs nav-justified">
<h2 style="margin: 9px 20px;"><?php echo $page['Page']['title']; ?></h2>
</div>
<div class="auction-content">

      <?php echo $page['Page']['content']; ?>
    <?php else: ?>

    <?php endif;?>
	<?php if($this->requestAction('/settings/enabled/contact_form')) : ?>
		<h2><?php __('Contact Form');?></h2>

<p><?php __('Use the form below to contact us and we will reply to your message within one working day.');?></p>
<p>
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->


<!-- Text input-->
<div class="form-group inner">
  <label class="col-md-4 control-label" for="PageName">First Name *</label>  
  <div class="col-md-4">
  <input id="PageName" name="PageName" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group inner">
  <label class="col-md-4 control-label" for="PageEmail">Email Address *</label>  
  <div class="col-md-4">
  <input id="PageEmail" name="PageEmail" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group inner">
  <label class="col-md-4 control-label" for="PageDepartmentId">Department *</label>
  <div class="col-md-4">
    <select id="PageDepartmentId" name="PageDepartmentId" class="form-control">
      <option value="1">Bidding</option>
      <option value="2">General Enquiry</option>
      <option value="">Payments</option>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group inner">
  <label class="col-md-4 control-label" for="PagePhone">Phone Number</label>  
  <div class="col-md-4">
  <input id="PagePhone" name="PagePhone" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group inner">
  <label class="col-md-4 control-label" for="PageSubject">Subject</label>  
  <div class="col-md-4">
  <input id="PageSubject" name="PageSubject" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Textarea -->
<div class="form-group inner">
  <label class="col-md-4 control-label" for="PageSubject">Your Message *</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="PageSubject" name="PageSubject"></textarea>
  </div>
</div>

<!-- Button -->
<div class="form-group inner">
  <label class="col-md-4 control-label" for=""></label>
  <div class="col-md-4">
    <button id="" name="" class="btn btn-register" style="margin:0 auto;padding:12px !important;width:250px !important;">Contact Us</button>
  </div>
</div>

</fieldset>
</form>		
		
<!-- original form 
		<?php // echo $form->create(null, array('url' => '/contact')); ?>

		<fieldset>
			<?php // echo $form->input('name', array('label' => 'Full Name <span class="required">*</span>'));?>
			<?php // echo $form->input('email', array('label' => 'Email Address<span class="required">*</span>')); ?>
			<?php
			// if(!empty($departments)) :
			//	echo $form->input('department_id', array('label' => 'Department *', 'empty' => 'Select', ));
			// endif;
			?>
			<?php // echo $form->input('phone', array('label' => 'Phone Number')); ?>
			<?php // echo $form->input('subject', array('label' => 'Subject')); ?>
			<?php // echo $form->input('message', array('label' => 'Your Message <span class="required">*</span>', 'type' => 'textarea'));?>
            <?php // echo $form->submit('Contact Us', array('class'=>'submit', 'div'=>false)); ?>
			<?php // echo $form->end(); ?>
		</fieldset>
 -->
	<?php endif; ?>

</div>
</div>