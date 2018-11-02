<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\entity\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form container-fluid">

    <?php $form = ActiveForm::begin([
                // 'fieldConfig' => [
                //     'template' => "<div class=\"col-lg-6 form-group-inner required\">{label}:{input}</div>"
                // ]
                "options" => ['class' => "form-create"]
    ]); ?>

    <?= $form->field($model, 'role_name')->textInput(['maxlength' => true,'placeholder' => '请填写角色名称']) ?>

    <?= $form->field($model, 'role_code')->textInput(['placeholder' => '请填写角色编号']) ?>

    <?= $form->field($model, 'functional_description')->textInput(['maxlength' => true,'placeholder' => '请填写职能描述信息']) ?>

    

    <?= $form->field($model, 'role_type')->radioList(Yii::$app->params['role_type']) ?>
<?= $form->field($model, 'role_remark')->textInput(['maxlength' => true,'placeholder' => '请填写备注信息']) ?>
    <?php //= $form->field($model, 'edittime')->textInput() ?>

    <div class="form-group button-group">
        <?= Html::submitButton(Yii::t('app', '提交'), ['class' => 'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
