<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Node */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="node-form container-fluid">

    <?php $form = ActiveForm::begin([
            // 'fieldConfig' => [
            //     'template' => "<div class=\"col-lg-6 form-group-inner required\">{label}:{input}</div>"
            // ]
            "options" => ['class' => "form-create"]
    ]); ?>

    <?= $form->field($model, 'pid')->dropDownList(
        backend\modules\platform\models\Node::getAllNodeName()
        //   [1,2,3,4,5]
    ) ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder' => '菜单名称',]) ?>

    <?= $form->field($model, 'module')->textInput(['maxlength' => true,'placeholder' => '模块-默认为空']) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true,'placeholder' => '权限路径-例子：account/node/index ，首级菜单为空']) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true,'placeholder' => '请填写备注信息']) ?>

    <?= $form->field($model, 'sort')->dropDownList(range(0, 99)) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true,'placeholder' => '图表-默认为空']) ?>
 <div></div>
    <?= $form->field($model, 'status')->radioList([ 0=>'禁用',1=>'正常']); ?>
    <div></div>
    <?= $form->field($model, 'is_menu')->radioList([ 0=>'否',1=>'是']); ?>
    <?= $form->field($model, 'is_api')->radioList([ 0=>'否',1=>'是']); ?>
    <?= $form->field($model, 'is_need_validation_rule')->radioList([ 0=>'否',1=>'是']); ?>
    <div class="form-group button-group">
        <?= Html::submitButton('保存', ['class' => 'btn']) ?>
        <!-- <?= Html::submitButton('取消', ['class' => 'btn']) ?> -->
    </div>

    <?php ActiveForm::end(); ?>

</div>
