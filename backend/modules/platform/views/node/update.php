<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\platform\models\Node */

$this->title = 'Update';


$this->params['breadcrumbs'][] = ['label' => 'Nodes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->node_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="node-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
