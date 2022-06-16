<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order History';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $dataProvider2 = new ActiveDataProvider([
        'query' => $dataProvider,
        'pagination' => [
            'pageSize' => 10,
        ],
    ]);
    //menampilkan data dalam bentuk gridview
    echo GridView::widget([
        'dataProvider' => $dataProvider2,
        'columns' => [
            'Order id' => 'id',
            'date:datetime',
            'customer.nama',
            [
                'label' => 'Items',
                'class' => 'yii\grid\DataColumn',
                'format' => 'html',
                'value' => function($data){
                    $value="<ul>";

                    //menampilkan item dalam bentuk list di dalam kolom gridview
                    foreach ($data->orderItems as $orderItem)
                    {
                        $value .="<li>".$orderItem->item->nama."</li>";
                        //var_dump($value); die();
                    }
                    $value.="</ul>";

                    return $value;
                },
            ],
        ],
    ]); ?>
</div>
