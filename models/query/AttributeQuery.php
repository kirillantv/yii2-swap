<?php

namespace kirillantv\swap\models\query;


/**
 * This is the ActiveQuery class for [[\common\models\Item]].
 *
 * @see \common\models\Item
 */
class AttributeQuery extends \yii\db\ActiveQuery
{
	public function searchable()
	{
		return $this->andWhere(['searchable' => 1]);
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