<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    #w0{
        height: 100px;
    }
    .form-group{
        width:150px;float: left;margin-right:30px;
    }
</style>
<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?= $form->field($model, 'name')->textInput( ['placeholder' =>'请输入姓名'])->label(false) ?>
    <?= $form->field($model, 'username')->textInput( ['placeholder' =>'请输入登录名称'])->label(false) ?>
    <?= $form->field($model, 'phone')->textInput( ['placeholder' =>'请输入手机号码'])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
