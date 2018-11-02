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

    public function beforeAction($action) {
    	// $view = Yii::$app->view;
     //    $view->params= ['username'=>'无名','menus'=>[],'department'=>''] ; 
        if (Yii::$app->user->isGuest) {  
            if (Yii::$app->request->pathInfo!='site/login') { 
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
            // $view->params['department'] = \backend\models\User::getAllDepartmentName(Yii::$app->user->identity->department_id);
           
          //  $this->_auth(Yii::$app->user->identity->id, Yii::$app->user->identity->role_id,$power);
           
        }
        return parent::beforeAction($action);
    }
} 