<?php

namespace common\models;

use backend\models\OrderItem;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "item".
 *
 * Try to modified GII Generator
 * @property int $id
 * @property string $nama
 * @property int $price
 * @property string $image
 * @property int $category_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property ItemCategory $category
 * @property OrderItem[] $orderItems
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $upload;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className()
        ];
    }

    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'category_id'], 'required'],
            [['price', 'category_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['nama'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 100],
            [['upload'], 'file', 'extensions' => ['png','jpg','jpeg'], 'maxSize' => '500000'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ItemCategory::className(), 'targetAttribute' => ['category_id' => 'id']],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'price' => 'Price',
            'image' => 'Image',
            'category_id' => 'Category ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'upload' => 'Image Item',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ItemCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['item_id' => 'id']);
    }

    public function getPriceRp()
    {
        return 'Rp'.number_format($this->price, 2, ',', '.');
    }

    public function getImageUrl()
    {
        if(!$img = $this->image) $img = 'upload/items/No_Image.jpg';
        return Yii::$app->request->hostInfo.'/'.$img;
    }
}
