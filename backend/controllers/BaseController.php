<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\OperationLog;
use yii\web\UploadedFile;
/** 
 * @SuppressWarnings(PHPMD)
 */
class BaseController extends Controller {

    /**
     * 钩子方法{@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'except'=>['login'],//login不进行访问验证
                'rules' => [
                        [
                        'allow' => true,
                        'roles' => ['@'],
                    ], 
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
    }
    static public $noAuthUrl=[
    	'site/login',
    	'site/register',
    ]; 
    public function beforeAction($action) {
    	$view = Yii::$app->view;
        $view->params= ['username'=>'无名','menus'=>[]] ; 
        if (Yii::$app->user->isGuest) {  
            if (!in_array(Yii::$app->request->pathInfo,self::$noAuthUrl)) { 
                return $this->redirect(['/site/login'])->send();
            }
        }
        if (!Yii::$app->user->isGuest) {
            $cookies = Yii::$app->request->cookies;
            if (!isset($cookies['userAuthKey']) || $cookies['userAuthKey'] != Yii::$app->user->identity->auth_key) {  //登录态唯一性校验 
                $cookie = Yii::$app->response->cookies; $cookie->remove('userAuthKey');Yii::$app->user->logout(false);
                return $this->redirect(['/site/login'])->send();
            }
            // $view->params['username'] = Yii::$app->user->identity->user_account;
            $this->_auth(Yii::$app->user->identity->id, Yii::$app->user->identity->role_id);
        }
        return parent::beforeAction($action);
    }

    private function _auth($userId, $roleId) {

        //获取数组
        $nodes = \backend\models\Node::getNodeMenu($userId, $roleId);

        list($menu, $authUrl) = $nodes;
        Yii::$app->view->params['menus'] = $menu;
       
        //排序
        $r = Yii::$app->request->pathInfo;
        $node = \backend\models\Node::find()->where(['url' => $r])->asArray()->one();
         if (in_array($r, self::$noAuthUrl)) {
             return true;
         }

        if($roleId !==1&&(empty($node)||!in_array($r, $authUrl))){ //不是系统总账号需要进行权限判断
            return $this->redirect(['/site/autherror'])->send();
        }
        return true;
    }
} 