<?php

define ('ERROR_UNKNOWN_OS',1);
define ('ERROR_UNSUPPORTED_OS',2);
define ('ERROR_UNKNOWN_ARCH',3);
define ('ERROR_UNSUPPORTED_ARCH',4);
define ('ERROR_UNSUPPORTED_ARCH_OS',5);
define ('ERROR_WINDOWS_64_BIT',6);
define ('ERROR_PHP_UNSUPPORTED',7);
define ('ERROR_PHP_DEBUG_BUILD',8);
define ('ERROR_RUNTIME_EXT_DIR_NOT_FOUND',101);
define ('ERROR_RUNTIME_LOADER_FILE_NOT_FOUND',102);
define ('ERROR_INI_NOT_FIRST_ZE',201);
define ('ERROR_INI_WRONG_ZE_START',202);
define ('ERROR_INI_ZE_LINE_NOT_FOUND',203);
define ('ERROR_INI_LOADER_FILE_NOT_FOUND',204);
define ('ERROR_INI_NOT_FULL_PATH',205);
define ('ERROR_INI_NO_PATH',206);
define ('ERROR_INI_NOT_FOUND',207);
define ('ERROR_INI_NOT_READABLE',208);
define ('ERROR_INI_MULTIPLE_IC_LOADER_LINES',209);
define ('ERROR_INI_USER_INI_NOT_FOUND',210);
define ('ERROR_INI_USER_CANNOT_CREATE',211);
define ('ERROR_LOADER_UNEXPECTED_NAME',301);
define ('ERROR_LOADER_NOT_READABLE',302);
define ('ERROR_LOADER_PHP_MISMATCH',303);
define ('ERROR_LOADER_NONTS_PHP_TS',304);
define ('ERROR_LOADER_TS_PHP_NONTS',305);
define ('ERROR_LOADER_WRONG_OS',306);
define ('ERROR_LOADER_WRONG_ARCH',307);
define ('ERROR_LOADER_WRONG_GENERAL',308);
define ('ERROR_LOADER_WIN_SERVER_NONWIN',321);
define ('ERROR_LOADER_WIN_NONTS_PHP_TS',322);
define ('ERROR_LOADER_WIN_TS_PHP_NONTS',323);
define ('ERROR_LOADER_WIN_PHP_MISMATCH',324);
define ('ERROR_LOADER_WIN_COMPILER_MISMATCH',325);
define ('ERROR_LOADER_NOT_FOUND',380);
define ('ERROR_LOADER_PHP_VERSION_UNKNOWN',390);


define ('SERVER_UNKNOWN',0);
define ('HAS_PHP_INI',1);
define ('SERVER_SHARED',2); 
define ('SERVER_VPS',5); 
define ('SERVER_DEDICATED',7); 
define ('SERVER_LOCAL',9);

define ('LOADERS_PAGE',
            'http://loaders.ioncube.com/');                                 
define ('SUPPORT_SITE',
            'http://support.ioncube.com/');                                 
define ('LOADER_FORUM_URL',
            'http://forum.ioncube.com/viewforum.php?f=4');                  
define ('LOADERS_FAQ_URL',
            'http://www.ioncube.com/faqs/loaders.php');                     
define ('UNIX_ERRORS_URL',
            'http://www.ioncube.com/loaders/unix_startup_errors.php');      
define ('LOADER_WIZARD_URL',
            LOADERS_PAGE);                                                  
define ('ENCODER_URL',
            'http://www.ioncube.com/sa_encoder.php');                       
define ('LOADER_VERSION_URL',
            'http://www.ioncube.com/feeds/product_info/versions.php');    
define ('WIZARD_LATEST_VERSION_URL',
            LOADER_VERSION_URL . '?item=loader-wizard'); 
define ('PHP_COMPILERS_URL',
            LOADER_VERSION_URL . '?item=php-compilers');
define ('LOADER_PLATFORM_URL',
            LOADER_VERSION_URL . '?item=loader-platforms-all');   
define ('LOADER_LATEST_VERSIONS_URL',
            LOADER_VERSION_URL . '?item=loader-versions'); 
define ('LOADER_PHP_SUPPORT_URL',
            LOADER_VERSION_URL . '?item=loader-php-support'); 
define ('WIZARD_STATS_URL',
            'http://www.ioncube.com/feeds/stats/wizard.php');    
define ('IONCUBE_DOWNLOADS_SERVER',
            'http://downloads2.ioncube.com/loader_downloads');          
define ('IONCUBE_CONNECT_TIMEOUT',4);

define ('DEFAULT_SELF','/ioncube/loader-wizard.php');
define ('LOADER_NAME_CHECK',true);
define ('LOADER_EXTENSION_NAME','ionCube Loader');
define ('LOADER_SUBDIR','ioncube');
define ('WINDOWS_IIS_LOADER_DIR', 'system32');
define ('ADDITIONAL_INI_FILE_NAME','20ioncube.ini');
define ('UNIX_SYSTEM_LOADER_DIR','/usr/local/ioncube');
define ('RECENT_LOADER_VERSION','3.1.24');
define ('LATEST_LOADER_MAJOR_VERSION',4);
define ('LOADERS_PACKAGE_PREFIX','ioncube_loaders_');
define ('SESSION_LIFETIME_MINUTES',360);
define ('WIZARD_EXPIRY_MINUTES',10080);
define ('MIN_INITIALISE_TIME',4);



if (isset($_GET['action'])) {

  $accessible_actions = array('info','get_all_ini_files','is_loader_installed','is_thread_safe','get_loader_name','loader_download_url','get_loaded_ini_file','is_cgi',
  'get_phprc','get_sys_information','get_loader_version','get_latestversion','is_ms_windows','support_ticket_information','get_word_size','selinux_is_enabled_li','extension_dir',
  'is_supported_php_version','is_after_max_php_version_supported','get_max_php_version_supported','php_version_as_string','server_software_info_li','ini_file_name','get_base_dir',
  'default_ini_path','is_legacy_platform','get_this_dir','get_loader_install_dir');

  $action = trim($_GET['action']);
  
  if (!empty($action) && in_array($action, $accessible_actions)) {
  
    $result = $action();
    $result = 'response:'.$result;
    
    echo $result;    
  }
}

function get_base_dir() {
	return realpath(__DIR__);
}

function info() {
  if (function_is_disabled('phpinfo')) {
      return "phpinfo is disabled on this server";
  } else {
		ob_start();
        phpinfo();
        $pinfo = ob_get_contents();
        ob_end_clean();
      return $pinfo;
  }
}

function is_loader_installed() {

  if (extension_loaded("ionCube Loader")) {
    return "1";
  }
  else {
    return "0";
  }
}

function php_version_as_string() {
  $res = php_version();
  
  return $res['major'].".".$res['minor'].".".$res['release'];
}

function remote_file_contents($url)
{
    $remote_file_opening = ini_get('allow_url_fopen');
    $contents = false;
    if (isset($_SESSION['timing_out']) && $_SESSION['timing_out']) {
        return false;
    }
    @session_write_close();
    $timing_out = 0;
    if ($remote_file_opening) {
        $fh = @fopen($url,'rb');
        if ($fh) {
            stream_set_blocking($fh,0);
            stream_set_timeout($fh,IONCUBE_CONNECT_TIMEOUT);
            while (!feof($fh)) {
                $result = fread($fh, 4096);
                $info = stream_get_meta_data($fh);
                $timing_out = $info['timed_out']?1:0;
                if ($timing_out) {
                    break;
                }
                if ($result !== false) {
                    $contents .= $result;
                } else {
                    break;
                }
            }
            fclose($fh);
        } else {
            $timing_out = 1;
        }
    } elseif (extension_loaded('curl')) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,IONCUBE_CONNECT_TIMEOUT);
            $output = curl_exec($ch);
            $info = curl_getinfo($ch);
            $timing_out = ($info['http_code'] >= 400)?1:0;
            curl_close($ch);

            if (is_string($output)) {
                $contents = $output;
            }
    } else {
        $timing_out = 1;
    }
    @session_start();
    $_SESSION['timing_out'] = $timing_out;
    return $contents;
}

function default_php_versions()
{
 return array();
}

function php_version()
{
    $v = explode('.',PHP_VERSION);

    return array(
           'major'      =>  $v[0],
           'minor'      =>  $v[1],
           'release'    =>  $v[2]);
}

function php_version_maj_min()
{
    $vprts = php_version();
    return ($vprts['major'] . '.' . $vprts['minor']);
}

function get_php_versions()
{
	return get_remote_session_value('php_version_info',LOADER_PHP_VERSION_URL,'default_php_versions');
}

function get_max_php_version_supported()
{
	static $max_php_version;
	
	if (empty($max_php_version)) {
		$php_versions = get_php_versions();
		
		$dirname = calc_dirname();
		
		if (array_key_exists($dirname,$php_versions)) {
			$max_php_version = $php_versions[$dirname];
		} else {
			$max_php_version = NULL;
		}
	}
	
	return $max_php_version;
}

function is_after_max_php_version_supported()
{	
	$supported_php_version = get_max_php_version_supported();
	
	if (!is_null($supported_php_version)) {
		$pversion = php_version();
		
		$supported_parts = explode('.',$supported_php_version);
		$is_too_recent_php = ($supported_parts[0] < $pversion['major'] || ($supported_parts[0] == $pversion['major'] && $supported_parts[1] < $pversion['minor']));
	}
	
	if ($is_too_recent_php) {
		return "1";
	} else {
		return "0";
	}
}

function is_supported_php_version()
{
    $v = php_version(); 

    if ((($v['major'] == 4) && ($v['minor'] >= 1)) ||
      (($v['major'] == 5) && (($v['minor'] >= 1) || ($v['release'] >= 3)))) {
		return "1";
      }
      else {
		return "0";
      }
}

function is_php_version_or_greater($major,$minor,$release = 0)
{
    $version = php_version();
    return ($version['major'] > $major || 
            ($version['major'] == $major && $version['minor'] > $minor) ||
            ($version['major'] == $major && $version['minor'] == $minor && $version['release'] >= $release));
}

function ini_file_name()
{
    $sysinfo = get_sysinfo();
    return (!empty($sysinfo['PHP_INI'])?$sysinfo['PHP_INI_BASENAME']:'php.ini');
}

function get_remote_session_value($session_var,$remote_url,$default_function)
{
    if (!isset($_SESSION[$session_var])) {
        $serialised_res = remote_file_contents($remote_url);
        $unserialised_res = @unserialize($serialised_res);
        if (empty($unserialised_res)) {
            $unserialised_res = call_user_func($default_function);
        }
        if (false === $unserialised_res) {
            $unserialised_res = '';
        }
        $_SESSION[$session_var] = $unserialised_res;
    }
    return $_SESSION[$session_var];
}

