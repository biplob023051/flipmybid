 window.fbAsyncInit = function () {
     FB.init({
			appId      : '780971695307080',
			cookie     : false,
			xfbml      : true,
			status     : false,
			version    : 'v2.1'
     });
  };
	(function (d) {
	 var js, id = 'facebook-jssdk',
		 ref = d.getElementsByTagName('script')[0];
	 if (d.getElementById(id)) {
		 return;
	 }
	 js = d.createElement('script');
	 js.id = id;
	 js.async = true;
	 js.src = "//connect.facebook.net/en_US/all.js";
	 ref.parentNode.insertBefore(js, ref);
	}(document));
	 
	function updateUIWithFacebookFields()
	{
		//console.log('4. Inside updateUIWithFacebookFields()');
		FB.api('/me', function(response)
		{
			//console.log('5. Inside api/me()');
			//console.log(response);

			var loginUsernameElm = document.getElementById('loginUsername');
			var registerUsernameElm = document.getElementById('UserUsername');
			var registerUsername2Elm = document.getElementById('UserUsername2');
			var registerUserEmailElm = document.getElementById('UserEmail');

			var emailAsUsername = response.email;
			emailAsUsername = getSafeStringFromEmail(emailAsUsername);
			
			if(loginUsernameElm)
			{
				loginUsernameElm.value = emailAsUsername;
			}
			if(registerUsernameElm)
			{
				registerUsernameElm.value = emailAsUsername;
			}
			if(registerUsername2Elm)
			{
				registerUsername2Elm.value = emailAsUsername;
			}
			if(registerUserEmailElm)
			{
				registerUserEmailElm.value = response.email;
			}
			
		});
	}
	 
	function statusChangeCallback(response)
	{
		//console.log('3. Inside statusChangeCallBack()');
		//console.log('statusChangeCallback');
		//console.log(response);
		if (response.status === 'connected') {
		  // Logged into your app and Facebook.
		  updateUIWithFacebookFields();
		} else if (response.status === 'not_authorized') {
		  // The person is logged into Facebook, but not your app.
		} else {
		  // Not logged in
		}
	}
	 
	function fbLogin()
	{
		//console.log('1. Inside fbLoginTest()');
		FB.getLoginStatus(function(response)
		{
			//console.log('2. Inside getLoginStatus()');
			statusChangeCallback(response);
		});
	}
	
	// Replaces all non-alphanumeric characters from a string. This is used for generating a username based on user's Facebook e-mail address
	function getSafeStringFromEmail(email)
	{
		var atSymbolIndex = email.indexOf('@');
		var emailBeforeAtSymbol = email.substring(0, atSymbolIndex);
		//console.log(emailBeforeAtSymbol);
		var punctuationless = emailBeforeAtSymbol.replace(/[\.,-\/#!$%\^&\*;:{}=\-_`~()]/g,"");
		var finalString = punctuationless.replace(/\s{2,}/g," ");
		return finalString;
	}