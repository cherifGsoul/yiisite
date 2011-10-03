<?php

// uncomment the following to define a path alias
Yii::setPathOfAlias('site', dirname(__FILE__) . DIRECTORY_SEPARATOR . '../../');

$admin_conf = include '../administration/config/main.php';


// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$common_conf = array(
    'import' => array(
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
        ),
        'params' => array(
            // this is used in contact page
            'adminEmail' => 'webmaster@example.com',
        ),
    )
);
return CMap::mergeArray($admin_conf, $common_conf);