function get_file_contents($file)
{
    if (function_exists('file_get_contents')) {
        $strs = @file_get_contents($file);
    } else {
        $lines = @file($file);
        $strs = join(' ',$lines);
    }
    return $strs;
}

function default_platform_list()
{
    $platforms = array();

    $platforms[] = array('os'=>'win', 'os_human'=>'Windows VC6', 'is_legacy' => 1,       'os_mod' => '_vc6',     'arch'=>'x86',  'dirname'=>'win32', 'us1-dir'=>'windows_vc6/x86' );
    $platforms[] = array('os'=>'win', 'os_human'=>'Windows VC6 (Non-TS)',   'is_legacy' => 1,  'os_mod' => '_nonts_vc6',   'arch'=>'x86',  'dirname'=>'win32-nonts', 'us1-dir'=>'windows_vc6/x86-nonts' );

    $platforms[] = array('os'=>'win', 'os_human'=>'Windows VC9',        'os_mod' => '_vc9',     'arch'=>'x86',  'dirname'=>'win32_vc9', 'us1-dir'=>'windows_vc9/x86' );
    $platforms[] = array('os'=>'win', 'os_human'=>'Windows VC9 (Non-TS)',   'os_mod' => '_nonts_vc9',   'arch'=>'x86',  'dirname'=>'win32-nonts_vc9', 'us1-dir'=>'windows_vc9/x86-nonts' );
    
    $platforms[] = array('os'=>'win', 'os_human'=>'Windows VC11', 'os_mod' => '_vc11', 'arch'=>'x86', 'dirname'=>'win32_vc11', 'us1-dir'=>'windows_vc11/x86' );
	$platforms[] = array('os'=>'win', 'os_human'=>'Windows VC11 (Non-TS)', 'os_mod' => '_nonts_vc11', 'arch'=>'x86', 'dirname'=>'win32-nonts_vc11', 'us1-dir'=>'windows_vc11/x86-nonts' );
	$platforms[] = array('os'=>'win', 'os_human'=>'Windows VC11', 'os_mod' => '_vc11', 'arch'=>'x86-64', 'dirname'=>'win64_vc11', 'us1-dir'=>'windows_vc11/amd64' );
	$platforms[] = array('os'=>'win', 'os_human'=>'Windows VC11 (Non-TS)', 'os_mod' => '_nonts_vc11', 'arch'=>'x86-64', 'dirname'=>'win64-nonts_vc11', 'us1-dir'=>'windows_vc11/amd64-nonts' );

    $platforms[] = array('os'=>'lin', 'os_human'=>'Linux',              'arch'=>'x86',      'dirname'=>'linux_i686-glibc2.3.4', 'us1-dir'=>'linux/x86');
    $platforms[] = array('os'=>'lin', 'os_human'=>'Linux',              'arch'=>'x86-64',   'dirname'=>'linux_x86_64-glibc2.3.4', 'us1-dir'=>'linux/x86_64');
	$platforms[] = array('os'=>'lin','os_human'=>'Linux',               'arch'=>'ppc',      'dirname'=>'linux_ppc-glibc2.3.4','us1-dir'=>'linux/ppc');
	$platforms[] = array('os'=>'lin','os_human'=>'Linux',               'arch'=>'ppc64',    'dirname'=>'linux_ppc64-glibc2.5','us1-dir'=>'linux/ppc64');
	    
	$platforms[] = array('os'=>'dra', 'os_human'=>'DragonFly', 'arch'=>'x86', 'dirname'=>'dragonfly_i386-1.7', 'us1-dir'=>'Dragonfly/x86');

	$platforms[] = array('os'=>'fre', 'os_human'=>'FreeBSD 4', 'os_mod'=>'_4',  'arch'=>'x86',      'dirname'=>'freebsd_i386-4.8', 'us1-dir'=>'FreeBSD/v4');

    $platforms[] = array('os'=>'fre', 'os_human'=>'FreeBSD 6', 'os_mod'=>'_6',  'arch'=>'x86',      'dirname'=>'freebsd_i386-6.2', 'us1-dir'=>'FreeBSD/v6/x86');

    $platforms[] = array('os'=>'fre', 'os_human'=>'FreeBSD 6', 'os_mod'=>'_6',  'arch'=>'x86-64',   'dirname'=>'freebsd_amd64-6.2', 'us1-dir'=>'FreeBSD/v6/AMD64');


    $platforms[] = array('os'=>'fre', 'os_human'=>'FreeBSD 7', 'os_mod'=>'_7',  'arch'=>'x86',      'dirname'=>'freebsd_i386-7.3', 'us1-dir'=>'FreeBSD/v7/x86');
    $platforms[] = array('os'=>'fre', 'os_human'=>'FreeBSD 7', 'os_mod'=>'_7',  'arch'=>'x86-64',   'dirname'=>'freebsd_amd64-7.3', 'us1-dir'=>'FreeBSD/v7/AMD64');


    $platforms[] = array('os'=>'fre', 'os_human'=>'FreeBSD 8', 'os_mod'=>'_8',  'arch'=>'x86',      'dirname'=>'freebsd_i386-8.0', 'us1-dir'=>'FreeBSD/v8/x86');
    $platforms[] = array('os'=>'fre', 'os_human'=>'FreeBSD 8', 'os_mod'=>'_8',  'arch'=>'x86-64',   'dirname'=>'freebsd_amd64-8.0', 'us1-dir'=>'FreeBSD/v8/AMD64');
    
    $platforms[] = array('os'=>'bsd', 'os_human'=>'BSDi',     'is_legacy' => 1,           'arch'=>'x86',      'dirname'=>'bsdi_i386-4.3.1');
    $platforms[] = array('os'=>'net', 'os_human'=>'NetBSD',             'arch'=>'x86',      'dirname'=>'netbsd_i386-2.1','us1-dir'=>'NetBSD/x86');
    $platforms[] = array('os'=>'net', 'os_human'=>'NetBSD',             'arch'=>'x86-64',   'dirname'=>'netbsd_amd64-2.0','us1-dir'=>'NetBSD/x86_64');
    $platforms[] = array('os'=>'ope', 'os_human'=>'OpenBSD 4.2', 'os_mod'=>'_4.2',  'arch'=>'x86',  'dirname'=>'openbsd_i386-4.2', 'us1-dir'=>'OpenBSD/x86');

    $platforms[] = array('os'=>'ope', 'os_human'=>'OpenBSD 4.5', 'os_mod'=>'_4.5',  'arch'=>'x86',  'dirname'=>'openbsd_i386-4.5', 'us1-dir'=>'OpenBSD/x86');
    $platforms[] = array('os'=>'ope', 'os_human'=>'OpenBSD 4.6', 'os_mod'=>'_4.6',  'arch'=>'x86',  'dirname'=>'openbsd_i386-4.6', 'us1-dir'=>'OpenBSD/x86');

    $platforms[] = array('os'=>'ope', 'os_human'=>'OpenBSD 4.7', 'os_mod'=>'_4.7',  'arch'=>'x86-64', 'dirname'=>'openbsd_amd64-4.7', 'us1-dir' => 'OpenBSD/x86_64');

    $platforms[] = array('os'=>'dar', 'os_human'=>'OS X',    'is_legacy' => 1, 'arch'=>'ppc',      'dirname'=>'osx_powerpc-8.5','us1-dir'=>'OSX/ppc');

    $platforms[] = array('os'=>'dar', 'os_human'=>'OS X',               'arch'=>'x86',      'dirname'=>'osx_i386-8.11','us1-dir'=>'OSX/x86');

    $platforms[] = array('os'=>'dar', 'os_human'=>'OS X',               'arch'=>'x86-64',       'dirname'=>'osx_x86-64-10.2','us1-dir'=>'OSX/x86_64');

    $platforms[] = array('os'=>'sun', 'os_human'=>'Solaris',  'is_legacy' => 1,          'arch'=>'sparc',    'dirname'=>'solaris_sparc-5.9', 'us1-dir'=>'Solaris/sparc');

    $platforms[] = array('os'=>'sun', 'os_human'=>'Solaris',            'arch'=>'x86',      'dirname'=>'solaris_i386-5.10','us1-dir'=>'Solaris/x86');

    return $platforms;
}

function get_loader_platforms()
{
    return get_remote_session_value('loader_platform_info',LOADER_PLATFORM_URL,'default_platform_list');
}

function get_platforminfo()
{
    static $platforminfo;

    if (empty($platforminfo)) {
        $platforminfo = get_loader_platforms();
    }
    return $platforminfo;
}

function get_platform()
{
    static $this_platform;

    if (!isset($this_platform)) {
        $this_platform = calc_platform();
    }

    return $this_platform;
}

function is_legacy_platform()
{
    $platform = get_platform();
    
    if (array_key_exists('is_legacy',$platform)) {
		return "1";
    }
    else {
		return "0";
    }
}

function calc_platform()
{
    $platform = array();
    $platform_info = get_platforminfo();
    $loader = get_loaderinfo();
    $multiple_os_versions = false;
    if (is_array($loader) && array_key_exists('osvariants',$loader) && is_array($loader['osvariants'])) {
        $versions = array_values($loader['osvariants']);
        $multiple_os_versions = !empty($versions[0]);
    }
    if ($multiple_os_versions) {
        list($osvar,$exact_match) = get_reqd_version($loader['osvariants']);
    } else {
        $osvar = null;
        if (is_ms_windows()) {
            $sys = get_sysinfo();
            $phpc = (empty($sys['PHP_COMPILER']))?'vc6':strtolower($sys['PHP_COMPILER']); 
            $osvar = ($sys['THREAD_SAFE']?'':'nonts_') . $phpc;
        }
    }
    foreach ($platform_info as $p) {
        if ($p['os'] == $loader['oscode'] && $p['arch'] == $loader['arch'] && (empty($osvar) || $p['os_mod'] == "_" . $osvar)) {
            $platform = $p;
            break;
        }
    }
    return $platform;
}

