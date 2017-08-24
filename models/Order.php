<?php

namespace kirillantv\swap\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use kirillantv\swap\models\Item;
/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $catcher_id
 * @property integer $status
 *
 * @property User $catcher
 * @property Item $item
 * @property OrderBet[] $orderBets
 * @property Bet[] $bets
 */
class Order extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }
    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }
    
    public function behaviors()
    {
    	return [
    		[
    			'class' => BlameableBehavior::classname(),
    			'createdByAttribute' => 'catcher_id',
    			'updatedByAttribute' => false
    			]
    		];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id'], 'required'],
            [['item_id', 'status'], 'integer'],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item_id' => 'id']],
            [['betsArray'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'catcher_id' => 'Catcher ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatcher()
    {
        return $this->hasOne(Yii::$app->user->identityClass, ['id' => 'catcher_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderBets()
    {
        return $this->hasMany(OrderBet::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBets()
    {
        return $this->hasMany(Bet::className(), ['id' => 'bet_id'])->viaTable('{{%order_bet}}', ['order_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \kirillantv\swap\models\query\OrderQuery(get_called_class());
    }
    
    public function afterSave($insert, $changedAttributes)
    {
    	$this->updateBets();
        $this->changeItemStatus();
    	parent::afterSave($insert, $changedAttributes);
    }
    
    private $_betsArray;
    
    public function getBetsArray()
    {
    	if ($this->_betsArray === null) {
    		$this->_betsArray = $this->getBets()->select('id')->column();
    	}
    	
    	return $this->_betsArray;
    }
    
    public function setBetsArray($value)
    {
    	$this->_betsArray = (array)$value;
    }
    
    private function updateBets() 
    {
    	$currentBetIds = $this->getBets()->select('id')->column();
    	$newBetIds = $this->getBetsArray();
    	
    	foreach (array_filter(array_diff($newBetIds, $currentBetIds)) as $betId) {
    		/** @var Category $category */
    		if ($bet = Bet::findOne($betId)) {
    			$this->link('bets', $bet);
    		} 
    	}
    	
    	foreach (array_filter(array_diff($currentBetIds, $newBetIds)) as $betId) {
    		/** @var Category $category */
    		if ($bet = Bet::findOne($betId)) {
    			$this->unlink('bets', $bet, true);
    		}
    	}
    }
    
    private function changeItemStatus() {
        
        if ($this->scenario == self::SCENARIO_CREATE) {
            $item = Item::findOne($this->item_id);
            $item->scenario = Item::SCENARIO_CHANGE_STATUS;
            $item->active = 0;
            $item->save();
        }
        
    }
}
