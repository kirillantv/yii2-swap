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
            [['value_string'], 'required', 'when' => function($model, $attribute) {
            	return $this->itemAttribute->required == Attribute::ATTRIBUTE_REQUIRED;
            }, 'whenClient' => 'function (attribute, value) { return '.$this->itemAttribute->required.'=='.Attribute::ATTRIBUTE_REQUIRED.'; }'],
            [['value_string'], 'filter', 'when' => function($model, $attribute) {
            	return $this->itemAttribute->type == Attribute::TYPE_DROPDOWN;
            }, 'filter' => function($value){
            	$available = $this->itemAttribute->valuesArray;
            	$validate = false;
            	foreach ($available as $item)
            	{
            		if ($item == $value)
            		{
            			$validate = true;
            			return $value;
            		}
            	}
            }],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => Attribute::className(), 'targetAttribute' => ['attribute_id' => 'id']],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']]
        ];
    }
    
	public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_TABULAR] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'attribute_id' => 'Attribute ID',
            'value_string' =>  $this->scenario == self::SCENARIO_TABULAR ? $this->itemAttribute->name : 'Value String',
            'value_number' =>  $this->scenario == self::SCENARIO_TABULAR ? $this->itemAttribute->name : 'Value Integer',
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