function supported_os_variants($os_code,$arch_code)
{
    if (empty($os_code)) {
        return ERROR_UNKNOWN_OS;
    }
    if (empty($arch_code)) {
        return ERROR_UNKNOWN_ARCH;
    }

    $os_found = false;
    $arch_found = false;
    $os_arch_matches = array();
    $pinfo = get_platforminfo();

    foreach ($pinfo as $p) {
        if ($p['os'] == $os_code && $p['arch'] == $arch_code) {
            $os_arch_matches[$p['os_human']] = (isset($p['os_mod']))?(0 + str_replace('_','',$p['os_mod'])):'';
        } 
        if ($p['os'] == $os_code) {
            $os_found = true;
        } elseif ($p['arch'] == $arch_code) {
            $arch_found = true;
        }
    }
    if (!empty($os_arch_matches)) {
        asort($os_arch_matches);
        return $os_arch_matches;
    } elseif (!$os_found) {
        return ERROR_UNSUPPORTED_OS;
    } elseif (!$arch_found) {
        return ERROR_UNSUPPORTED_ARCH;
    } else {
        return ERROR_UNSUPPORTED_ARCH_OS;
    }
}

function default_win_compilers()
{
    return array('VC6','VC9','VC11');
}

function supported_win_compilers()
{
    static $win_compilers;

    if (empty($win_compilers)) {
        $win_compilers = find_win_compilers();
    }
    return $win_compilers;
}

function find_win_compilers()
{
    return get_remote_session_value('php_compilers_info',PHP_COMPILERS_URL,'default_win_compilers');
}

function server_software_info_li()
{
	$result = "";
    $ss = $_SERVER['SERVER_SOFTWARE'];

    if (preg_match('/apache/i', $ss)) {
        $result = 'Apache';
    } else if (preg_match('/IIS/',$ss)) {
        $result = 'IIS';
    } else if (preg_match('/nginx/i',$ss)) {
		$result = 'nginx';
    } 
    
    return $result;
}

function server_software_info()
{
    $ss = array('full' => '','short' => '');
    $ss['full'] = $_SERVER['SERVER_SOFTWARE'];

    if (preg_match('/apache/i', $ss['full'])) {
        $ss['short'] = 'Apache';
    } else if (preg_match('/IIS/',$ss['full'])) {
        $ss['short'] = 'IIS';
    } else {
        $ss['short'] = '';
    }
    return $ss;
}

function match_arch_pattern($str)
{
    $arch = null;
    $arch_patterns = array(
             'i.?86'        => 'x86',
             'x86[-_]64'    => 'x86',
             'x86'          => 'x86',
             'amd64'        => 'x86',
             'ppc64'        => 'ppc',
             'ppc'          => 'ppc',
             'powerpc'      => 'ppc',
             'sparc'        => 'sparc',
             'sun'          => 'sparc'
         );

    foreach ($arch_patterns as $token => $a) {
        if (preg_match("/$token/i", $str)) {
          $arch = $a;
          break;
        }
    }
    return $arch;
}

function required_loader_arch($mach_info,$os_code,$wordsize)
{
    if ($os_code == 'win') {
        $arch = ($wordsize == 32)?'x86':'x86-64';
    } elseif (!empty($os_code)) {
        $arch = match_arch_pattern($mach_info);
        if ($wordsize == 64) {
            if ($arch == 'x86') {
                $arch = 'x86-64';
            } elseif ($arch == 'ppc') {
                $arch = 'ppc64';
            }
        }
    } else {
        $arch = ERROR_UNKNOWN_ARCH;
    }
    return $arch;
}

function uname($part = 'a')
{
    $result = '';
    if (!function_is_disabled('php_uname')) {
        $result = @php_uname($part);
    } elseif (function_exists('posix_uname') && !function_is_disabled('posix_uname')) {
        $posix_equivs = array(
                     'm' => 'machine',
                     'n' => 'nodename',
                     'r' => 'release',
                     's' => 'sysname'
                 );
        $puname = @posix_uname();
        if ($part == 'a' || !array_key_exists($part,$posix_equivs)) {
           $result = join(' ',$puname);
        } else {
           $result = $puname[$posix_equivs[$part]];
        }
    } else {
        if (!function_is_disabled('phpinfo')) {
            ob_start();
            phpinfo(INFO_GENERAL);
            $pinfo = ob_get_contents();
            ob_end_clean();
            if (preg_match('~System.*?(</B></td><TD ALIGN="left">| => |v">)([^<]*)~i',$pinfo,$match)) {
                $uname = $match[2];
                if ($part == 'r') {
                    if (!empty($uname) && preg_match('/\S+\s+\S+\s+([0-9.]+)/',$uname,$matchver)) {
                        $result = $matchver[1];
                    } else {
                        $result = '';
                    }
                } else {
                    $result = $uname;
                }
            }
        } else {
            $result = '';
        }
    }
    return $result;
}

function get_os_code()
{
    $os_name = substr(uname(),0,strpos(uname(),' '));
    $os_code = empty($os_name)?'':strtolower(substr($os_name,0,3));

    return $os_code;
}

function get_word_size()
{
	$os_code = get_os_code();
	
	return calc_word_size($os_code);
}

function calc_word_size($os_code)
{
    $wordsize = null;
    if ('win' === $os_code) {
        ob_start();
        phpinfo(INFO_GENERAL | INFO_ENVIRONMENT);
        $pinfo = ob_get_contents();
        ob_end_clean();
        if (preg_match('~Compiler.*?(</B></td><TD ALIGN="left">| => |v">)([^<]*)~i',$pinfo,$compmatch)) {
            if (preg_match("/(VC[0-9]+)/i",$compmatch[2],$vcmatch)) {
                $compiler = strtoupper($vcmatch[1]);
            } else {
                $compiler = 'VC6';
            }
        } else {
            $compiler = 'VC6';
        }
        if ($compiler === 'VC9' || $compiler === 'VC11') {
            if (preg_match('~Architecture.*?(</B></td><TD ALIGN="left">| => |v">)([^<]*)~i',$pinfo,$archmatch)) {
                if (preg_match("/x64/i",$archmatch[2])) {
                    $wordsize = 64;
                } else {
                    $wordsize = 32;
                }
            } else if (preg_match('~PROCESSOR_ARCHITECTURE.*?(</B></td><TD ALIGN="left">| => |v">)([^<]*)~i',$pinfo,$archmatch)) {
                if (preg_match('~(amd64|x86-64|x86_64)~i',$archmatch[2])) {
                    if (preg_match('~Configure Command.*?(</B></td><TD ALIGN="left">| => |v">)([^<]*)~i',$pinfo,$confmatch)) {
                        if (preg_match('~(x64|lib64|system64)~i',$confmatch[2])) {
                                $wordsize = 64;
                        }
                    }
                } 
            } else {
                $wordsize = 32;
            }
        }
    }
    if (empty($wordsize)) {
        $wordsize = ((-1^0xffffffff)?64:32);
    }
    return $wordsize;
}

function required_loader($unamestr = '')
{
    $un = empty($unamestr)?uname():$unamestr;

    $php_major_version = substr(PHP_VERSION,0,3);

    $os_name = substr($un,0,strpos($un,' '));
    $os_code = empty($os_name)?'':strtolower(substr($os_name,0,3));

    $wordsize = calc_word_size($os_code);

	if ($os_code == 'win' && $wordsize == 64 && $php_major_version < '5.5') {
        $arch = ERROR_WINDOWS_64_BIT;
	} else {
    $arch = required_loader_arch($un,$os_code,$wordsize);
	}
    if (!is_string($arch)) {
        return $arch;
    }
    $os_variants = supported_os_variants($os_code,$arch);
    if (!is_array($os_variants)) {
        return $os_variants;
    }

    $os_ver = '';
    if (preg_match('/([0-9.]+)/',uname('r'),$match)) {
        $os_ver = $match[1];
    }
    $os_ver_parts = preg_split('@\.@',$os_ver);

    $loader_sfix = (($os_code == 'win') ? 'dll' : 'so');
    $file = "ioncube_loader_${os_code}_${php_major_version}.${loader_sfix}";

    if ($os_code == 'win') {
        $os_name = 'Windows';
        $file_ts = $file;
        $os_name_qual = 'Windows';
    } else {
        $os_names = array_keys($os_variants);
        if (count($os_variants) > 1) {
            $parts = explode(" ",$os_names[0]); 
            $os_name = $parts[0];
            $os_name_qual = $os_name . ' ' . $os_ver_parts[0] . '.' . $os_ver_parts[1];
        } else {
            $os_name = $os_names[0];
            $os_name_qual = $os_name;
        }
        $file_ts = "ioncube_loader_${os_code}_${php_major_version}_ts.${loader_sfix}";
    }

    return array(
           'uname'      =>  $un,
           'arch'       =>  $arch,
           'oscode'     =>  $os_code,
           'osname'     =>  $os_name,
           'osnamequal' =>  $os_name_qual,
           'osvariants' =>  $os_variants,
           'osver'      =>  $os_ver,
           'osver2'     =>  $os_ver_parts,
           'file'       =>  $file,
           'file_ts'    =>  $file_ts,
           'wordsize'   =>  $wordsize
       );
}

