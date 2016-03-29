<div class="col-md-12 auctions">
	<div class="">
	<h2 style="margin: 9px 20px;">Register<div class="m-none"> for Free... and in less than 1 minute!</div></h2>
	</div>
	<div class="row auction-content">
<?php echo $form->create('User', array('action' => 'register', 'class'=>'form-horizontal'));?>
		<div class="col-md-6">
		<div class="form-group">
				<div class="col-sm-4">
				<label for="UserUsername" class="control-label">Username <span>*</span></label>
				</div>
				<div class="col-sm-8">
				<?php echo $form->input('username', array('class'=>'form-control', 'label' => false, 'div'=>false));?>
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
			<div class="form-group">
				<div class="col-sm-4">
				<label for="UserConfirmEmail" class="control-label">Confirm Email <span>*</span></label>
				</div>
				<div class="col-sm-8">
				<?php echo $form->input('confirm_email', array('class'=>'form-control', 'label' => false, 'div'=>false)); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-4">
				<label for="UserBeforePassword" class="control-label">Password <span>*</span></label>
				</div>
				<div class="col-sm-8">
				<?php echo $form->input('before_password', array('class'=>'form-control', 'value' => '', 'type' => 'password', 'label' => false, 'div'=>false)); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-4">
				<label for="UserRetypePassword" class="control-label">Retype Password <span>*</span></label>
				</div>
				<div class="col-sm-8">
				<?php echo $form->input('retype_password', array('class'=>'form-control', 'value' => '', 'type' => 'password', 'label' => false, 'div'=>false)); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-4">
				<label for="UserFirstName" class="control-label">First Name <span>*</span></label>
				</div>
				<div class="col-sm-8">
				<?php echo $form->input('first_name', array('class'=>'form-control', 'label' => false, 'div'=>false)); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-4">
				<label for="UserLastName" class="control-label">Last Name <span>*</span></label>
				</div>
				<div class="col-sm-8">
				<?php echo $form->input('last_name', array('class'=>'form-control', 'label' => false, 'div'=>false));?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-4">
				<label for="UserGenderId" class="control-label">Gender</label>
				</div>
				<div class="col-sm-8">
				<?php echo $form->input('gender_id', array('class'=>'form-control', 'type' => 'select', 'label' => false, 'div'=>false));  ?>
				</div>
			</div>			
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<div class="col-sm-4">
				<label for="" class="control-label">Date of Birth <span>*</span></label>
				</div>
				<div class="col-sm-8 form-inline">
				<select class="form-control">
					<option value="01">January</option>
					<option value="02">February</option>
					<option value="03">March</option>
					<option value="04">April</option>
					<option value="05">May</option>
					<option value="06">June</option>
					<option value="07">July</option>
					<option value="08">August</option>
					<option value="09">September</option>
					<option value="10">October</option>
					<option value="11" selected="selected">November</option>
					<option value="12">December</option>
				</select>
				<select class="form-control" style="padding: 6px 11px;">
					<option value="01">1</option>
					<option value="02">2</option>
					<option value="03">3</option>
					<option value="04">4</option>
					<option value="05">5</option>
					<option value="06">6</option>
					<option value="07">7</option>
					<option value="08">8</option>
					<option value="09">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					<option value="13">13</option>
					<option value="14" selected="selected">14</option>
					<option value="15">15</option>
					<option value="16">16</option>
					<option value="17">17</option>
					<option value="18">18</option>
					<option value="19">19</option>
					<option value="20">20</option>
					<option value="21">21</option>
					<option value="22">22</option>
					<option value="23">23</option>
					<option value="24">24</option>
					<option value="25">25</option>
					<option value="26">26</option>
					<option value="27">27</option>
					<option value="28">28</option>
					<option value="29">29</option>
					<option value="30">30</option>
					<option value="31">31</option>
				</select>				
				<select class="form-control">
					<option value="1997">1997</option>
					<option value="1996">1996</option>
					<option value="1995">1995</option>
					<option value="1994">1994</option>
					<option value="1993">1993</option>
					<option value="1992">1992</option>
					<option value="1991">1991</option>
					<option value="1990">1990</option>
					<option value="1989">1989</option>
					<option value="1988">1988</option>
					<option value="1987">1987</option>
					<option value="1986">1986</option>
					<option value="1985">1985</option>
					<option value="1984">1984</option>
					<option value="1983">1983</option>
					<option value="1982">1982</option>
					<option value="1981">1981</option>
					<option value="1980">1980</option>
					<option value="1979">1979</option>
					<option value="1978">1978</option>
					<option value="1977">1977</option>
					<option value="1976">1976</option>
					<option value="1975">1975</option>
					<option value="1974">1974</option>
					<option value="1973">1973</option>
					<option value="1972">1972</option>
					<option value="1971">1971</option>
					<option value="1970">1970</option>
					<option value="1969">1969</option>
					<option value="1968">1968</option>
					<option value="1967">1967</option>
					<option value="1966">1966</option>
					<option value="1965">1965</option>
					<option value="1964">1964</option>
					<option value="1963">1963</option>
					<option value="1962">1962</option>
					<option value="1961">1961</option>
					<option value="1960">1960</option>
					<option value="1959">1959</option>
					<option value="1958">1958</option>
					<option value="1957">1957</option>
					<option value="1956">1956</option>
					<option value="1955">1955</option>
					<option value="1954">1954</option>
					<option value="1953">1953</option>
					<option value="1952">1952</option>
					<option value="1951">1951</option>
					<option value="1950">1950</option>
					<option value="1949">1949</option>
					<option value="1948">1948</option>
					<option value="1947">1947</option>
					<option value="1946">1946</option>
					<option value="1945">1945</option>
					<option value="1944">1944</option>
					<option value="1943">1943</option>
					<option value="1942">1942</option>
					<option value="1941">1941</option>
					<option value="1940">1940</option>
					<option value="1939">1939</option>
					<option value="1938">1938</option>
					<option value="1937">1937</option>
					<option value="1936">1936</option>
					<option value="1935">1935</option>
					<option value="1934">1934</option>
					<option value="1933">1933</option>
					<option value="1932">1932</option>
					<option value="1931">1931</option>
					<option value="1930">1930</option>
					<option value="1929">1929</option>
					<option value="1928">1928</option>
					<option value="1927">1927</option>
					<option value="1926">1926</option>
					<option value="1925">1925</option>
					<option value="1924">1924</option>
					<option value="1923">1923</option>
					<option value="1922">1922</option>
					<option value="1921">1921</option>
					<option value="1920">1920</option>
					<option value="1919">1919</option>
					<option value="1918">1918</option>
					<option value="1917">1917</option>
					<option value="1916">1916</option>
					<option value="1915">1915</option>
				</select>						
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-4">
				<label for="UserReferrer" class="control-label">Referred By</label>
				</div>
				<div class="col-sm-8">
				<?php if($this->requestAction('/settings/enabled/referrals') && empty($this->data['User']['hideReferral'])): ?>
					<?php echo $form->input('referrer', array('class'=>'form-control', 'label' => false, 'div'=>false)); ?>
				<?php endif; ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-8 captcha">
				<?php echo $this->Captcha->input();?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-8">
				<?php echo $form->input('terms', array('type' => 'checkbox', 'label' => false, 'style'=>'width: 20px;', 'div'=>false, 'after' => 'Read & accept the <a target="_blank" href="/page/terms-and-conditions">terms</a>?')); ?>
				</div>
			</div>			
			<div class="form-group">
			<div class="col-md-6">
				<button type="submit" class="btn btn-register" style="margin:0 auto;padding:12px !important;width:250px !important;">Register</button>
			</div>
			</div>			
		</div>
	<?php echo $form->end(); ?>
	</div>
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