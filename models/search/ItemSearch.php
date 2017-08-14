<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
namespace kirillantv\swap\models\search;

use Yii;
use yii\base\Model;

class ItemSearch extends Model
{
	public $search;
	
	public $category;
	
	public $for;
	
	public $s;
	
	public function rules()
	{
		return [
				[['search'], 'required'],
				[['category', 'for', 's'], 'safe'],
			];
	}
	
	public function scenarios()
    {
        return Model::scenarios();
    }
    
	public function search($model)
	{
		return $model = $model->filterWhere(['category_id' => $this->category])
		->andFilterWhere(['value.attribute_id' => $this->for])->andFilterWhere(['like', 'value.value_string', $this->s]);
	}
	
	public function loadSearchParams($params = '')
	{
		if (is_array($params) && $params['search'] == 'true')
		{
			$this->search = $params['search'];
			$this->category = $params['category'];
			$this->for = $params['for'];
			$this->s = $params['s'];
			
			return true;
		}
		
		return false;
	}
}