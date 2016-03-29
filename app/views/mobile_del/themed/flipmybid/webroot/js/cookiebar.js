function cookiebar() {
	var chk = chkCookie();
	if (chk != 1) {
		document.getElementById("cBanner").style.visibility = "visible";
	} else {
		document.getElementById("cBanner").style.display="none";
	}
}

// allow/check cookies
function allowCookie() {
	setCookie("fmbAllowCookies", 1, 730);
	//document.getElementById("cBanner").style.visibility = "hidden";
	document.getElementById("cBanner").style.display="none";
}
function chkCookie() {
	return unescape(getCookie("fmbAllowCookies"));
}

// set/get cookies
function setCookie(c_name, value, exdays) {
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString()) + "; path=/";
	document.cookie = c_name + "=" + c_value;
}
function getCookie(c_name) {
	var i, x, y, ARRcookies = document.cookie.split(";");
	for (i = 0; i < ARRcookies.length; i++) {
		x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
		y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
		x = x.replace(/^\s+|\s+$/g, "");
		if (x == c_name) {
			return unescape(y);
		}
	}
}