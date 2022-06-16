<?php

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    foreach($models1 as $mod1){
        echo "<div class='col-lg-12' style='border:1px solid black'> <p> Nama Pelanggan :".$mod1['nama']."</p><p>Id beli:".$mod1['id']."</p>";
        foreach($models2 as $mod2){
            if($mod1['id']==$mod2['order_tabel_id']){
                echo "<p>Item yang dibeli:".$mod2['name']."</p>";
            }
        }
        echo "</div>";
    }
?>
</div>