<?php

// uncomment the following to define a path alias
Yii::setPathOfAlias('site', dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../');

$admin_conf = include '../administration/config/main.php';
$front_conf = include '../frontend/config/main.php';


// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$common_conf = array(
    'import'=>array(
        'site.common.models.*',    
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
	// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
        'params' => array(
            // this is used in contact page
            'adminEmail' => 'webmaster@example.com',
        ),
    )
);
//return CMap::mergeArray($admin_conf, $common_conf);
return CMap::mergeArray($admin_conf,$common_conf);
