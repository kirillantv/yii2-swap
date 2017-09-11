<?php

namespace kirillantv\swap\models\query;

use kirillantv\swap\models\Category;

/**
 * This is the ActiveQuery class for [[\kirillantv\swap\models\Item]].
 *
 * @see \kirillantv\swap\models\Item
 */
class ItemQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['active' => 1]);
    }
    
    public function archive()
    {
        return $this->andWhere(['active' => 0]);
    }
    
    public function forUser($id)
    {
    	return $this->andWhere(['author_id' => $id]);
    }
    
    public function forCategory($id)
    {
    	$ids = [$id];
        $childrenIds = [$id];
        while ($childrenIds = Category::find()->select('id')->andWhere(['parent_id' => $childrenIds])->column()) {
            $ids = array_merge($ids, $childrenIds);
        }
        return $this->andWhere(['category_id' => array_unique($ids)]);
    }
	
	public function forBet($id)
	{
		$ids = [$id];
		return $this->andWhere(['bet_id' => $ids]);
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
