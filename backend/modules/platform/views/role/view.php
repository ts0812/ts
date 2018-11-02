<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\entity\Role */

$this->title = '查看详情';?>
<div class="role-view view-table">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'role_id',
            'role_name',
            'role_code',
            'functional_description',
            [
				'attribute' => 'role_status',
				'value' => function ($model) {
					return \backend\models\Role::getStatusName($model->role_status);
				},
				'format' => 'raw',
			],
            'role_remark',
            'addtime',
            'edittime',
        ],
    ]) ?>

</div>
