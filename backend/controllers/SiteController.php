<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\User;
use yii\web\Response ;
use yii\widgets\ActiveForm;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','register'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) { 
       
            $condition = ['id' => Yii::$app->user->identity->id];
            if (Yii::$app->user->identity->login_time) {
                $attributes['last_login_time'] = Yii::$app->user->identity->login_time;
            }
            if (Yii::$app->user->identity->login_ip) {
                $attributes['last_login_ip'] = Yii::$app->user->identity->login_ip;
            }
            $attributes['login_time'] = date('Y-m-d H:i:s');
            $attributes['login_ip'] = Yii::$app->request->userIP;
            $attributes['auth_key'] = Yii::$app->user->identity->auth_key;
            \backend\models\User::updateAll($attributes, $condition);
            $post = Yii::$app->request->post();
            $rememberMe = isset($post['LoginForm']['rememberMe'])&&!empty($post['LoginForm']['rememberMe'])?1:0;
            $this->_setAuthKey($rememberMe, Yii::$app->user->identity->auth_key);
           
            return $this->redirect(['/site/index']);
        }
        else {
            $model->password = '';
            $this -> layout = 'main-login.php';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function _setAuthKey($rememberMe,$AuthKey){
        $time = $rememberMe ? 3600 * 24 * 7 : 0;
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'userAuthKey',
            'value' => $AuthKey,
            'expire' => time() + $time
        ]));
    }
    public function actionRegister()
    {   
        $model = new User();
        if($model->load(Yii::$app->request->post())){

           
            $model->password_hash =  Yii::$app->security->generateRandomString();  //hash盐值         
            $model->password =  Yii::$app->getSecurity()->generatePasswordHash($model->password_hash.$model->passwd);  //加密密码

            if($model->save()){
            
               
               return $this->redirect(['login']);
            }else{
               // $errors = $model->getErrors();
               // foreach ($errors as $key => $value) {
               //  var_dump( $value);
               // }
            }
        }
        
            
        
        $this -> layout = 'main-login.php';
        return $this->render('register',[
                'model' => $model,
            ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
