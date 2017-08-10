<?php
namespace kirillantv\swap\models;

use Yii;
use kirillantv\swap\models\Attribute;
use kirillantv\swap\models\Value;

class BasicConfig extends \yii\db\ActiveRecord {
	
	public static function tableName()
    {
        return '{{%basic_config}}';
    }
	
	public static function getItemAttributesArray($params = array())
	{
		return Attribute::find()->select(['slug', 'id'])->indexBy('id')->column();
	}
	
	public static function getTitleFormula()
	{
		return self::findOne(['name' => 'customTitleFormula'])->value;
	}
	
	public static function getIsCustomTitle()
	{
		return self::findOne(['name' => 'isCustomTitle'])->value == 1 ? true : false;
	}
}