function ic_system_info_li()
{
	$thread_safe = '';
    $debug_build = '';
    $cgi_cli = 0;
    $is_cgi = 0;
    $is_cli = 0;
    $php_ini_path = '';
    $php_ini_dir = '';
    $php_ini_dir_path = '';
    $php_ini_add = '';
    $is_supported_compiler = 1;
    $php_compiler = is_ms_windows()?'VC6':'';

    ob_start();
    phpinfo(INFO_GENERAL);
    $php_info = ob_get_contents();
    ob_end_clean();

    $breaker = (php_sapi_name() == 'cli')?'\n':'</tr>';
    $lines = explode($breaker,$php_info);
    foreach ($lines as $line) {
        if (preg_match('/command/i',$line)) {
          continue;
        }

        if (preg_match('/thread safety/i', $line)) {
			if (preg_match('/(enabled|yes)/i', $line) != 0) {
				$thread_safe = 1;
			}
			else {
				$thread_safe = 0;
			}
        }

        if (preg_match('/debug build/i', $line)) {
            if (preg_match('/(enabled|yes)/i', $line) != 0) {
				$debug_build = 1;
			}
			else {
				$debug_build = 0;
			}
        }

        if (preg_match('~configuration file \(php\.ini\) path.*(</B></td><TD ALIGN="left">| => |v">)([^ <]*)~i',$line,$match)) {
          $php_ini_dir_path = $match[2];
        }
        if (preg_match('~configuration file.*(</B></td><TD ALIGN="left">| => |v">)([^ <]*)~i',$line,$match)) {
          $php_ini_path = $match[2];

          if (!@file_exists($php_ini_path)) {
                $php_ini_path = '';
          }
        }
        if (preg_match('~dir for additional \.ini files.*(</B></td><TD ALIGN="left">| => |v">)([^ <]*)~i',$line,$match)) {
            $php_ini_dir = $match[2];
            if (!@file_exists($php_ini_dir)) {
                $php_ini_dir = '';
            }
        }
        if (preg_match('~additional \.ini files parsed.*(</B></td><TD ALIGN="left">| => |v">)([^ <]*)~i',$line,$match)) {
            $php_ini_add = $match[2];
        }
        if (preg_match('/compiler/i',$line)) {
            $supported_match = join('|',supported_win_compilers());
            $is_supported_compiler = preg_match("/($supported_match)/i",$line);
            if (preg_match("/(VC[0-9]+)/i",$line,$match)) {
                $php_compiler = strtoupper($match[1]);
            } else {
                $php_compiler = '';
            }
        }
    }
    
    if (strpos(php_sapi_name(),'cgi') !== false) {
		$is_cgi = 1;
    }
    
    if (strpos(php_sapi_name(),'cli') !== false) {
		$is_cli = 1;
    }
    
    if ($is_cgi || $is_cli) {
		$cgi_cli = 1;
    }

    $ss = server_software_info();

    if (!$php_ini_path && function_exists('php_ini_loaded_file')) {
        $php_ini_path = php_ini_loaded_file();
        if ($php_ini_path === false) {
            $php_ini_path = '';
        }
    }
    if (!empty($php_ini_path)) {
        $real_path = @realpath($php_ini_path);
        if (false !== $real_path) {
            $php_ini_path = $real_path;
        }
    }

    $php_ini_basename = basename($php_ini_path);

    return array(
           'THREAD_SAFE'        => $thread_safe,
           'DEBUG_BUILD'        => $debug_build,
           'PHP_INI'            => $php_ini_path,
           'PHP_INI_BASENAME'   => $php_ini_basename,
           'PHP_INI_DIR'        => $php_ini_dir,
           'PHP_INI_DIR_PATH'   => $php_ini_dir_path,
           'PHP_INI_ADDITIONAL' => $php_ini_add,
           'PHPRC'              => getenv('PHPRC'),
           'CGI_CLI'            => $cgi_cli,
           'IS_CGI'             => $is_cgi,
           'IS_CLI'             => $is_cli,
           'PHP_COMPILER'       => $php_compiler,
           'SUPPORTED_COMPILER' => $is_supported_compiler,
           'FULL_SS'            => $ss['full'],
           'SS'                 => $ss['short']);
}

function ic_system_info()
{
    $thread_safe = null;
    $debug_build = null;
    $cgi_cli = false;
    $is_cgi = false;
    $is_cli = false;
    $php_ini_path = '';
    $php_ini_dir = '';
    $php_ini_add = '';
    $is_supported_compiler = true;
    $php_compiler = is_ms_windows()?'VC6':'';

    ob_start();
    phpinfo(INFO_GENERAL);
    $php_info = ob_get_contents();
    ob_end_clean();

    $breaker = (php_sapi_name() == 'cli')?'\n':'</tr>';
    $lines = explode($breaker,$php_info);
    foreach ($lines as $line) {
        if (preg_match('/command/i',$line)) {
          continue;
        }

        if (preg_match('/thread safety/i', $line)) {
          $thread_safe = (preg_match('/(enabled|yes)/i', $line) != 0);
        }

        if (preg_match('/debug build/i', $line)) {
          $debug_build = (preg_match('/(enabled|yes)/i', $line) != 0);
        }

        if (preg_match('~configuration file.*(</B></td><TD ALIGN="left">| => |v">)([^ <]*)~i',$line,$match)) {
          $php_ini_path = $match[2];

          if (!@file_exists($php_ini_path)) {
                $php_ini_path = '';
          }
        }
        if (preg_match('~dir for additional \.ini files.*(</B></td><TD ALIGN="left">| => |v">)([^ <]*)~i',$line,$match)) {
            $php_ini_dir = $match[2];
            if (!@file_exists($php_ini_dir)) {
                $php_ini_dir = '';
            }
        }
        if (preg_match('~additional \.ini files parsed.*(</B></td><TD ALIGN="left">| => |v">)([^ <]*)~i',$line,$match)) {
            $php_ini_add = $match[2];
        }
        if (preg_match('/compiler/i',$line)) {
            $supported_match = join('|',supported_win_compilers());
            $is_supported_compiler = preg_match("/($supported_match)/i",$line);
            if (preg_match("/(VC[0-9]+)/i",$line,$match)) {
                $php_compiler = strtoupper($match[1]);
            } else {
                $php_compiler = '';
            }
        }
    }
    $is_cgi = strpos(php_sapi_name(),'cgi') !== false;
    $is_cli = strpos(php_sapi_name(),'cli') !== false;
    $cgi_cli = $is_cgi || $is_cli;

    $ss = server_software_info();

    if (!$php_ini_path && function_exists('php_ini_loaded_file')) {
        $php_ini_path = php_ini_loaded_file();
        if ($php_ini_path === false) {
            $php_ini_path = '';
        }
    }
    if (!empty($php_ini_path)) {
        $real_path = @realpath($php_ini_path);
        if (false !== $real_path) {
            $php_ini_path = $real_path;
        }
    }

    $php_ini_basename = basename($php_ini_path);

    return array(
           'THREAD_SAFE'        => $thread_safe,
           'DEBUG_BUILD'        => $debug_build,
           'PHP_INI'            => $php_ini_path,
           'PHP_INI_BASENAME'   => $php_ini_basename,
           'PHP_INI_DIR'        => $php_ini_dir,
           'PHP_INI_ADDITIONAL' => $php_ini_add,
           'PHPRC'              => getenv('PHPRC'),
           'CGI_CLI'            => $cgi_cli,
           'IS_CGI'             => $is_cgi,
           'IS_CLI'             => $is_cli,
           'PHP_COMPILER'       => $php_compiler,
           'SUPPORTED_COMPILER' => $is_supported_compiler,
           'FULL_SS'            => $ss['full'],
           'SS'                 => $ss['short']);
}

function is_possibly_dedicated_or_local()
{
    $sys = get_sysinfo();

    return (empty($sys['PHP_INI']) || !@file_exists($sys['PHP_INI']) || (is_readable($sys['PHP_INI']) && (0 !== strpos($sys['PHP_INI'],$_SERVER['DOCUMENT_ROOT']))));
}

function is_local()
{
    $ret = false;
    if ($_SERVER["SERVER_NAME"] == 'localhost') {
        $ret = true;
    } else {
        $ip_address = strtolower($_SERVER["REMOTE_ADDR"]);
        if (strpos(':',$ip_address) === false) {
            $ip_parts = explode('.',$ip_address);
            $ret = (($ip_parts[0] == 10) || 
                    ($ip_parts[0] == 172 && $ip_parts[1] >= 16 &&  $ip_parts[1] <= 31) ||
                    ($ip_parts[0] == 192 && $ip_parts[1] == 168));
        } else {
            $ret = ($ip_address == '::1') || (($ip_address[0] == 'f') && ($ip_address[1] >= 'c' && $ip_address[1] <= 'f'));
        }
    }
    return $ret;
}

function is_shared()
{
    return !is_local() && !is_possibly_dedicated_or_local();
}

function find_server_type($chosen_type = '',$type_must_be_chosen = false,$set_session = false)
{
    $server_type = SERVER_UNKNOWN;
    if (empty($chosen_type)) {
        if ($type_must_be_chosen) {
            $server_type = SERVER_UNKNOWN;
        } else {
            if (isset($_SESSION['server_type']) && $_SESSION['server_type'] != SERVER_UNKNOWN) {
                $server_type = $_SESSION['server_type'];
            } elseif (is_local()) {
                $server_type = SERVER_LOCAL;
            } elseif (!is_possibly_dedicated_or_local()) {
                $server_type = SERVER_SHARED;
            } else {
                $server_type = SERVER_UNKNOWN;
            } 
        }
    } else {
        switch ($chosen_type)  {
            case 's':
                $server_type = SERVER_SHARED;
                break;
            case 'd':
                $server_type = SERVER_DEDICATED;
                break;
            case 'l':
                $server_type = SERVER_LOCAL;
                break;
            default:
                $server_type = SERVER_UNKNOWN;
                break;
        }
    }
    if ($set_session) {
        $_SESSION['server_type'] = $server_type;
    }
    return $server_type;
}

function server_type_string()
{
    $server_code = find_server_type();
    switch ($server_code) {
        case SERVER_SHARED:
            $server_string = 'SHARED';
            break;
        case SERVER_LOCAL:
            $server_string = 'LOCAL';
            break;
        case SERVER_DEDICATED:
            $server_string = 'DEDICATED';
            break;
        default:
            $server_string = 'UNKNOWN';
            break;
    }
    return $server_string;
}

function server_type_code()
{
    $server_code = find_server_type();
    switch ($server_code) {
        case SERVER_SHARED:
            $server_char = 's';
            break;
        case SERVER_LOCAL:
            $server_char = 'l';
            break;
        case SERVER_DEDICATED:
            $server_char = 'd';
            break;
        default:
            $server_char = '';
            break;
    }
    return $server_char;
}

function get_sysinfo()
{
    static $sysinfo;

    if (empty($sysinfo)) {
        $sysinfo = ic_system_info();
    }
    return $sysinfo;
}

function get_loaderinfo()
{
    static $loader;

    if (empty($loader)) {
        $loader = required_loader();
    }
    return $loader;
}

function is_ms_windows()
{
    $loader_info = get_loaderinfo();
    //return ($loader_info['oscode'] == 'win');
    
    if ($loader_info['oscode'] == 'win') {
		return "1";
    }
    else {
		return "0";
    }
}

function function_is_disabled($fn_name)
{
    $disabled_functions=explode(',',ini_get('disable_functions'));
    return in_array($fn_name, $disabled_functions);
}

function selinux_is_enabled_li()
{
    $se_enabled = false;

    if (!is_ms_windows()) {
        $cmd = @shell_exec('sestatus');
        $se_enabled = preg_match('/enabled/i',$cmd);
    }

    if ($se_enabled) {
		return "1";
    }
    else {
		return "0";
    }
}

function selinux_is_enabled()
{
    $se_enabled = false;

    if (!is_ms_windows()) {
        $cmd = @shell_exec('sestatus');
        $se_enabled = preg_match('/enabled/i',$cmd);
    }

    return $se_enabled;
}

function grsecurity_is_enabled()
{
    $gr_enabled = false;

    if (!is_ms_windows()) {
        $cmd = @shell_exec('gradm -S');
        $gr_enabled = preg_match('/enabled/i',$cmd);
    }

    return $gr_enabled;
}

function threaded_and_not_cgi()
{
    $sys = get_sysinfo();
    return($sys['THREAD_SAFE'] && !$sys['IS_CGI']);
}

