<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\modules\message\models\query;

use Yii;
use kirillantv\swap\modules\message\models\Message;

class MessageQuery extends \yii\db\ActiveQuery
{
	public function inbox()
	{
		$userId = Yii::$app->user->identity->id;
		return $this->with(['sender', 'item'])->from(['new_message' => Message::find()->orWhere(['from' => $userId])
			->orWhere(['to' => $userId])->orderBy(['created_at' => SORT_DESC])])
			->orderBy(['created_at' => SORT_DESC])
			->groupBy(['from', 'item_id']);
	}
	
	public function conversation($hash, $item, $from, $to)
	{
		$secureQuery = $this->secureQuery($hash, $item, $from, $to);
		
		if ($secureQuery)
		{
			return $this->with(['item'])->where([
				'item_id' => $item,
				'from' => [$from, $to],
				'to' => [$from, $to]
				]);
		}
		else
		{
			return false;
		}
	}
	
	private function secureQuery($hash, $item, $from, $to)
	{
		$query = Message::find()->where([
			'hash' => $hash,
			'item_id' => $item,
			'from' => $from,
			'to' => $to
			])->count();
		
		if ($query == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	/**
     * @inheritdoc
     * @return \common\models\Item[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Item|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
}