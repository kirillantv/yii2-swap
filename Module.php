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
	public $enableWishmaker = true;
	
	public function init() 
	{
		parent::init();
		
		$this->modules = [
			'message' => [
				'class' => 'kirillantv\swap\modules\message\Module'
				],
			'wishmaker' => [
				'class' => 'kirillantv\wishmaker\Module'
				]
			];
		/*if ($this->enableWishmaker == true)
		{
			$this->modules['wishmaker'] = 
				[
					'class' => 'kirillantv\wishmaker\Module'
					];	
		}*/
	}
}
?>