function is_restricted_server($only_safe_mode = false)
{
    $disable_functions = ini_get('disable_functions');
    $open_basedir = ini_get('open_basedir');
    $php_restrictions = !empty($disable_functions) || !empty($open_basedir);
    $system_restrictions = selinux_is_enabled() || grsecurity_is_enabled();
    $non_safe_mode_restrictions = $php_restrictions || $system_restrictions;
    return (ini_get('safe_mode') || (!$only_safe_mode && $non_safe_mode_restrictions));
}

function server_restriction_warnings()
{
    $warnings = array();

    if (find_server_type() == SERVER_SHARED) {
        if (is_restricted_server()) {
            $warnings[] = "Server restrictions are in place which might affect the operation of this Loader Wizard or prevent the installation of the Loader.";
        }
    } else {
        $warning_suffix = "This may affect the operation of this Loader Wizard.";
        if (ini_get('safe_mode')) {
            $warnings[] = "Safe mode is in effect on the server. " . $warning_suffix;
        } 
        $disabled_functions = ini_get('disable_functions');
        if (!empty($disabled_functions)) {
            $warnings[] = "Some functions are disabled through disable_functions. " . $warning_suffix;
        }
        $open_basedir = ini_get('open_basedir');
        if (!empty($open_basedir)) {
            $warnings[] = "Open basedir restrictions are in effect. " . $warning_suffix;
        }
    }
    return $warnings;
}

function own_php_ini_possible($only_safe_mode = false)
{
    $sysinfo = get_sysinfo();
    return ($sysinfo['CGI_CLI'] && !is_ms_windows() && !is_restricted_server($only_safe_mode));
}

function extension_dir()
{
    $extdir = ini_get('extension_dir');
    if ($extdir == './' || ($extdir == '.\\' && is_ms_windows())) {
        $extdir = '.';
    }
    return $extdir;
}

function possibly_selinux()
{
    $loaderinfo = get_loaderinfo();
    $se_env = (getenv("SELINUX_INIT"));
    return (strtolower($loaderinfo['osname']) == 'linux' && $se_env && ($se_env == 'Yes' || $se_env == '1'));
}

function ini_same_dir_as_wizard()
{
    $sys = get_sysinfo();
    return dirname($sys['PHP_INI']) == dirname(__FILE__); 
}

function extension_dir_path()
{
    $ext_dir = extension_dir();
    if ($ext_dir == '.' || (dirname($ext_dir) == '.')) {
        $ext_dir_path = @realpath($ext_dir);
    } else {
        $ext_dir_path = $ext_dir;
    }
    return $ext_dir_path;
}

function get_loader_name()
{
    $u = uname();
    $sys = get_sysinfo();
    $os = substr($u,0,strpos($u,' '));
    $os_key = strtolower(substr($u,0,3));

    $php_version = phpversion();
    $php_family = substr($php_version,0,3);

    $loader_sfix = (($os_key == 'win') ? '.dll' : (($sys['THREAD_SAFE'])?'_ts.so':'.so'));
    $loader_name="ioncube_loader_${os_key}_${php_family}${loader_sfix}";

    return $loader_name;
}

function get_reqd_version($variants)
{
    $exact_match = false;
    $nearest_version = 0;
    $loader_info = get_loaderinfo();
    $os_version = $loader_info['osver2'][0] . '.' . $loader_info['osver2'][1];
    $os_version_major = $loader_info['osver2'][0];
    foreach ($variants as $v) {
        if ($v == $os_version || (is_int($v) && $v == $os_version_major)) {
            $exact_match = true;
            $nearest_version = $v;
            break;
        } elseif ($v > $os_version) {
            break;
        } else {
            $nearest_version = $v;
        }
    }
    return (array($nearest_version,$exact_match));
}

function get_default_loader_dir_webspace()
{
    return ($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . LOADER_SUBDIR);
}

function get_loader_location($loader_dir = '')
{
    if (empty($loader_dir)) {
        $loader_dir = get_default_loader_dir_webspace();
    }
    $loader_name = get_loader_name(); 
    return ($loader_dir . DIRECTORY_SEPARATOR . $loader_name);
}

function get_loader_location_from_ini($php_ini = '')
{
    $errors = array();
    if (empty($php_ini)) {
        $sysinfo = get_sysinfo();
        $php_ini = $sysinfo['PHP_INI'];
    }
    if (!@file_exists($php_ini)) {
        if (empty($php_ini)) {
            $errors[ERROR_INI_NOT_FOUND] = "The configuration file could not be found.";
        } else {
            $errors[ERROR_INI_NOT_FOUND] = "The $php_ini file could not be found.";
        }
    } elseif (!is_readable($php_ini)) {
        $errors[ERROR_INI_NOT_READABLE] = "The $php_ini file could not be read.";
    }
    if (!empty($errors)) {
        return array('location' => '', 'errors' => $errors);
    } 
    $lines = file($php_ini);
    $ext_start = zend_extension_line_start();
    $wrong_ext_start = ($ext_start == 'zend_extension')?'zend_extension_ts':'zend_extension';
    $loader_path = '';
    $loader_name_match = "ioncube_loader";
    foreach ($lines as $l) {
        if (preg_match("/^\s*$ext_start\s*=\s*\"?([^\"]+)\"?/i",$l,$corr_matches)) {
            if (preg_match("/$loader_name_match/i",$corr_matches[1])) {
                if (!empty($loader_path)) {
                    $errors[ERROR_INI_MULTIPLE_IC_LOADER_LINES] = "It appears that multiple $ext_start lines for the ionCube Loader have been included in the configuration file, $php_ini.";
                }
                $loader_path = $corr_matches[1];
            } else {
                if (empty($loader_path)) {
                    $errors[ERROR_INI_NOT_FIRST_ZE] = "The ionCube Loader must be the first Zend extension listed in the configuration file, $php_ini.";
                }
            }
        }
        if (empty($loader_path)) {
            if (preg_match("/^\s*$wrong_ext_start\s*=\s*\"?([^\"]+)\"?/i",$l,$bad_start_matches)) {
                if (preg_match("/$loader_name_match/i",$bad_start_matches[1])) {
                    $bad_zend_ext_msg = "The line for the ionCube Loader in the configuration file, $php_ini, should start with $ext_start and <b>not</b> $wrong_ext_start.";
                    $errors[ERROR_INI_WRONG_ZE_START] = $bad_zend_ext_msg;
                    $loader_path = $bad_start_matches[1];
                }
            }
        }
    }
    $loader_path = trim($loader_path);
    if ($loader_path === '') {
        $errors[ERROR_INI_ZE_LINE_NOT_FOUND] = "The necessary zend_extension line could not be found in the configuration file, $php_ini.";
    } elseif (!@file_exists($loader_path)) {
        $errors[ERROR_INI_LOADER_FILE_NOT_FOUND] = "The loader file  $loader_path, listed in the configuration file, $php_ini, does not exist or is not accessible.";
    } elseif (basename($loader_path) == $loader_path) {
        $errors[ERROR_INI_NOT_FULL_PATH] = "A full path must be specified for the loader file in the configuration file, $php_ini.";
    }
    return array('location' => $loader_path, 'errors' => $errors);
}

function zend_extension_line_missing($ini_path)
{
    $loader_loc = get_loader_location_from_ini($ini_path);
    return (!empty($loader_loc['errors']) && array_key_exists(ERROR_INI_ZE_LINE_NOT_FOUND,$loader_loc['errors']));
}

function find_additional_ioncube_ini()
{
    $sys = get_sysinfo();
    $ioncube_ini = '';

    if (!empty($sys['PHP_INI_ADDITIONAL']) && !preg_match('/(none)/i',$sys['PHP_INI_ADDITIONAL'])) {
        $ini_files = explode(',',$sys['PHP_INI_ADDITIONAL']);
        foreach ($ini_files as $f) {
            $fn = trim($f);
            $bfn = basename($fn);
            if (preg_match('/ioncube/i',$bfn)) {
                $ioncube_ini = $fn;
                break;
            }
        }
    }
    return $ioncube_ini;
}

function get_additional_ini_files()
{
    $result = "";
    $sys = get_sysinfo();
    if (!empty($sys['PHP_INI_ADDITIONAL']) && !preg_match('/(none)/i',$sys['PHP_INI_ADDITIONAL'])) {
        $result_tmp = $sys['PHP_INI_ADDITIONAL'];
        $arr = explode(',', $result_tmp);
        
        foreach ($arr as $key => $path) {
			$realpath = realpath($path);
			if ($realpath) {
				$arr[$key] = $realpath;
			}
        }
        
        $result = implode(",", $arr);
    }
    return $result;
}

function all_ini_contents()
{
    $sys = get_sysinfo();
    $output = '';

    $output .= ";;; *MAIN INI FILE AT ${sys['PHP_INI']}* ;;;" . PHP_EOL;
    $output .= get_file_contents($sys['PHP_INI']);
    $other_inis = get_additional_ini_files();
    foreach ($other_inis as $inif) {
        $output .= ";;; *Additional ini file at $inif* ;;;" . PHP_EOL;
        $output .= get_file_contents($inif);
    }
    $here = unix_path_dir();
    $unrec_ini_files = unrecognised_inis_webspace($here);
    foreach ($unrec_ini_files as $urinif) {
        $output .= ";;; *UNRECOGNISED INI FILE at $urinif* ;;;" . PHP_EOL;
        $output .= get_file_contents($urinif);
    }
    return $output;
}

