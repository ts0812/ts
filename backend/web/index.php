<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';
if(isset($_SERVER['ENV_SERVER']) && $_SERVER['ENV_SERVER'] == 'aliyun'){
    require __DIR__ . '/../../common/config/define.php';
}else{
    require __DIR__ . '/../../common/config/define-local.php';
}
$config = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../config/web.php'
);
(new yii\web\Application($config))->run();
