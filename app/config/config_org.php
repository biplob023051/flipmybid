<?php
    $config = array(
        'Database' => array(
            'driver'     => 'mysql',
            'persistent' => false,
            'host'       => 'localhost',
            'login'      => 'flipmybi_db1',
            'password'   => 'abc123#@!',
            'database'   => 'flipmybi_db1',
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
