<?php

// uncomment the following to define a path alias
Yii::setPathOfAlias('site', dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
		'sourceLanguage'=>'fr',

	// preloading 'log' component
	'preload'=>array('log'),
    'import'=>array(
        'site.common.models.*', 
	//'site.common.extensions.yiidebugtb.*', //our extension
    ),
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=yiisite',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'design',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
	    'enableProfiling'=> true,
        ),
	
	'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, trace,info',
                    			'categories'=>'system.db.*',
				),
				
				array(
					'class'=>'CWebLogRoute',
				),

			),
		),			
	),	
        'params' => array(
            // this is used in contact page
            'adminEmail' => 'webmaster@example.com',
        ),
    

);
