<?php

namespace kirillantv\swap\models\management\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use kirillantv\swap\models\ItemBet;

/**
 * ItemBetSearch represents the model behind the search form about `common\models\ItemBet`.
 */
class ItemBetSearch extends ItemBet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'bet_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ItemBet::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'item_id' => $this->item_id,
            'bet_id' => $this->bet_id,
        ]);

        return $dataProvider;
    }
}
