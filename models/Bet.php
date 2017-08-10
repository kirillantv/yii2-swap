<?php

namespace kirillantv\swap\models;

use Yii;

/**
 * This is the model class for table "{{%bet}}".
 *
 * @property integer $id
 * @property string $name
 *
 * @property ItemBet[] $itemBets
 * @property Item[] $items
 * @property OrderBet[] $orderBets
 * @property Order[] $orders
 */
class Bet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bet}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemBets()
    {
        return $this->hasMany(ItemBet::className(), ['bet_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['id' => 'item_id'])->viaTable('{{%item_bet}}', ['bet_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderBets()
    {
        return $this->hasMany(OrderBet::className(), ['bet_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['id' => 'order_id'])->viaTable('{{%order_bet}}', ['bet_id' => 'id']);
    }
}
