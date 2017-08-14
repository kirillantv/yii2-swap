<?php
namespace kirillantv\swap\models;

use Yii;
use kirillantv\swap\models\Attribute;

class BasicConfig extends \yii\db\ActiveRecord {
	
	public static function tableName()
    {
        return '{{%basic_config}}';
    }
	
	public static function getIsCustomTitle()
	{
		return self::findOne(['name' => 'isCustomTitle'])->value == 1 ? true : false;
	}
	
	public static function getItemAttributesArray($params = array())
	{
		return Attribute::find()->select(['slug', 'id'])->indexBy('id')->column();
	}
}