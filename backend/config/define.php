<?php
/**
 * 环境 定义
 */

define('TOKEN_OUT_TIME', 86400*7);
define('PAGE_SIZE', 15);
define('IS_LAN' , false); // 是否为 local area network   false or true //false访问用户中心 ture访问本地用户
define('YII_DEBUG',true); // debug
define('YII_ENV','production');//运行环境 dev production


//------------------MYSQL-------------------------------
define('MYSQL_HOST', '127.0.0.1');
define('MYSQL_DBNAME', 'ts');
define('MYSQL_USERNAME', 'root');
define('MYSQL_PASSWOER', '');
define('MYSQL_CHARSET', 'utf8');
define('MYSQL_PORT', 3306);