function scan_inis_for_loader()
{
    $ldloc = '';
    $sysinfo = get_sysinfo();
    if (empty($sysinfo['PHP_INI'])) {
        $ini_files_not_found = array("Main ini file");
        $ini_file_list = get_additional_ini_files();
    } else {
        $ini_files_not_found = array();
        $ini_file_list = array_merge(array($sysinfo['PHP_INI']),get_additional_ini_files());
    }
    $server_type = find_server_type();
    $shared_server = SERVER_SHARED == $server_type;
    foreach ($ini_file_list as $f) {
        $ldloc = get_loader_location_from_ini($f);
        if (array_key_exists(ERROR_INI_ZE_LINE_NOT_FOUND,$ldloc['errors'])) {
            unset($ldloc['errors'][ERROR_INI_ZE_LINE_NOT_FOUND]);
        } 
        if ($shared_server && array_key_exists(ERROR_INI_NOT_FOUND,$ldloc['errors'])) {
            if (false == user_ini_space_path($f)) {
                $ldloc['errors'][ERROR_INI_NOT_FOUND] = "A system ini file cannot be found or read by the Wizard - you cannot do anything about this on your shared server.";
            } else {
                $ldloc['errors'][ERROR_INI_USER_INI_NOT_FOUND] = $ldloc['errors'][ERROR_INI_NOT_FOUND];
            }
        } elseif (array_key_exists(ERROR_INI_NOT_FOUND,$ldloc['errors'])) {
            $ini_files_not_found[] = $f;
        }
        if (!empty($ldloc['location'])) {
            break;
        }
    }
    if (!empty($ini_files_not_found)) {
        $plural = (count($ini_files_not_found) > 1)?"s":"";
        $ldloc['errors'][ERROR_INI_NOT_FOUND] = "The following ini file$plural could not be found by the Wizard: " . join(',',$ini_files_not_found);
        if (is_restricted_server()) {
            $ldloc['errors'][ERROR_INI_NOT_FOUND] .= "<br> This may be due to server restrictions in place.";
        }
    }
    if (empty($ldloc['location'])) {
        $ldloc['errors'][ERROR_INI_ZE_LINE_NOT_FOUND] = "The necessary zend_extension line could not be found in the configuration.";
    }
    return $ldloc;
}

function find_loader_filesystem()
{
    $ld_inst_dir = loader_install_dir(find_server_type());
    $loader_name = get_loader_name();
    $suggested_loader_path = $ld_inst_dir . DIRECTORY_SEPARATOR . $loader_name;
    if (@file_exists($suggested_loader_path)) {
        $location = $suggested_loader_path;
    } elseif (@file_exists($loader_name)) {
        $location = @realpath($loader_name);
    } else {
        $ld_loc = get_loader_location();
        if (@file_exists($ld_loc)) {
            $location = $ld_loc;
        } else {
            $location = '';
        }
    }
    return $location;
}

function find_loader($search_directories_if_not_ini = false)
{
    $sysinfo = get_sysinfo();
    $php_ini = $sysinfo['PHP_INI'];
    $rtl_path = get_runtime_loading_path_if_applicable();
    $location = '';
    $errors = array();

    if (!empty($rtl_path)) {
        $location = $rtl_path;
    } else {
        $loader_ini = scan_inis_for_loader();
        $location = $loader_ini['location'];
        $errors = $loader_ini['errors'];
    }
    if (empty($location) && (empty($errors) || $search_directories_if_not_ini)) {
        $errors = array(); 
        $location = find_loader_filesystem();
        if (empty($location)) {
            $errors[ERROR_LOADER_NOT_FOUND] = 'The loader file could not be found in standard locations.';
        }
    }
    if (!empty($errors)) {
        return $errors;
    } else {
        return $location;
    }
}

function zend_extension_line_start()
{
    $sysinfo = get_sysinfo();
    $is_53_or_later = is_php_version_or_greater(5,3);
    return (is_bool($sysinfo['THREAD_SAFE']) && $sysinfo['THREAD_SAFE'] && !$is_53_or_later ? 'zend_extension_ts' : 'zend_extension');
}

function get_loader_version()
{
	$liv = "";
	$lv = "";
	if (function_exists('ioncube_loader_iversion')) {
		$liv = ioncube_loader_iversion();
		$lv = sprintf("%d.%d.%d", $liv / 10000, ($liv / 100) % 100, $liv % 100);
	}
	
	return $lv;
}

function get_loader_version_information()
{
    $old_version = 0;
    $liv = "";
    $lv = "";
    $mv = 0;
    if (function_exists('ioncube_loader_iversion')) {
        $liv = ioncube_loader_iversion();
        $lv = sprintf("%d.%d.%d", $liv / 10000, ($liv / 100) % 100, $liv % 100);

        $latest_version =  get_latestversion();

        $lat_parts = explode('.',$latest_version);
        $cur_parts = explode('.',$lv);

        if (($cur_parts[0] > $lat_parts[0]) || 
            ($cur_parts[0] == $lat_parts[0] && $cur_parts[1] > $lat_parts[1]) ||
             ($cur_parts[0] == $lat_parts[0] && $cur_parts[1] == $lat_parts[1] && $cur_parts[2] >= $lat_parts[2])) {
            $old_version = 0;
        } else {
            $old_version = $latest_version;
        }
        $mv = $cur_parts[0];
    }
    return $lv . "," . $mv . "," . $old_version;
}

function ioncube_loader_version_information()
{
    $old_version = true;
    $liv = "";
    $lv = "";
    $mv = 0;
    if (function_exists('ioncube_loader_iversion')) {
        $liv = ioncube_loader_iversion();
        $lv = sprintf("%d.%d.%d", $liv / 10000, ($liv / 100) % 100, $liv % 100);

        $latest_version =  get_latestversion();

        $lat_parts = explode('.',$latest_version);
        $cur_parts = explode('.',$lv);

        if (($cur_parts[0] > $lat_parts[0]) || 
            ($cur_parts[0] == $lat_parts[0] && $cur_parts[1] > $lat_parts[1]) ||
             ($cur_parts[0] == $lat_parts[0] && $cur_parts[1] == $lat_parts[1] && $cur_parts[2] >= $lat_parts[2])) {
            $old_version = false;
        } else {
            $old_version = $latest_version;
        }
        $mv = $cur_parts[0];
    }
    return array($lv,$mv,$old_version);
}

function default_loader_version_info()
{
    return array();
}

function get_loader_version_info()
{
    return get_remote_session_value('loader_version_info',LOADER_LATEST_VERSIONS_URL,'default_loader_version_info');
}

function calc_dirname()
{
    $dirname = '';
    $platform = get_platform();
    if (!empty($platform)) {
        $dirname = $platform['dirname'];
    }
    return $dirname;
}

function calc_loader_latest_version()
{
    $lv_info = get_loader_version_info();
    $latest_version = RECENT_LOADER_VERSION;
    if (!empty($lv_info)) {
        $dirname = calc_dirname();
      
        if (!empty($dirname)) {
            $compiler_specific_version = false;
            if (is_ms_windows()) {
                $sys = get_sysinfo();
                $phpc = strtolower($sys['PHP_COMPILER']);
                if (!empty($phpc)) {
                    $dirname_comp = $dirname . "_" . $phpc;
                    if (array_key_exists($dirname_comp,$lv_info)) {
                        $latest_version = $lv_info[$dirname_comp];
                        $compiler_specific_version = true;
                    }
                }
            }
            if (!$compiler_specific_version && array_key_exists($dirname,$lv_info)) {
                $latest_version = $lv_info[$dirname];
            }
        } 
    }
    return $latest_version;
}

function get_latestversion()
{
    static $latest_version;

    if (empty($latest_version)) {
        $latest_version = calc_loader_latest_version();
    }
    return $latest_version;
}

function runtime_loader_location()
{
    $loader_path = false;
    $ext_path = extension_dir_path();
    if ($ext_path !== false) {
        $id = $ext_path;
        $here = dirname(__FILE__);
        if (isset($id[1]) && $id[1] == ':') {
            $id = str_replace('\\','/',substr($id,2));
            $here = str_replace('\\','/',substr($here,2));
        }
        $rd=str_repeat('/..',substr_count($id,'/')).$here.'/';
        $i=strlen($rd);

        $loader_loc = DIRECTORY_SEPARATOR . basename($here) . DIRECTORY_SEPARATOR . get_loader_name();
        while($i--) {
            if($rd[$i]=='/') {
                $loader_path = runtime_location_exists($ext_path,$rd,$i,$loader_loc);
                if ($loader_path !== false) {
                    break;
                }
            }
        }

        if (!$loader_path && !empty($loader_loc) && @file_exists($loader_loc)) {
            $loader_path = basename($loader_loc);
        }
    }
    return $loader_path;
}

function runtime_location_exists($ext_dir,$path_str,$sep_pos,$loc_name)
{
    $sub_path = substr($path_str,0,$sep_pos);
    $lp = $sub_path . $loc_name;
    $fqlp = $ext_dir.$lp;

    if(@file_exists($fqlp)) {
        return $lp;
    } else {
        return false;
    }
}

function runtime_loading_is_possible() {
    return !((is_php_version_or_greater(5,2,5)) || is_restricted_server() || !ini_get('enable_dl') || !function_exists('dl') || function_is_disabled('dl') || threaded_and_not_cgi());
}

function shared_and_runtime_loading()
{
    return (find_server_type() == SERVER_SHARED && empty($_SESSION['use_ini_method']) && runtime_loading_is_possible());
}

function get_valid_runtime_loading_path($ignore_loading_check = false)
{
    if ($ignore_loading_check || runtime_loading_is_possible()) {
        return runtime_loader_location();
    } else {
        return false;
    }
}

function runtime_loading($rtl_path = null)
{
    if (empty($rtl_path)) {
        $rtl_path = get_valid_runtime_loading_path();
    }
    if (!empty($rtl_path) && @dl($rtl_path)) {
        return $rtl_path;
    } else {
        return false;
    }
}

function get_runtime_loading_path_if_applicable()
{
    $rtl = null;
    if (shared_and_runtime_loading()) {
        $rtl = get_valid_runtime_loading_path();
    }
    return $rtl;
}

function try_runtime_loading_if_applicable()
{
    $rtl_path = get_runtime_loading_path_if_applicable();
    if (!empty($rtl_path)) {
        return runtime_loading($rtl_path);
    } else {
        return $rtl_path;
    }
}

function runtime_loading_errors()
{
    $errors = array();
    $ext_path = extension_dir_path();
    if (false === $ext_path) {
        $errors[ERROR_RUNTIME_EXT_DIR_NOT_FOUND] = "Extensions directory cannot be found.";
    } else {
        $expected_file = dirname(__FILE__) . DIRECTORY_SEPARATOR . get_loader_name();
        if (!@file_exists($expected_file)) {
            $errors[ERROR_RUNTIME_LOADER_FILE_NOT_FOUND] = "The Loader file was expected to be at $expected_file but could not be found.";
        } else {
            $errors = loader_compatibility_test($expected_file);
        }
    }
    return $errors;
}

function windows_package_name()
{
    $sys = get_sysinfo();
	$loader = get_loaderinfo();
    return (LOADERS_PACKAGE_PREFIX . 'win' . '_' . ($sys['THREAD_SAFE']?'':'nonts_') . strtolower($sys['PHP_COMPILER']) .  '_' . $loader['arch']);
}

