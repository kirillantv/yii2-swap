<?php 
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\helpers;

use kirillantv\swap\models\Attribute;
use kirillantv\swap\models\BasicConfig;
/**
 * Title helper
 * 
 * Generate item title with attributes if custom title is enable
 * 
 * In future plans: 
 * 1. To make this code as separate extension helper
 * 2. Add ability to generate title using dirrent item data (e.g. Category, Username and etc.)
 * 3. To make code more human and flexible for different solutions
 * 
 */
class Title {
	
	// attribute_name order
	public static function generateCustomTitle($model) 
	{
		$customTitle = self::getTitleFormula();
		
		$values = $model->getValues()->with('itemAttribute')
        ->indexBy('attribute_id')
        ->all();
        
		$titleAttributes = self::getItemAttributesArray();
		
		foreach ($titleAttributes as $key => $attribute)
		{
			if (stristr($customTitle, '%'.$attribute.'%'))
			{
				$customTitle = str_replace('%'.$attribute.'%', $values[$key]->value_string, $customTitle);
			}
			else {
				continue;
			}
		}
		
		return $customTitle;
	}
	
	public static function titleAttributes()
	{
		$titleAttributes = [
			];
		foreach (self::getItemAttributesArray() as $attribute)
		{
			$titleAttributes[] = $attribute;
		}
		return $titleAttributes;
	}
	
	public static function getItemAttributesArray($params = array())
	{
		return Attribute::find()->select(['slug', 'id'])->indexBy('id')->column();
	}
	public static function getTitleFormula()
	{
		return BasicConfig::findOne(['name' => 'customTitleFormula'])->value;
	}
}