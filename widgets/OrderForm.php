<?php 
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\widgets;

use yii\widgets\Menu;
use Yii;
use yii\base\Widget;

class OrderForm extends Widget
{
	public $activeMessage;
	
	public $passiveMessage;
	
	public $item;
	
	public $order;
	
	public function init()
	{
		parent::init();
	}
	
	public function run()
	{
		return $this->render('orderform', [
			'activeMessage' => $this->activeMessage,
			'passiveMessage' => $this->passiveMessage,
			'item' => $this->item,
			'order' => $this->order
			]);
	}
}