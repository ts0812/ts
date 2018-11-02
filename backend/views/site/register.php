<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
$this->title = 'register';
?>
<div class="site-register">

    <?php $form = ActiveForm::begin([
        'id'=>'form',
       // 'enableAjaxValidation' => true,  

         'method' => 'post',
        'action' => 'register',
        'enableClientValidation' => true,


    ]); ?>

        <?= $form->field($model, 'username') ->label('*账号')?>
        <?= $form->field($model, 'passwd') ->passwordInput()->label('*密码')?>

        <?= $form->field($model, 'email') ->label('*邮箱')?>

    
        <div class="form-group">
            <?= Html::submitButton('注册', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-register -->
<?php
$js = <<<JS

JS;
$this->registerJs($js);
