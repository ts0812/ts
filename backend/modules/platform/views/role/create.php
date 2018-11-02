<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\entity\Role */

$this->title = Yii::t('app', '添加角色');
?>
<div class="role-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
