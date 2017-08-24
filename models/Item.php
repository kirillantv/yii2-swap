<?php

namespace kirillantv\swap\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%item}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $author_id
 * @property string $created_at
 * @property string $update_at
 * @property integer $active
 *
 * @property User $author
 * @property ItemBet[] $itemBets
 * @property Bet[] $bets
 * @property ItemCategory[] $itemCategories
 * @property Category[] $categories
 * @property Order[] $orders
 * @property Value[] $values
 * @property ItemAttribute[] $itemAttributes
 */
class Item extends \yii\db\ActiveRecord
{
    const SCENARIO_CHANGE_STATUS = 'change_status';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%item}}';
    }
    
    public function behaviors()
    {
    	return [
    		[
    			'class' => BlameableBehavior::classname(),
    			'createdByAttribute' => 'catcher_id',
    			'updatedByAttribute' => false
    			],
    		[
    			'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'update_at',
                'value' => new Expression('NOW()'),
    			]
    		];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required', 'when' => function ($model) {
                    return $model->hasCustomTitle() === false;
            }],
            [['active'], 'default', 'value' => function ($value) {
            	return 1;
            }],
            [['active'], 'integer'],
            [['categoriesArray'], 'safe'],
            [['betsString'], 'safe'],
            [['title'], 'string', 'max' => 255]
        ];
    }
    
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHANGE_STATUS] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemBets()
    {
        return $this->hasMany(ItemBet::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBets()
    {
        return $this->hasMany(Bet::className(), ['id' => 'bet_id'])->viaTable('{{%item_bet}}', ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemCategories()
    {
        return $this->hasMany(ItemCategory::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->viaTable('{{%item_category}}', ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Value::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemAttributes()
    {
        return $this->hasMany(Attribute::className(), ['id' => 'attribute_id'])->viaTable('{{%value}}', ['item_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \kirillantv\yii2-swap\models\query\ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \kirillantv\swap\models\query\ItemQuery(get_called_class());
    }
    
    private $_categoriesArray;
    
    public function getCategoriesArray()
    {
    	if ($this->_categoriesArray === null) {
    		$this->_categoriesArray = $this->getCategories()->select('id')->column();
    	}
    	return $this->_categoriesArray;
    }
    
    public function setCategoriesArray($value)
    {
    	$this->_categoriesArray = (array)$value;
    }
    
    public function afterSave($insert, $changedAttributes)
    {
    	$this->updateCategories();
        if ($this->scenario != self::SCENARIO_CHANGE_STATUS) {
            $this->updateBets();
        }
    	parent::afterSave($insert, $changedAttributes);
    }
    
    private $_betsString;
    
    public function getBetsString()
    {
    	if ($this->_betsString === null) {
            $this->_betsString = $this->getBets()->select('name')->column();
    	}
    	return implode(', ', $this->_betsString);
    }
    
    public function setBetsString($value) 
    {
    	$this->_betsString = $this->betsStringHandler($value);
    }
    
    private function betsStringHandler($value) {
    	$values = explode(',', $value);
    	
    	$handledValues = array();
    	foreach ($values as $value)
    	{
            $handledValues[] = trim($value);
    	}
    	
    	return $handledValues;
    }
    
    private function updateBets()
    {
    	$currentBetNames = $this->getBets()->select('name')->column();
    	$newBetNames = $this->_betsString;
    	
    	foreach (array_filter(array_diff($newBetNames, $currentBetNames)) as $betName)
    	{
    		if ($bet = Bet::findOne(['name' => $betName]))
    		{
    			$this->link('bets', $bet);
    		} else {
    			$bet = new Bet();
    			$bet->name = $betName;
    			$bet->save();
    			$this->link('bets', $bet);
    		}
    	}
    	
    	foreach (array_filter(array_diff($currentBetNames, $newBetNames)) as $betName)
    	{
    		if ($bet = Bet::findOne(['name' => $betName]))
    		{
    			$this->unlink('bets', $bet, true);
    		}
    	}
    }
    
    private function updateCategories() 
    {
    	$currentCategoryIds = $this->getCategories()->select('id')->column();
    	$newCategoryIds = $this->getCategoriesArray();
    	
    	foreach (array_filter(array_diff($newCategoryIds, $currentCategoryIds)) as $categoryId) {
    		/** @var Category $category */
    		if ($category = Category::findOne($categoryId)) {
    			$this->link('categories', $category);
    		} 
    	}
    	
    	foreach (array_filter(array_diff($currentCategoryIds, $newCategoryIds)) as $categoryId) {
    		/** @var Category $category */
    		if ($category = Category::findOne($categoryId)) {
    			$this->unlink('categories', $category, true);
    		}
    	}
    }
    
    public function hasCustomTitle()
    {
    	return BasicConfig::getIsCustomTitle();
    }
}
