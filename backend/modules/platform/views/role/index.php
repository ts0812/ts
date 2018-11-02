<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\user\models\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '角色管理');
?>
<div class="role-index container-fluid">

<div class="index_header row" style=" margin:0;">
<p class="row p_button">
        <?= Html::a(Yii::t('app', '+添加角色'), ['create'], ['class' => 'btn']) ?>

    </p>
</div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    	'layout'=>"<div class='box-body table-responsive'>{items}</div><div class='row box-body'><div class='col-lg-7'>{summary}</div><div class='col-lg-5 text-right'>{pager}</div></div>",
        //'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'role_name',
            //'role_code',
            'functional_description',
			[
				'attribute' => 'role_status',
				'value' => function ($model) {
					return \backend\models\Role::getStatusName($model->role_status);
				},
				'format' => 'raw',
			],
            //'role_remark',
            'addtime',
            //'edittime:datetime',

//            ['class' => 'yii\grid\ActionColumn' ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}  {update}  {delete}  {auth}',
                'buttons' => [
	                'delete' => function ($url, $model, $key) {
	                	$options = [
	                	'title' => Yii::t('yii', '删除'),
	                	'aria-label' => Yii::t('yii', 'delete'),
	                	'data-pjax' => '0',
	                	'data-confirm' => '确定要执行删除操作吗?',
	                	'data-method' => 'post',
	                	];
	                	return Html::a('<i class="glyphicon glyphicon-trash	"></i>', $url, $options);
	                },
                    // 下面代码来自于 yii\grid\ActionColumn 简单修改了下
                    'auth' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', '权限分配'),
                            'aria-label' => Yii::t('yii', 'auth'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-warning-sign"></span>', $url, $options);
                    },
                ]
            ]
        ],
		'layout'=>"{items}\n{pager}"
    ]); ?>
</div>
<script type="text/javascript">
    function checkUseStatusShow(){
        var pageSize = $('.pageSize').val();
        location.href = changeURLArg(window.location.href , 'pageSize' , pageSize);
    }
</script>