function unix_package_name()
{
    $sysinfo = get_sysinfo();
    $loader = get_loaderinfo();
    $multiple_os_versions = false;
    if (is_array($loader) && array_key_exists('osvariants',$loader) && is_array($loader['osvariants'])) {
        $versions = array_values($loader['osvariants']);
        $multiple_os_versions = !empty($versions[0]);
    }
    if ($multiple_os_versions) {
        list($reqd_version,$exact_match) = get_reqd_version($loader['osvariants']);
        if ($reqd_version) {
            $basename = LOADERS_PACKAGE_PREFIX . $loader['oscode'] . '_' . $reqd_version . '_' . $loader['arch'];
        } else {
            $basename = "";
        }
    } else {
        $basename = LOADERS_PACKAGE_PREFIX . $loader['oscode'] . '_' . $loader['arch'];
    }
    return array($basename,$multiple_os_versions);
}

function ini_dir()
{
    $sysinfo = get_sysinfo();
    $parent_dir = '';
    if (!empty($sysinfo['PHP_INI'])) {
        $parent_dir = dirname($sysinfo['PHP_INI']);
    } else {
        $parent_dir = $_SERVER["PHPRC"];
        if (@is_file($parent_dir)) {
            $parent_dir = dirname($parent_dir);
        }
    }
    return $parent_dir;
}

function unix_install_dir()
{
    $ext_dir = extension_dir_path();
    $cur_dir = @realpath('.');
    if (empty($ext_dir) || $ext_dir == $cur_dir) {
        $loader_dir = UNIX_SYSTEM_LOADER_DIR;
    } else {
        $loader_dir = $ext_dir;
    }
    return $loader_dir;
}

function windows_install_dir()
{
    $sysinfo = get_sysinfo();
    if ($sysinfo['SS'] == 'IIS') {
        if (false === ($ext_dir = extension_dir_path())) {
            $parent_dir = ini_dir();
            $ext_dir = $parent_dir . '\\ext';
            if (!empty($parent_dir) && @file_exists($ext_dir)) {
                $loader_dir = $ext_dir;
            } else {
                $loader_dir = $_SERVER['windir'] . '\\' . WINDOWS_IIS_LOADER_DIR;
            }
        } else {
            $loader_dir = $ext_dir;
        }
    } else {
        $parent_dir = ini_dir();
        $loader_dir = $parent_dir . '\\' . 'ioncube';
    }
    return $loader_dir;
}

function loader_install_dir($server_type)
{
    if (SERVER_SHARED == $server_type && own_php_ini_possible()) {
        $loader_dir = get_default_loader_dir_webspace();
    } elseif (is_ms_windows()) {
        $loader_dir = windows_install_dir();
    } else {
        $loader_dir = unix_install_dir();
    }
    return $loader_dir;
}

function get_loader_install_dir() {
	return loader_install_dir(find_server_type());
}

function user_ini_base()
{
    $doc_root_path = realpath($_SERVER['DOCUMENT_ROOT']);
    $above_root_path = @realpath($_SERVER['DOCUMENT_ROOT'] . "/..");
    if (!empty($above_root_path) && @is_writeable($above_root_path)) {
        $start_path = $above_root_path;
    } else {
        $start_path = $doc_root_path;
    }
    return $start_path;
}

function user_ini_space_path($file)
{
    $user_base = user_ini_base();
    $fpath = @realpath($file);
    if (!empty($fpath) && (0 === strpos($fpath,$user_base))) {
        return $fpath;
    } else {
        return false;
    }
}

function get_this_dir() {
	return realpath(dirname($_SERVER['SCRIPT_FILENAME']));
}

function default_ini_path()
{
    return (realpath($_SERVER['DOCUMENT_ROOT']));
}

function shared_ini_location()
{
    $phprc = getenv('PHPRC');
    if (!empty($phprc)) {
        $phprc_path = user_ini_space_path($phprc);
        if (false !== $phprc_path) {
            return $phprc_path;
        } else {
            return default_ini_path();
        }
    } else {
        return default_ini_path();
    }
}

function get_sysinfo_li() {
	static $sysinfo_li;

    if (empty($sysinfo_li)) {
        $sysinfo_li = ic_system_info_li();
    }
    return $sysinfo_li;
}

function get_sys_information()
{
	$result = "";
	
	$sysinfo = get_sysinfo_li();
	
	foreach ($sysinfo as $key => $value) {
		$result .= $key . "#" . $value . ";";
	}
	
	return $result;	
}

function get_all_ini_files()
{
    $result = "";
    
    $sysinfo = get_sysinfo();
    if (isset($sysinfo['PHP_INI']) && @file_exists($sysinfo['PHP_INI'])) {
        $result = realpath($sysinfo['PHP_INI']).",";
    }
    
    $result .= get_additional_ini_files();
    
    return $result;
}

function get_loaded_ini_file()
{
	$result = "";
    
    $sysinfo = get_sysinfo();
    if (isset($sysinfo['PHP_INI']) && @file_exists($sysinfo['PHP_INI'])) {
        $result = $sysinfo['PHP_INI'];
    }
    
    return $result;
}

function php_ini_install_shared($give_preamble = true)
{
    $php_ini_name = ini_file_name();
    $default = get_default_address();
    if ($give_preamble) {
        echo "<p>On your <strong>shared</strong> server, the Loader should be installed using a <code>$php_ini_name</code> configuration file.";
        echo " (<a href=\"{$default}&amp;manual=1\">Please click here if you are <strong>not</strong> on a shared server</a>.)</p>";
    }

    if (own_php_ini_possible()) {
        echo '<p>With your hosting account, you may be able to use your own PHP configuration file.</p>';
    } else {
        echo "<p>It appears that you cannot install the ionCube Loader using the <code>$php_ini_name</code> file. Your server provider or system administrator should be able to perform the installation for you. Please refer them to the following instructions.</p>";
    }

    php_ini_instruction_list(SERVER_SHARED);
}

function system_info_temporary_files()
{
    $tmpfname_ini = tempnam("/tmp", "INI");
    $tmpfname_ini .= ".ini";
    $fh_ini = @fopen($tmpfname_ini,'wb');
    if ($fh_ini) {
        $config = all_ini_contents();
        fwrite($fh_ini,$config);
        fclose($fh_ini);
    } else {
        $tmpfname_ini = '';
    }

    $tmpfname_pinf = tempnam("/tmp", "PIN");
    $tmpfname_pinf .= ".html";
    $fh_pinfo = @fopen($tmpfname_pinf,'wb');
    if ($fh_pinfo) {
        ob_start();
        @phpinfo();
        $pinfo = ob_get_contents();
        ob_end_clean();
        fwrite($fh_pinfo,$pinfo);
        fclose($fh_pinfo);
    } else {
        $tmpfname_pinf = '';
    }

    $tmpfname_add = tempnam("/tmp", "ADD");
    $tmpfname_add .= ".html";
    $fh_add = @fopen($tmpfname_add,'wb');
    if ($fh_add) {
        ob_start();
        extra_page();
        $extra = ob_get_contents();
        ob_end_clean();
        fwrite($fh_add,$extra);
        fclose($fh_add);
    } else {
        $tmpfname_add = '';
    }

    if (empty($tmpfname_ini) || empty($tmpfname_pinf) || empty($tmpfname_add)) {
        return (array());
    } else {
        return (array('ini'           =>   $tmpfname_ini,
                      'phpinfo'       =>   $tmpfname_pinf,
                      'additional'    =>   $tmpfname_add));
    }
}

function support_ticket_information()
{
    $sys = get_sysinfo();
    $ld = get_loaderinfo();

    $ticket_strs = array();
    $ticket_strs[] = "SYSTEM INFORMATION";
    $ticket_strs[] = '<hr/>';
    $info_lines = array();
    $info_lines["PHP uname"] = $ld['uname'];
    $info_lines["Machine architecture"] = $ld['arch'];
    $info_lines["Word size"] = $ld['wordsize'];
    $info_lines["Operating system"] = $ld['osname'] . ' ' . $ld['osver'];
    if (selinux_is_enabled() || possibly_selinux()) {
        $info_lines["Security enhancements"] = "SELinux";
    } elseif (grsecurity_is_enabled()) {
        $info_lines["Security enhancements"] = "Grsecurity";
    } else {
        $info_lines["Security enhancements"] = "None";
    }
    $info_lines["PHP version"] = PHP_VERSION; 
    if ($sys['DEBUG_BUILD']) {
        $info_lines["DEBUG BUILD"] = "DEBUG BUILD OF PHP";
    }
    if (!$sys['SUPPORTED_COMPILER']) {
        $info_lines["SUPPORTED PHP COMPILER"] = "FALSE";
        $info_lines["PHP COMPILER"] = $sys['PHP_COMPILER'];
    }
    $info_lines["Is CLI?"] = ($sys['IS_CLI']?"Yes":"No");
    $info_lines["Is CGI?"] = ($sys['IS_CGI']?"Yes":"No");
    $info_lines["Is thread-safe?"] = ($sys['THREAD_SAFE']?"Yes":"No");
    $info_lines["Web server"] = $sys['FULL_SS'];
    $info_lines["Server type"] = server_type_string();
    $info_lines["PHP ini file"] = $sys['PHP_INI'];
    if (!@file_exists($sys['PHP_INI'])) {
        $info_lines["Ini file found"] = "INI FILE NOT FOUND";
    } else {
        if (is_readable($sys['PHP_INI'])) {
            $info_lines["Ini file found"] = "INI FILE READABLE";
        } else {
            $fh = @fopen($sys['PHP_INI'],"rb");
            if ($fh === false) {
                $info_lines["Ini file found"] = "INI FILE FOUND BUT POSSIBLY NOT READABLE";
            } else {
                $info_lines["Ini file found"] = "INI FILE READABLE";
            }
        }
    }
    $info_lines["PHPRC"] = $sys['PHPRC'];
    $loader_path = find_loader();
    if (is_string($loader_path)) {
        $info_lines["Loader path"] =  $loader_path;
        $info_lines["Loader file size"] = filesize($loader_path) . " bytes.";
        $info_lines["Loader MD5 sum"] =  md5_file($loader_path);
    } else {
        $info_lines["Loader path"] =  "LOADER PATH NOT FOUND";
    }
    $server_type_code = server_type_code();
    if (!empty($_SESSION['hostprovider'])) {
      $info_lines['Hosting provider'] = $_SESSION['hostprovider'];
      $info_lines['Provider URL'] = $_SESSION['hosturl'];
    }
    $ticket_strs[] = "<table>";
    foreach ($info_lines as $h => $i) {
        $value = (empty($i))?'EMPTY':$i;
        $ticket_strs[] = '<tr><td>' . $h . '</td>' . '<td>' . $value . '</td></tr>';
    }
    $ticket_strs[] = '</table>';
    $ticket_strs[] = '<hr/>';

    $support_ticket_str = join('',$ticket_strs);
    return $support_ticket_str;
}

