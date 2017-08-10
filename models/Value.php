<?php

namespace kirillantv\swap\models;

use Yii;

/**
 * This is the model class for table "{{%value}}".
 *
 * @property integer $item_id
 * @property integer $attribute_id
 * @property string $value_string
 * @property integer $value_number
 *
 * @property ItemAttribute $itemAttribute
 * @property Item $item
 */
class Value extends \yii\db\ActiveRecord
{
	const SCENARIO_TABULAR = 'tabular';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%value}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'attribute_id'], 'required'],
            [['item_id', 'attribute_id', 'value_number'], 'integer'],
            [['value_string'], 'string', 'max' => 255],
            [['value_string'], 'required', 'except' => self::SCENARIO_TABULAR],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::className(), 'targetAttribute' => ['attribute_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'attribute_id' => 'Attribute ID',
            'value_string' => 'Value String',
            'value_number' => 'Value Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemAttribute()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }
}
