<?php

namespace kirillantv\swap\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $slug
 * @property string $name
 * @property integer $parent_id
 *
 * @property Category $parent
 * @property Category[] $categories
 * @property ItemCategory[] $itemCategories
 * @property Item[] $items
 */
class Category extends \yii\db\ActiveRecord
{
	public $items_count;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'name'], 'required'],
            [['parent_id'], 'integer'],
            [['slug', 'name'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' =>  Yii::t('swap', 'Slug'),
            'name' =>  Yii::t('swap', 'Name'),
            'parent_id' =>  Yii::t('swap', 'Parent ID'),
        ];
    }
    
    public function hasParent()
    {
    	if ($this->parent != null)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    }
    
    public function hasChildren()
    {
    	if ($this->children != null)
    	{
    		return 1;
    	}
    	else
    	{
    		return 0;
    	}
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }
    
    public function getChildren()
    {
    	return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemCategories()
    {
        return $this->hasMany(ItemCategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['id' => 'item_id'])->viaTable('{{%item_category}}', ['category_id' => 'id']);
    }
}
