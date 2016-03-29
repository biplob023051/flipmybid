$(document).ready(function(){
	$('#carouselChange2').removeClass('carousel-inner').addClass('carousel-inner-list');
	if ($(window).width() <= 971){
		$('#collapseAccount').removeClass('in').addClass('collapse');
		$('#collapseDetails').removeClass('in').addClass('collapse');
	}
	if ($(window).width() <= 751){
		$('#collapseLogin').removeClass('in').addClass('collapse');
		$('#collapseRegister').removeClass('in').addClass('collapse');
	}

	if($(window).width() > 974) {
		$('#carouselChange').removeClass('carousel-inner').addClass('carousel-inner-list');
	}

	//$('.liveAuctionClick').on('click', function(e){
	//	e.preventDefault();
	//	$.ajax({
	//		url: '/auctions/index',
	//		type: 'POST',
	//		//data: auctions,
	//		success: function (data) {
	//			$('#page-content').html(data);
	//			auctionRefresh();
	//		}
	//	});
    //
	//});
    //
	//$('.closedAuctionClick').on('click', function(e){
	//	e.preventDefault();
	//	$.ajax({
	//		url: '/auctions/closed',
	//		type: 'POST',
	//		//data: auctions,
	//		success: function (data) {
	//			$('#page-content').html(data);
	//			auctionRefresh();
	//		}
	//	});
    //
	//});
    //
	//$('.upcomingAuctionClick').on('click', function(e){
	//	e.preventDefault();
	//	$.ajax({
	//		url: '/auctions/future',
	//		type: 'POST',
	//		//data: auctions,
	//		success: function (data) {
	//			$('#page-content').html(data);
	//			auctionRefresh();
	//		}
	//	});
	//});
	//$('.fb-login-button').on('click', function(e){
	//	e.preventDefault();


		//FB.login( function() {}, { scope: 'email,public_profile' } );
	//});



	//$('#bs-example-navbar-collapse-1').on('shown.bs.collapse', function(){
	//	console.log('aaa');
	//	var options = [{}];
	//	var data = [
	//		{
	//			value: 100,
	//			color:"#F7464A",
	//			highlight: "#FF5A5E",
	//			label: "Red"
	//		},
	//		{
	//			value: 400,
	//			color: "#46BFBD",
	//			highlight: "#5AD3D1",
	//			label: "Green"
	//		}
	//	];
	//	var ctx = document.getElementById("myChart").getContext("2d");
	//	var myDoughnutChart = new Chart(ctx).Doughnut(data,options);
	//});
});

//window.fbAsyncInit = function () {
//	FB.init({
//		appId      : '449785581872611',
//		cookie     : false,
//		xfbml      : true,
//		status     : false,
//		version    : 'v2.5'
//	});
//	FB.getLoginStatus(function(response) {
//		if (response.status === 'connected') {
//			console.log('Logged in.');
//		}
//		else {
//			FB.login();
//		}
//	});
//};
//
//(function(d, s, id){
//	var js, fjs = d.getElementsByTagName(s)[0];
//	if (d.getElementById(id)) {return;}
//	js = d.createElement(s); js.id = id;
//	js.src = "//connect.facebook.net/en_US/sdk.js";
//	fjs.parentNode.insertBefore(js, fjs);
//}(document, 'script', 'facebook-jssdk'));

$(window).resize(function(){
	$('#carouselChange2').removeClass('carousel-inner').addClass('carousel-inner-list');
	if ($(window).width() <= 971){
		$('#collapseAccount').removeClass('in').addClass('collapse');
		$('#collapseDetails').removeClass('in').addClass('collapse');
	} else {
		$('#collapseAccount').addClass('in').removeClass('collapse');
		$('#collapseDetails').addClass('in').removeClass('collapse');
	}

	if ($(window).width() >= 751){
		$('#collapseLogin').addClass('in').removeClass('collapse');
		$('#collapseRegister').addClass('in').removeClass('collapse');
	} else {
		$('#collapseLogin').removeClass('in').addClass('collapse');
		$('#collapseRegister').removeClass('in').addClass('collapse');
	}

	if ($(window).width() > 974){
		$('#carouselChange').removeClass('carousel-inner').addClass('carousel-inner-list');
	} else {
		$('#carouselChange').addClass('carousel-inner').removeClass('carousel-inner-list');
	}
});
