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
	const SCENARIO_UPDATE = 'update';
	
	const PATH_PREFIX = '/';
	
	public $imageFiles;
	
	public $item_id;
	
	public function rules()
	{
		return [
			[['imageFiles'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'uploadRequired' => 'Please, upload image', 'maxFiles' => 4,'except' => UploadForm::SCENARIO_UPDATE],
			[['imageFiles'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'uploadRequired' => 'Please, upload image', 'maxFiles' => 4,'on' => UploadForm::SCENARIO_UPDATE],
			];
	}
	
	public function upload()
	{
        if ($this->validate()) {
        	if (!is_dir($this->uploadPath))
        	{
        		mkdir($this->uploadPath);
        	}
        	
        	foreach ($this->imageFiles as $image)
        	{
        		$absoluteName = $this->uploadPath . uniqid() . '.' . $image->extension;
                if ($image->saveAs($absoluteName))
                {
            	    $this->savePath($absoluteName);
                }
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
