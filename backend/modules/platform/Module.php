<?php 
namespace backend\modules\platform;
use Yii;
 
/**
 * api module definition class
 */ 
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\platform\controllers';
  
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init(); 
    }
    
    //  public function beforeAction($action) {
    //     // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //     // //非登录，做校验
    //     // if (Yii::$app->request->pathInfo != 'api/user/login' && Yii::$app->request->pathInfo != 'api/task/index') {
    //     //     $uid = (int) Yii::$app->request->post('uid', 0);
    //     //     $skey = trim(\yii\helpers\HtmlPurifier::process(Yii::$app->request->post('skey', '')));
    //     //     $userSkey = Yii::$app->redis->get($uid); 
    //     //     //没有登录
    //     //     if (empty($userSkey) || empty($uid) || empty($skey)) {
    //     //         Yii::$app->response->data = ['code' => NO_LOGIN, 'msg' => NO_LOGIN_MSG];
    //     //         return false;
    //     //     }
    //     //     //单账号登录  
    //     //     if ($userSkey !=$skey) { 
    //     //         Yii::$app->response->data = ['code' => LOGIN_STATUS_INVALID, 'msg' => LOGIN_STATUS_INVALID_MSG];
    //     //         return false;
    //     //     }
    //     //     //重置登录态时间 
    //     //     Yii::$app->redis->expire($uid, TWO_HOUR);
    //     // }
    //     // return parent::beforeAction($action);
    // }

}