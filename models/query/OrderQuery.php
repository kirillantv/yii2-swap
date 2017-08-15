<?php

namespace kirillantv\swap\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Order]].
 *
 * @see \common\models\Order
 */
class OrderQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status' => 1]);
    }
    
    public function archive()
    {
        return $this->andWhere(['status' => 0]);
    }
    
    public function forUser($id)
    {
    	return $this->andWhere(['catcher_id' => $id])->orWhere(['item.author_id' => $id]);
    }

    /**
     * @inheritdoc
     * @return \common\models\Order[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\Order|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
