        <div class="col-md-12 auctions">
			<div class="nav nav-tabs nav-justified">
               <h2 style="margin: 9px 20px;">Login or Register!</h2>
			   </div>
			 <div class="row auction-content">
              <?php echo $form->create('User', array('action' => 'login', 'class'=>'form-horizontal'));?>
			 <div class="col-md-6">

				<div class="form-group">
					<div class="col-sm-4">
					<label for="UserUsername" class="control-label">Username <span>*</span></label>
					</div>
					<div class="col-sm-8">
                        <?php echo $form->input('username', array('class'=>'form-control', 'label' => false, 'div'=>false)); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">
					<label for="UserPassword" class="control-label">Password <span>*</span></label>
					</div>
					<div class="col-sm-8">
                        <?php echo $form->input('password', array('class'=>'form-control', 'label' => false, 'div'=>false)); ?>
					</div>
				</div>
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				  <div class="checkbox">
					<label>
					  <input type="checkbox"> Remember me
					</label>
				  </div>
				</div>				
            </div>
			<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-register">Login</button>
			</div>
			</div>				
			</div>				
            <div class="col-md-6">
                <?php echo $form->create('User', array('action' => 'register'));?>
				<div class="form-group">
					<div class="col-sm-4">
					<label for="UserUsername" class="control-label">Username <span>*</span></label>
					</div>
					<div class="col-sm-8">
                        <?php echo $form->input('username', array('class'=>'form-control', 'label' => false, 'div'=>false)); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">
					<label for="UserBeforePassword" class="control-label">Password <span>*</span></label>
					</div>
					<div class="col-sm-8">
                        <?php echo $form->input('before_password', array('class'=>'form-control', 'label' => false, 'div'=>false)); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-4">
					<label for="UserEmail" class="control-label">Email <span>*</span></label>
					</div>
					<div class="col-sm-8">
                        <?php echo $form->input('email', array('class'=>'form-control', 'label' => false, 'div'=>false)); ?>
					</div>
				</div>				
                    <p>
                        <label>&nbsp;</label>
                        <?php echo $form->input('terms', array('type' => 'checkbox', 'label' => false, 'style'=>'width: 20px;', 'div'=>false, 'after' => ' Read & accept the <a target="_blank" href="/page/terms-and-conditions">terms</a>?')); ?>
                        </p>
                        <p class="radio-group captcha-register">
                            <?php //echo $this->Captcha->input();?>     
                        </p>
			<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-register">Register</button>
			</div>
			</div>	
					<!-- <p style="font-size:16px; width: 114%; text-align: center;">
						<span class="font-size:16px !important;">Or<br /><fb:login-button scope="public_profile,email" size="large" onlogin="fbLogin();">Sign up with Facebook</fb:login-button></span>
					 </p> -->

            </div>
            </div>
                <?php echo $form->end(); ?>			
        </div>
        <!--/ Auctions -->
