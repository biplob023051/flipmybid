<?php
    $config = array(
        'Database' => array(
            'driver'     => 'mysql',
            'persistent' => false,
            'host'       => 'localhost',
            'login'      => '',
            'password'   => '',
            'database'   => 'pacv2',
            'prefix'     => '',
            'encoding'	 => 'utf8'
        ),

        'App' => array(
            'encoding'               => 'UTF-8',
            'baseUrl'                => '',
            'base'                   => '',
            'dir'					 => 'app',
            'webroot'				 => 'webroot',
            'demoMode' 	             => false,

            'Dob' => array(
                'year_min' => date('Y') - 100,
                'year_max' => date('Y') - 18
            )
        )
    );
?>