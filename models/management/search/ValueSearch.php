<?php

namespace kirillantv\swap\models\management\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use kirillantv\swap\models\Value;

/**
 * ValueSearch represents the model behind the search form about `common\models\Value`.
 */
class ValueSearch extends Value
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'attribute_id', 'value_number'], 'integer'],
            [['value_string'], 'safe'],
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
        $query = Value::find();

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
            'attribute_id' => $this->attribute_id,
            'value_number' => $this->value_number,
        ]);

        $query->andFilterWhere(['like', 'value_string', $this->value_string]);

        return $dataProvider;
    }
}
