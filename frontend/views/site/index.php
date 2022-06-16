<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\ItemCategory;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?php echo Yii::$app->name; ?></h1>

        <p class="lead">SELAMAT DATANG Di TOKO BARU APLIKASI MY MART</p>

    </div>

    </div>

<div class="container">

    <div class="well well-sm">
        <div class="col-xs-10">
            <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'layout' => 'horizontal',
                    'method' => 'get',
                    'action' => \yii\helpers\Url::to(['site/index'])
            ]);
            $itemObj = new \common\models\Item();

            ?>
            <?= $form->field(new $itemObj,'category_id')->dropDownList(ArrayHelper::map(ItemCategory::find()->all(), 'id', 'name'),['prompt'=>'Pilih Kategori Yang Diinginkan'])->label('Kategori') ?>
        </div>
        <div>
            <?= Html::submitButton('Silahkan Filter', ['class' => 'btn btn-success', 'name' => 'filter-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="row">
        <?php
        $items = $provider->getModels();
        foreach ($items as $item): ?>
            <div class="item  col-xs-4 col-lg-4">
                <div class="thumbnail">
                    <img class="group list-group-image" src="<?=$item->imageUrl?>" alt="" style="min-height: 100px; max-height: 100px"/>
                    <div class="caption">
                        <h4 class="group inner list-group-item-heading">
                            <?=$item->nama?></h4>
                        <p class="group inner list-group-item-text">
                            <?=$item->category->name?:'No Category'?>
                        </p>
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <p class="lead">
                                    <?=$item->priceRp?></p>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <?php
                                if (Yii::$app->user->isGuest)
                                    echo Html::a('Beli Produk',['/site/login'],['class'=>'btn btn-primary']);
                                else
                                    echo Html::a('Add to Card Shop',['/site/checkout'],['class'=>'btn btn-success']);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <?= \yii\widgets\LinkPager::widget(['pagination' => $provider->pagInation]); ?>
</div>


    
</div>
