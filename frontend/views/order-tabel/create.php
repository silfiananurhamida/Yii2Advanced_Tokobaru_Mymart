<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\OrderTabel */

$this->title = 'Create Order Tabel';
$this->params['breadcrumbs'][] = ['label' => 'Order Tabels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-tabel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
