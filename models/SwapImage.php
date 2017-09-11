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
	public $imageFile;
	
	public function rules()
	{
		return [
			[['imageFile'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, gif']
			];		
	}
	
	public function upload()
	{
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
	}
}