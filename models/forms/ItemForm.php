<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\models\forms;

class ItemForm extends \yii\base\Model
{
	const SCENARIO_VALIDATE_TITLE = 'validate_title';
	const SCENARIO_VALIDATE_VALUES = 'validate_values';
	const SCENARIO_VALIDATE_CATEGORIES = 'validate_categories';
	const SCENARIO_VALIDATE_BETS = 'validate_bets';
	const SCENARIO_CREATE = 'create';
	
	public function rules()
	{
		return [
			[['title'], 'required', 'on' => self::SCENARIO_VALIDATE_TITLE],
			[['values'], 'required', 'on' => self::SCENARIO_VALIDATE_VALUES],
			[['categories'], 'required', 'on' => self::SCENARIO_VALIDATE_CATEGORIES],
			[['bets'], 'required', 'on' => self::SCENARIO_VALIDATE_BETS]
			];
	}
}