<?php
// Get original here: http://www.maxmind.com/download/geoip/api/php/sample_city.php
// Modified by Drew Yeaton, Sentinel Design Group, (http://www.sentineldesign.net/)

class GeoIpComponent extends Object {
    function lookupIp($ip) {
        App::import('Vendor', 'geoip'.DS.'geoipcity');

if(substr($_SERVER['DOCUMENT_ROOT'], -12) !== '/app/webroot') {
	$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'].'/app/webroot';
}

        $gi = geoip_open($_SERVER['DOCUMENT_ROOT']."/files/GeoIPCity.dat", GEOIP_STANDARD);
        $result = geoip_record_by_addr($gi, $ip);
        geoip_close($gi);
		if(!empty($result)) {
			return get_object_vars($result);
		} else {
			return null;
		}
    }

    function findIp() {
      if(getenv("HTTP_CLIENT_IP"))
        return getenv("HTTP_CLIENT_IP");
      elseif(getenv("HTTP_X_FORWARDED_FOR"))
        return getenv("HTTP_X_FORWARDED_FOR");
      else
        return getenv("REMOTE_ADDR");
    }
}

?>