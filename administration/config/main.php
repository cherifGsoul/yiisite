<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'DASHBOARD',
	'defaultController'=>'dashboard',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.yiidebugtb.*', //our extension
                 
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'design',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1','127.0.1.1'),		
                    ),          
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			 'loginUrl' => array('/dashboard/login'),
		),
		
		'securityManager'=>array(
			'hashAlgorithm'=>'sha1',
		),
		/*'assetManager'=>array(
			'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..\webroot\assets',
		),*/
		// uncomment the following to enable URLs in path-format
		
		/*'urlManager'=>array(
                        'class'=>'ext.DbUrlManager.EDbUrlManager',
                        'connectionID'=>'db',
                        'urlFormat'=>'path',
                        'showScriptName'=>false,
                        'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),*/
		
		/*'runtimePath'=>'/../runtime',*/
		
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'dashboard/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, trace,info',
                    'categories'=>'system.db.*',
				),
				array( // configuration for the toolbar
					'class'=>'XWebDebugRouter',
					'config'=>'alignRight, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
					'levels'=>'error, warning, trace, profile, info',
					'allowedIPs'=>array('127.0.0.1'),
				),
				// uncomment the following to show log messages on web pages
				
				array(
					'class'=>'CWebLogRoute',
				),
				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);