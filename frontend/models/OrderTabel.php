<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order_tabel".
 *
 * @property int $id
 * @property string $date
 * @property int $customer_id
 *
 * @property Customer $customer
 * @property OrderItem $orderItem
 */
class OrderTabel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_tabel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'customer_id'], 'required'],
            [['date'], 'safe'],
            [['customer_id'], 'integer'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'customer_id' => 'Customer ID',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    //untuk mendapatkan nilai dari customernya
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[OrderItem]].
     *
     * @return \yii\db\ActiveQuery
     */
    //untuk mengetahui item apa yang diorder
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_tabel_id' => 'id']);
    }
    //untuk mengetahui daftar data order barang
    public function daftarOrderCustomer(){
        $query=new \yii\db\Query();
        return $query->select("o.id, c.nama")->from("customer c, order_tabel o")->where("o.customer_id=c.id")->all();
    }

    public function getItems(){
        return $this->hasMany(Item::className(), ['id' => 'item_id'])->viaTable('order_item', ['order_tabel_id' => 'id']);
    }
}
