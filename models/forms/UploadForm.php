<?php
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\models\forms;

use kirillantv\swap\models\SwapImage;

class UploadForm extends \yii\base\Model
{
	const PATH_PREFIX = '/';
	
	public $imageFile;
	
	public $item_id;
	
	public function rules()
	{
		return [
			[['imageFile'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
			];
	}
	
	public function upload()
	{
        if ($this->validate()) {
        	if (!is_dir($this->uploadPath))
        	{
        		mkdir($this->uploadPath);
        	}
        	$absoluteName = $this->uploadPath . uniqid() . '.' . $this->imageFile->extension;
            if ($this->imageFile->saveAs($absoluteName))
            {
            	$this->savePath($absoluteName);
            }
            return true;
        } else {
            return false;
        }
	}
	
	public function savePath($absoluteName)
	{
		$model = new SwapImage();
		$model->path = self::PATH_PREFIX . $absoluteName;
		$model->item_id = $this->item_id;
		$model->save(false);
	}
	
	public function getUploadPath()
	{
		if ($this->uploadPath == null)
		{
			$this->uploadPath = 'uploads/';
		}
		return $this->uploadPath;
	}
	
	public function setUploadPath($value)
	{
		$this->uploadPath = $value;
	}
}
