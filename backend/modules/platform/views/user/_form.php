<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\user */
/* @var $form yii\widgets\ActiveForm */

?>
<style>
    #w0{
        width:300px;
    }
</style>
<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>

    <?php if($type == 'create' ) echo $form->field($model, 'username')->textInput(['maxlength' => true])->label('账号'); ?>

    <?= $form->field($model, 'passwd')->passwordInput(['maxlength' => true])->label('密码') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role_id')->dropDownList(\backend\models\Role::getAllRole()) ?>

    <?php $model->status = $model->status ?? 1; ?>
    <?= $form->field($model, 'status')->radioList(['1'=>'正常','0'=>'禁用']); ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
