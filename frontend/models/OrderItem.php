<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property int $order_tabel_id
 * @property int $item_id
 *
 * @property Item $item
 * @property OrderTabel $orderTabel
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_tabel_id', 'item_id'], 'required'],
            [['order_tabel_id', 'item_id'], 'integer'],
            [['order_tabel_id'], 'unique'],
            [['order_tabel_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderTabel::className(), 'targetAttribute' => ['order_tabel_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_tabel_id' => 'Order Tabel ID',
            'item_id' => 'Item ID',
        ];
    }
    public function daftarOrderItem(){
        $query=new \yii\db\Query();
        return $query->select("oi.order_tabel_id, i.name")->from("order_item oi, item i")->where("i.id=oi.item_id")->all();
    }

    /**
     * Gets query for [[Item]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    /**
     * Gets query for [[OrderTabel]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderTabel()
    {
        return $this->hasOne(OrderTabel::className(), ['id' => 'order_tabel_id']);
    }
}