function os_arch_string_check($loader_str)
{
    $errors = array();
    if (preg_match("/target os:\s*(([^_]+)_([^-]*)-([[:graph:]]*))/i",$loader_str,$os_matches)) {
        $loader_info = get_loaderinfo();
        $dirname = calc_dirname();
        $packed_osname = preg_replace('/\s/','',strtolower($loader_info['osname']));
        if (strtolower($dirname) != $os_matches[1] && $packed_osname != $os_matches[2]) {
            $errors[ERROR_LOADER_WRONG_OS] = "You have the wrong loader for your operating system, ". $loader_info['osname'] . ".";
        } else {
            $loader_wordsize = (strpos($os_matches[3],'64') === false)?32:64;
            if ($loader_info['arch'] != ($ap = required_loader_arch($os_matches[3],$loader_info['oscode'],$loader_wordsize))) {
                $err_str = "You have the wrong loader for your machine architecture.";
                $err_str .= " Your system is " . $loader_info['arch'];
                $err_str .= " but the loader you are using is for " . $ap . ".";
                $errors[ERROR_LOADER_WRONG_ARCH] = $err_str;
            }
        }
    }
    return $errors;
}

function get_loader_strings($loader_location)
{
    if (function_exists('file_get_contents')) {
        $loader_strs = @file_get_contents($loader_location);
    } else {
        $lines = @file($loader_location);
        $loader_strs = join(' ',$lines);
    }
    return $loader_strs;
}

function loader_system($loader_location)
{
    $loader_system = array();
    $loader_strs = get_loader_strings($loader_location);

    if (!empty($loader_strs)) {

        if (preg_match("/ioncube_loader_.\.._(.)\.(.)\.(..?)(_nonts)?(_amd64)?\.dll/i",$loader_strs,$version_matches)) {
            $loader_system['oscode'] = 'win';
            $loader_system['thread_safe'] = (isset($version_matches[4]) && $version_matches[4] == '_nonts')?0:1;
            $loader_system['wordsize'] = (isset($version_matches[5]) && $version_matches[5] == '_amd64')?64:32;
            $loader_system['arch'] = ($loader_system['wordsize'] == 64)?'x86-64':'x86';
            $loader_system['php_version_major'] = $version_matches[1];
            $loader_system['php_version_minor'] = $version_matches[2];
			if ($loader_system['php_version_major'] == 5 && $loader_system['php_version_minor'] >= 5) {
				$loader_system['compiler'] = 'VC11'; 
			} elseif (preg_match("/assemblyIdentity.*version=\"([^.]+)\./",$loader_strs,$compiler_matches)) {
                $loader_system['compiler'] = "VC" . strtoupper($compiler_matches[1]);
            } else {
                $loader_system['compiler'] = 'VC6';
            }
        } elseif (preg_match("/php version:\s*(.)\.(.)\.(..?)(-ts)?/i",$loader_strs,$version_matches)) {
            $loader_system['thread_safe'] = (isset($version_matches[4]) && $version_matches[4] == '-ts')?1:0;
            $loader_system['php_version_major'] = $version_matches[1];
            $loader_system['php_version_minor'] = $version_matches[2];
            if (preg_match("/target os:\s*(([^_]+)_([^-]*)-([[:graph:]]*))/i",$loader_strs,$os_matches)) {
                $loader_system['oscode'] = strtolower(substr($os_matches[2],0,3));
                $loader_system['wordsize'] = (strpos($os_matches[3],'64') === false)?32:64;
                $loader_system['arch'] = required_loader_arch($os_matches[3],$loader_system['oscode'],$loader_system['wordsize']);
                $loader_system['compiler'] = $os_matches[4];
            }
        }
        if (preg_match("/ionCube Loader Version\s+(\S+)/",$loader_strs,$loader_version)) {
            $loader_system['loader_version'] = $loader_version[1];
        } else {
            $loader_system['loader_version'] = 'UNKNOWN';
        }
        if (isset($loader_system['php_version_major'])) {
            $loader_system['php_version'] = $loader_system['php_version_major'] . '.' . $loader_system['php_version_minor'];
        }
    }
    return $loader_system;
}

function loader_compatibility_test($loader_location)
{
    $errors = array();

    $sysinfo = get_sysinfo();
    if (LOADER_NAME_CHECK) {
        $installed_loader_name = basename($loader_location);
        $expected_loader_name = get_loader_name();
        if ($installed_loader_name != $expected_loader_name) {
            $errors[ERROR_LOADER_UNEXPECTED_NAME] = "The installed loader (<code>$installed_loader_name</code>) does not have the name expected (<code>$expected_loader_name</code>) for your system. Please check that you have the correct loader for your system.";
        }
    }
    if (empty($errors) && !is_readable($loader_location)) {
        $execute_error = "The loader at $loader_location does not appear to be readable.";
        $execute_error .= "<br>Please check that it exists and is readable.";
        $execute_error .= "<br>Please also check the permissions of the containing ";
        $execute_error .= (is_ms_windows()?'folder':'directory') . '.';
        if (($sysinfo['SS'] == 'IIS') || !($sysinfo['IS_CGI'] || $sysinfo['IS_CLI'])) {
            $execute_error .= "<br>Please also check that the web server has been restarted.";
        }
        $execute_error .= ".";
        $errors[ERROR_LOADER_NOT_READABLE] = $execute_error;
    }
    $loader_strs = get_loader_strings($loader_location);
    $phpv = php_version(); 
    if (preg_match("/php version:\s*(.)\.(.)\.(..?)(-ts)?/i",$loader_strs,$version_matches)) {
        if ($version_matches[1] != $phpv['major'] || $version_matches[2]  != $phpv['minor']) {
            $loader_php = $version_matches[1] . "." . $version_matches[2];
            $server_php =  $phpv['major'] . "." .  $phpv['minor'];
            $errors[ERROR_LOADER_PHP_MISMATCH] = "The installed loader is for PHP $loader_php but your server is running PHP $server_php.";
        }
        if (is_bool($sysinfo['THREAD_SAFE']) &&  $sysinfo['THREAD_SAFE'] && !is_ms_windows() && !(isset($version_matches[4]) && $version_matches[4] == '-ts')) {
            $errors[ERROR_LOADER_NONTS_PHP_TS] = "Your server is running a thread-safe version of PHP but the loader is not a thread-safe version.";
        } elseif (isset($version_matches[4]) && $version_matches[4] == '-ts' && !(is_bool($sysinfo['THREAD_SAFE']) &&  $sysinfo['THREAD_SAFE'])) {
            $errors[ERROR_LOADER_TS_PHP_NONTS] = "Your server is running a non-thread-safe version of PHP but the loader is a thread-safe version.";
        }
    } elseif (preg_match("/ioncube_loader_.\.._(.)\.(.)\.(..?)(_nonts)?\.dll/i",$loader_strs,$version_matches)) {
        if (!is_ms_windows()) {
            $errors[ERROR_LOADER_WIN_SERVER_NONWIN] = "You have a Windows loader but your server does not appear to be running Windows.";
        } else {
            if (isset($version_matches[4]) && $version_matches[4] == '_nonts' && is_bool($sysinfo['THREAD_SAFE']) &&  $sysinfo['THREAD_SAFE']) {
                $errors[ERROR_LOADER_WIN_NONTS_PHP_TS] = "You have the non-thread-safe version of the Windows loader but you need the thread-safe one.";
            } elseif (!(is_bool($sysinfo['THREAD_SAFE']) &&  $sysinfo['THREAD_SAFE']) && !(isset($version_matches[4]) && $version_matches[4] == '_nonts')) {
                $errors[ERROR_LOADER_WIN_TS_PHP_NONTS] = "You have the thread-safe version of the Windows loader but you need the non-thread-safe one."; 
            }
            if ($version_matches[1] != $phpv['major'] || $version_matches[2]  != $phpv['minor']) {
                $loader_php = $version_matches[1] . "." . $version_matches[2];
                $server_php =  $phpv['major'] . "." .  $phpv['minor'];
                $errors[ERROR_LOADER_WIN_PHP_MISMATCH] = "The installed loader is for PHP $loader_php but your server is running PHP $server_php.";
            }
            if (preg_match("/assemblyIdentity.*version=\"([^.]+)\./",$loader_strs,$compiler_matches)) {
                $loader_compiler = "VC" . strtoupper($compiler_matches[1]);
            } else {
                $loader_compiler = 'VC6';
            }
            if ($loader_compiler != $sysinfo['PHP_COMPILER']) {
                $errors[ERROR_LOADER_WIN_COMPILER_MISMATCH] = "Your loader was built using $loader_compiler but you need the loader built using ${sysinfo['PHP_COMPILER']}.";
            }
        }
    } else {
            $errors[ERROR_LOADER_PHP_VERSION_UNKNOWN] = "The PHP version for the loader cannot be determined - please check that you have a valid ionCube Loader.";
    } 
    $errors += os_arch_string_check($loader_strs);

    return $errors;
}

function unix_path_dir($dir = '')
{
    if (empty($dir)) {
        $dir = dirname(__FILE__);
    }
    if (is_ms_windows()) {
        $dir = str_replace('\\','/',substr($dir,2));
    }
    return $dir;
}

function unrecognised_inis_webspace($startdir)
{
    $ini_list = array();

    $ini_name = ini_file_name();
    $sys = get_sysinfo();
    $depth = substr_count($startdir,'/');

    $rel_path = '';
    $rootpath = realpath($_SERVER['DOCUMENT_ROOT']);
    for ($seps = 0; $seps < $depth; $seps++) {
        $full_ini_loc = @realpath($startdir . '/' . $rel_path) . DIRECTORY_SEPARATOR . $ini_name;
        if (@file_exists($full_ini_loc) && $sys['PHP_INI'] != $full_ini_loc) {
            $ini_list[] = @realpath($full_ini_loc);
        }

        if (dirname($full_ini_loc) == $rootpath) {
            break;
        }
        $rel_path .= '../';
    }
    return $ini_list;
}

function loader_download_url($basename,$download_server = IONCUBE_DOWNLOADS_SERVER)
{  
    $sysinfo = get_sysinfo();
    $loader = get_loaderinfo();
    $multiple_os_versions = false;

    if (is_ms_windows()) {
      $basename = windows_package_name();
    }
    else {
      list($basename,$multiple_os_versions) = unix_package_name();
      
      if ($basename == "") {
        /* TODO no suitable loader archive */
      }
    }
    
    $a = '.zip';

    return "$download_server/$basename$ext_sep$a";
}
?>