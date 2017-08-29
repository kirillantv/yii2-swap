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
			];
	}
}
?>