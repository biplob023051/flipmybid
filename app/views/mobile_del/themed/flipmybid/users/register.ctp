		<div class="g1 r-register">
			<div id="auctions-easyview" class="rounded">
				<div id="tabs">
					<h2>Register for Free... and in less than 1 minute!</h2>
				</div>
                <?php echo $form->create('User', array('action' => 'register'));?>
				<div class="g2 left">
                    	<ul>
                            <li>
                                <?php echo $form->input('username', array('label'=>'Username <span>*</span>', 'div'=>false));?>
                            </li>
                            <li>
                                <?php echo $form->input('email', array('label' => 'Email <span>*</span>', 'div'=>false)); ?>
                            </li>
                            <li>
                                <?php echo $form->input('confirm_email', array('label' => 'Confirm Email <span>*</span>', 'div'=>false)); ?>
                            </li>
                            <li>
                                <?php echo $form->input('before_password', array('value' => '', 'type' => 'password', 'label' => 'Password <span>*</span>', 'div'=>false)); ?>
                            </li>
                            <li>
                                <?php echo $form->input('retype_password', array('value' => '', 'type' => 'password', 'label' => 'Retype Password <span>*</span>', 'div'=>false)); ?>
                            </li>
                            
                            <li>
                                <?php echo $form->input('first_name', array('label' => 'First Name <span>*</span>', 'div'=>false)); ?>
                            </li>
                            <li>
                                <?php echo $form->input('last_name', array('label' => 'Last Name <span>*</span>', 'div'=>false));?>
                            </li>
                            <li>
                                <?php echo $form->input('gender_id', array('type' => 'select', 'label' => 'Gender', 'div'=>false));  ?>
                            </li>
                            
				</div>
				<div class="g2">
                		<ul>
                            
                            <li>
                                <?php echo $form->input('date_of_birth', array('minYear' => $appConfigurations['Dob']['year_min'], 'maxYear' => $appConfigurations['Dob']['year_max'], 'label' => 'Date of Birth <span>*</span>', 'separator' => '<span>&nbsp&nbsp;</span>', 'div'=>false)); ?>
                            </li>
                            <li>
                                <?php if($this->requestAction('/settings/enabled/referrals') && empty($this->data['User']['hideReferral'])): ?>
                                    <?php echo $form->input('referrer', array('label' => 'Referred By', 'div'=>false)); ?>
                                <?php endif; ?>
                            </li>
                            <div class="radio-group captcha-register">
                                <?php echo $this->Captcha->input();?>
                            </div>
                            
                            
                            <div class="radio-group">
                                <li>
                                    <label style="margin-top: 0;">How did you find us? </label>
                                    <?php echo $form->hidden('source_id', array('value' => ''));?>
                            <?php $counter = 0; foreach($sources as $source): $counter++?>
                                
                                    <input type="radio" <?php if(!empty($this->data['User']['source_id']) && $this->data['User']['source_id'] == $source['Source']['id']) echo 'checked="checked"';?> title="<?php echo $source['Source']['extra'];?>" id="source_<?php echo $source['Source']['id'];?>" name="data[User][source_id]" value="<?php echo $source['Source']['id'];?>" style="width: 20px;"/>
                                    <?php echo $source['Source']['name'];?>
                                <?php if($counter % 3 == 0):?>    
                                    </li><li><label>&nbsp;</label>
                                <?php endif;?>
                            <?php endforeach;?>
                            <?php echo $form->error('source_id');?>

                            <li id="sourceExtraBlock" style="display: none">
								<?php echo $form->input('source_extra', array('id' => 'sourceExtra', 'label' => __('Site Name *', true), 'div' => false));?>
							</li>
                            </div>
                            
                            <li>
                                <label>&nbsp;</label>
                                <?php echo $form->input('newsletter', array('label' => false, 'style' =>'width: 20px;', 'div'=>false, 'after'=>'Sign up for our newsletter')); ?>
                            </li>
                            <li>
                                <label>&nbsp;</label>
                                <?php echo $form->input('terms', array('type' => 'checkbox', 'label' => false, 'style'=>'width: 20px;', 'div'=>false, 'after' => 'Read & accept the <a target="_blank" href="/page/terms-and-conditions">terms</a>?')); ?>
                            </li>
                            
                            
                            <li>
                                <label>&nbsp;</label>
                                <?php echo $form->submit('Register',array('div'=>false, 'class'=>'submit'));?>
                            </li>
                    	</ul>
				</div>
                <?php echo $form->end(); ?>
			</div>
			<!--/ Auctions -->
		</div>

		<script type="text/javascript">
	$(document).ready(function(){
		$('.radio-group input').click(function(){
			if($(this).attr('title')){
				if($(this).attr('title') == 1){
					$('#sourceExtraBlock').show(1);
				}else{
					$('#sourceExtraBlock').hide(1);
					$('#sourceExtra').val('');
				}
			}
		});

		if($('.radio-group input:checked').attr('title') == 1){
			$('#sourceExtraBlock').show(1);
		}
	});
</script>
