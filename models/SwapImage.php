<?php 
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\models;

/**
 * @property $imageFile string Path to file
 * @property $id id of image
 * @property $path Path to file
 * @pripery $item_id Item
 */
class SwapImage extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return '{{%swap_image}}';
	}
	
	public function rules()
	{
		return [
			[['path'], 'string'],
			[['item_id'], 'integer']
			];
	}
	
	public function getItem()
	{
		return $this->hasOne(Item::className(), ['id' => 'item_id']);
	}
}