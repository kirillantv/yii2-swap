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
            [['required'], 'integer'],
            [['slug', 'name', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
            'type' => 'Type',
            'required' => 'Required',
        ];
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
}
