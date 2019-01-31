<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">

    <p>
        <?= Html::a('添加用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'username',
            'name',
            'phone',
            'last_login_time',
            'last_login_ip',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return \backend\models\User::$_status[$model->status];
                },
                'format' => 'raw',
                'filter' =>\backend\models\User::$_status,
            ],
            'create_time',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}{change-status}',
                'buttons' => [
                    // 下面代码来自于 yii\grid\ActionColumn 简单修改了下
                    'change-status'=>function ($url, $model) {
                        $txt=$model->status==1?'禁用':($model->status==0?'启用':'');
                        if($txt){
                            return Html::a('<span class="">'.$txt.'</span>', $url);
                        }
                    },
                ]
            ]
        ],
    ]); ?>
</div>
