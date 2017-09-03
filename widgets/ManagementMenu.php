<?php 
/**
 * This file is part of Yii2-Swap project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\widgets;
 
use yii\widgets\Menu;
use yii\base\Widget;

class ManagementMenu extends Widget
{
	public $items;
	
	public function init()
	{
		parent::init();
		
		$this->items = [
				['label' => 'Config', 'url' => ['management/basic-configuration/index']],
				['label' => 'Items', 'url' => ['management/items/index']],
				['label' => 'Attributes', 'url' => ['management/attributes/index']],
				['label' => 'Categories', 'url' => ['management/categories/index']],
				['label' => 'Bets', 'url' => ['management/bets/index']],
				['label' => 'Orders', 'url' => ['management/orders/index']],
				['label' => 'Attribute values', 'url' => ['management/values/index']],
			];
	}
	
	public function run()
	{
		return Menu::widget([
			'options' => [
				'class' => 'nav nav-pills nav-stacked'
				],
			'items' => $this->items
			]);
	}
}