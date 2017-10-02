<?php

namespace kirillantv\swap\models;

use Yii;

/**
 * This is the model class for table "{{%attribute}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property string $type
 * @property integer $required
 *
 * @property Value[] $values
 * @property Item[] $items
 */
class Attribute extends \yii\db\ActiveRecord
{
	const TYPE_STRING = 'string';
	
	const TYPE_NUMBER = 'number';
	
	const TYPE_DROPDOWN = 'dropdown';
	
	const TYPE_CHECKBOX = 'checkbox';
	
	const ATTRIBUTE_REQUIRED = 1;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attribute}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'name', 'type'], 'required'],
            [['required', 'searchable'], 'integer'],
            [['slug', 'name', 'type'], 'string', 'max' => 255],
            [['value'], 'required', 'when' => function($model) {
            	return $this->type == Attribute::TYPE_DROPDOWN;
            }, 'whenClient' => 'function (attribute, value) { return '.$this->type.'=='.Attribute::TYPE_DROPDOWN.'; }'],
            [['value'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => Yii::t('swap', 'Slug'),
            'name' =>  Yii::t('swap', 'Name'),
            'type' =>  Yii::t('swap', 'Type'),
            'required' =>  Yii::t('swap', 'Required'),
            'searchable' =>  Yii::t('swap', 'Searchable')
        ];
    }
    public static function find()
    {
        return new \kirillantv\swap\models\query\AttributeQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Value::className(), ['attribute_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['id' => 'item_id'])->viaTable('{{%value}}', ['attribute_id' => 'id']);
    }
    
    public function getValuesArray()
    {
    	if ($this->type == Attribute::TYPE_DROPDOWN)
    	{
    		$array = explode(', ', $this->value);
    		$assocArray = [];
    		foreach ($array as $item)
    		{
    		    $assocArray[$item] = $item;	
    		}
    		
    		return $assocArray;
    	}
    }
}
