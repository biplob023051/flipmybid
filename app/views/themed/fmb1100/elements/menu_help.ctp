<div class="col-md-12 auctions">
<div class="m-none">
<?php $sections = $this->requestAction('/sections/getsections'); ?>


<?php if(!empty($sections)) : ?>
	<div class="module">
		<?php foreach ($sections as $section) : ?>
			<h4 class="heading">
			<?php if(!empty($question_id)) : ?>
				<?php echo $html->link($section['Section']['name'], array('action' => 'index', $section['Section']['id'], Inflector::slug($section['Section']['name'], '-'), $question['Question']['id'], Inflector::slug($question['Question']['question'], '-')));?>
			<?php else : ?>
				<?php echo $html->link($section['Section']['name'], array('action' => 'index', $section['Section']['id'], Inflector::slug($section['Section']['name'], '-')));?>
			<?php endif; ?>
			</h4>
			<?php if(empty($id)) : ?>
				<?php $id = $section['Section']['id']; ?>
			<?php endif; ?>

			<?php if($id == $section['Section']['id']) : ?>
				<?php $questions = $this->requestAction('/questions/getquestions/'.$section['Section']['id']); ?>
				<?php if(!empty($questions)) : ?>
					<ul class="questions">
						<?php foreach ($questions as $question) : ?>
							<li><?php echo $html->link($question['Question']['question'], array('action' => 'index', $section['Section']['id'], Inflector::slug($section['Section']['name'], '-'), $question['Question']['id'], Inflector::slug($question['Question']['question'], '-')));?></li>
						<?php endforeach; ?>
					</ul>
					<hr noshade size="1" color="#EAEAEA">
				<?php else : ?>
					<p><?php __('There are no questions in this section.'); ?></p>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php else : ?>
	<p><?php __('There are no help sections at the moment.'); ?></p>
<?php endif; ?>
</div>
<div class="d-none">

<p><?php __('Use the form below to contact us for help and we will reply to your message within one working day.');?></p>

<form class="form-horizontal">
<fieldset>

<!-- Form Name -->


<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="PageName">First Name *</label>  
  <div class="col-md-4">
  <input id="PageName" name="PageName" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="PageEmail">Email Address *</label>  
  <div class="col-md-4">
  <input id="PageEmail" name="PageEmail" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Select Basic
<div class="form-group">
  <label class="col-md-4 control-label" for="PageDepartmentId">Department *</label>
  <div class="col-md-4">
    <select id="PageDepartmentId" name="PageDepartmentId" class="form-control">
      <option value="1">Bidding</option>
      <option value="2">General Enquiry</option>
      <option value="">Payments</option>
    </select>
  </div>
</div>
 -->
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="PagePhone">Phone Number</label>  
  <div class="col-md-4">
  <input id="PagePhone" name="PagePhone" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>

<!-- Text input
<div class="form-group">
  <label class="col-md-4 control-label" for="PageSubject">Subject</label>  
  <div class="col-md-4">
  <input id="PageSubject" name="PageSubject" type="text" placeholder="" class="form-control input-md">
    
  </div>
</div>-->

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="PageSubject">Your Question *</label>
  <div class="col-md-4">                     
    <textarea class="form-control" id="PageSubject" name="PageSubject" rows="4"></textarea>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for=""></label>
  <div class="col-md-4">
    <button id="" name="" class="btn btn-register" style="margin:0 auto;padding:12px !important;width:250px !important;">Contact Us</button>
  </div>
</div>

</fieldset>
</form>		


</div>
</div>