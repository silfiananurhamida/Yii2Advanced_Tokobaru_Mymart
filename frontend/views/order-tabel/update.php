<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrderTabel */

$this->title = 'Update Order Tabel: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Order Tabels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="order-tabel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
