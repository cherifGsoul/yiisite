<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$admin_conf = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'DASHBOARD',
	'defaultController'=>'dashboard',
	'sourceLanguage'=>'fr',

	// preloading 'log' component
	//'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	//	'application.extensions.yiidebugtb.*', //our extension
                 
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
		
		//'runtimePath'=>dirname(__FILE__).'../../runtime',
		
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'dashboard/error',
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);

$main_conf = require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'../../common/config/main.php');
return CMap::mergeArray($main_conf,$admin_conf);
