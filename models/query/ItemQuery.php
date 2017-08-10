<?php

namespace kirillantv\swap\models\query;

use kirillantv\swap\models\Category;

/**
 * This is the ActiveQuery class for [[\common\models\Item]].
 *
 * @see \common\models\Item
 */
class ItemQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['active' => 1]);
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
