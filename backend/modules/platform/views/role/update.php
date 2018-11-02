<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\entity\Role */

$this->title = '编辑信息';
?>
<div class="role-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
