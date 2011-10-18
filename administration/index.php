<?php
// change the following paths if necessary
$yii=dirname(__FILE__).'/../common/libraries/yii/yii.php';
//$common_config=dirname(__FILE__).'/../common/config/main.php';
$config=dirname(__FILE__).'/config/main.php';

//$config=CMap::mergeArray($common_config,$backend_config);




// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
