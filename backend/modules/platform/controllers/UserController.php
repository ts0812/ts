<?php


namespace backend\modules\platform\controllers;

use backend\controllers\BaseController;
use Yii;
use backend\modules\platform\models\UserSearch;
use backend\models\User;
use yii\web\NotFoundHttpException;
use common\helpers\ArrayHelper;

/**
 * UserController implements the CRUD actions for user model.
 */
class UserController extends BaseController
{

    /**
     * Lists all user models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single user model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new user model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @SuppressWarnings(PHPMD)
     */
    /**
     * Login action.
     */
    public function actionCreate()
    {
        $model = new User();
        $request = Yii::$app->request->post();
        if ($model->load($request)){
            $model->setPassword($model->passwd);
            if($model->save())
                return $this->redirect(['index']);
        }
        $model->passwd = '';
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing user model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @SuppressWarnings(PHPMD)
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $request = Yii::$app->request->post();
        $password = $model->password;
        //字段验证
        if ($model->load($request)){
            //密码加密
            if($request['User']['passwd'] != '******')
                $model->setPassword($model->passwd);
            else{
                $model->password = $password;
                $model->passwd='123456';
            }
            // TODO 开启事务
            $transaction = Yii::$app->db->beginTransaction();
            if($model->save()){
                $model->passwd = '';
                $transaction->commit();// TODO 提交事务
                return $this->redirect(['index']);
            }
        }
        $model->passwd = '******';
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index']);
    }


    /**
     * @param int $id
     * 开启、禁用账号
     */
    public function actionChangeStatus(int $id){
        $userlist = $this->findModel($id);
        $userlist->status=$userlist['status']==0?1:($userlist['status']==1?0:$userlist['status']);
        $userlist->save(false);
        return $this->redirect(['index']);
    }
    /**
     * Finds the user model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return user the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 接口验证字段
     * @param $arr
     * @return array
     */
    protected function fieldData($arr)
    {
        $data = [];
        foreach (['password' , 'name' , 'phone' , 'email'] as $value){
            if(isset($arr[$value])){
                $data[$value] = $arr[$value];
            }
        }
        return $data;
    }
}
