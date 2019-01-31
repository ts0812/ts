<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\entity\Role */
/* @var $form yii\widgets\ActiveForm */
?>
<style>

    #w0{
        width: 40%;
    }
</style>
<div class="role-form container-fluid">

    <?php $form = ActiveForm::begin([
                "options" => ['class' => "form-create"]
    ]); ?>

    <?= $form->field($model, 'role_name')->textInput(['maxlength' => true,'placeholder' => '请填写角色名称']) ?>


    <?= $form->field($model, 'functional_description')->textInput(['maxlength' => true,'placeholder' => '请填写职能描述信息']) ?>


    <?= $form->field($model, 'role_remark')->textInput(['maxlength' => true,'placeholder' => '请填写备注信息']) ?>

    <div class="form-group button-group">
        <?= Html::submitButton(Yii::t('app', '提交'), ['class' => 'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
