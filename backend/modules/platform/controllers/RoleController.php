<?php
namespace backend\modules\platform\controllers;

use backend\models\NodeRole;
use Yii;
use backend\models\Role;
use backend\modules\platform\models\RoleSearch;
use backend\controllers\BaseController;
use yii\web\NotFoundHttpException;
use backend\models\Node;
use common\helpers\ArrayHelper;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends BaseController
{
    /**
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoleSearch();
        $queryParams = Yii::$app->request->queryParams;
		$queryParams['RoleSearch']['role_status'] = 1;
        $dataProvider = $searchModel->search($queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'queryParams' =>$queryParams
        ]);
    }

    /**
     * Displays a single Role model.
     * @param integer $id
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
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->role_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->role_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		$model->role_status = 99;
		if($model->save()){
			return $this->redirect(['index']);
		}
    }

    /**
     * 权限分配
     */
    public function actionAuth($id)
    {
        $oldAuth=NodeRole::findAll(['role_id' => $id]);
        $authId = $oldAuth?ArrayHelper::map($oldAuth, 'node_id' , 'node_id'):[];
        if ($ids = Yii::$app->request->post('auth')){
            $all = Node::find()->select(['node_id','pid'])->where(['status'=>1])->asArray()->all();
            $idAll = []; //权限路由
            foreach ($ids as $v) {
                $val = (int)$v;
                if($val>0){
                    $idAll[$v] = $val;
                }
            }
            //权限路由获取父级路由
            foreach ($ids as $v) {
               ArrayHelper::getParents($all, $v,$idAll);
            }
            Role::updateAuth($id, $idAll, $authId);
            $nodes = Node::findAll(['node_id' => $idAll]);
            $node = '';
            if(!empty($nodes)){
                foreach($nodes as $v){
                    $node = !empty($node)?$node.' '.$v->node_id.':'.$v->name:$v->node_id.':'.$v->name;
                }
            }
            return $this->redirect(['index']);
        }
        $list = Node::getAllNode();
        return $this->render('auth', [
            'list' => $list,
            'auth_id' => $authId,
        ]);
    }
    /**
     * 权限配置
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionConfigAuth($id)
    {
        $newMcIds = Yii::$app->request->post('mcIds',[]);
        $mcIds = ArrayHelper::map(NodeRole::findAll(['role_id' => $id]), 'node_id', 'node_id');
        if (Yii::$app->request->isPost) {
            $this->updateMapConfigAuth($id, $newMcIds, $mcIds);
            return $this->redirect(['index']);
        }
        $list = Node::find()->where(['status'=>1])->asArray()->all();
        $list = ArrayHelper::listToTree($list, 'node_id', 'pid', 'z');
        return $this->render('config-auth', [
            'list' => $list,
            'mcIds' => $mcIds,
        ]);
    }

    /**
     * 修改权限
     * @param int $roleId 用户id
     * @param array $nowAuthIds 新的权限id 集合
     * @param array $authIds 旧的权限id 集合
     */
    private function updateMapConfigAuth(int $roleId, array $nowAuthIds, array $authIds)
    {
        //要添加的权限
        $add = array_diff($nowAuthIds, $authIds);
        //要取消的权限
        $delete = array_diff($authIds, $nowAuthIds);
        //添加权限 插入数据
        $model = new NodeRole();
        if ($add) {
            foreach ($add as $nodeId) {
                $model->isNewRecord = true;
                $model->setAttributes(['node_id' => $nodeId, 'role_id' => $roleId]);
                $model->save();
            }
        }
        //取消权限 删除数据
        if ($delete) {
            foreach ($delete as $nodeId) {
                Yii::$app->db->createCommand()->delete($model::tableName(), ['node_id' => $nodeId, 'role_id' => $roleId])->execute();
            }
        }
    }
    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

}
