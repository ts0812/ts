<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\platform\models\Node */

$this->title = '添加权限';
$this->params['breadcrumbs'][] = ['label' => 'Nodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="node-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  $model ->status = 1 ?>
    <?php  $model ->is_menu = 0 ?>
    <?php  $model ->is_need_validation_rule = 1 ?>
    <?php  $model ->is_api = 0 ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
