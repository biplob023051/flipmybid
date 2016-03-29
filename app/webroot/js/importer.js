$(document).ready(function(){
	$('.importAction').click(function(){
		var service_name = $(this).attr('title');

		$('#importer_service').html(service_name);
		$('#importer_form form').attr('action', $(this).attr('href'));
		$('#importer_form').show();

		return false;
	});

	$('.importerSubmit').click(function(){

		if($('.importerLogin').val() == ''){
			alert('Login is required');
			return false;
		}

		if($('.importerPassword').val() == ''){
			alert('Password is required');
			return false;
		}

		$('#importer_form').hide();
		$('#importer_inprogress').show();

		var postdata = "login=" + $('.importerLogin').val() + "&password=" + $('.importerPassword').val();
		$.post(
			$('#importer_form form').attr('action'),
			postdata,
			function(result){
				if(result){
					$('#recipient_list').val($('#recipient_list').val() + result);
				}else{
					alert('Could not import the contact. Please try again.')
				}
				$('.importerLogin').val('');
				$('.importerPassword').val('');
				$('#importer_inprogress').hide();
			}
		);

		return false;
	});
});