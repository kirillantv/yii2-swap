<?php 
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */

namespace kirillantv\swap;

use Yii;

class Module extends \yii\base\Module
{
	public function init() 
	{
		parent::init();
		$this->registerTranslations();
		
		$this->modules = [
			'message' => [
				'class' => 'kirillantv\swap\modules\message\Module'
				],
			];
	}
	
	public function registerTranslations()
	{
	    Yii::$app->i18n->translations['swap'] = [
	        'class' => 'yii\i18n\PhpMessageSource',
	        'sourceLanguage' => 'en-US',
	        'basePath' => '@vendor/kirillantv/yii2-swap/messages',
        ];
	}
}
?>