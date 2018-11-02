<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\platform\models\NodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '权限列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="node-index">


    <p>
        <?= Html::a('添加权限', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'node_id','label' =>'id'],
            'pid',
            'name',
            'url',
            'remark',
            ['attribute' => 'status','value' =>function($model){
                return Yii::$app->params['status'][$model->status];
            }],
            'sort',
            ['attribute' => 'is_menu','value' =>function($model){
                return Yii::$app->params['is_radio'][$model->is_menu];
            }],
            //'icon',
            ['attribute' => 'is_api','value' =>function($model){
                return Yii::$app->params['is_radio'][$model->is_menu];
            }],
            ['attribute' => 'is_need_validation_rule','value' =>function($model){
                return Yii::$app->params['is_radio'][$model->is_menu];
            }],
            'create_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
