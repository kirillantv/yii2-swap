<?php 
/**
 * This file is part of Yii2-DynamicValue project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\widgets\dynamicvalue;

use Yii;
use yii\helpers\Html;
use yii\base\Widget;

/**
 * The DynamicValue widgets is used to display dynamic content depending on value of input data
 * 
 * It provides `link` property that tranform <div> tag to <a> tag and let you to route user to action
 * 
 * Basic usage:
 * 
 * ```php
 * <?= DynamicValue::widget([
 * 'data' => $model,
 * 'column' => 'status',
 * 'items' => [
 *     [
 *         'value' => 1,
 *         'label' => 'Disable order',
 *         'link' => ['order/disable', 'id' => $model->id],
 *         'options' => ['class' => 'btn btn-danger btn-block']
 * ],
 *     [
 *         'value' => 0,
 *         'tag' => 'span',
 *         'label' => 'Is done',
 *         'options' => ['class' => 'btn btn-success btn-block']
 * ]
 * ]
 * ]);
 * ```
 * 
 * By default, widget provides content for 'status' column, such as, active = 1, archive = 0 and error = -1 status.
 */

class DynamicValue extends Widget
{
	const STATUS_ACTIVE = 1;
	
	const STATUS_ARCHIVE = 0;
	
	const STATUS_ERROR = -1;
	
	/**
	 * @var \yii\base\Model data model for value. Required property
	 */ 
	public $data;
	
	/**
	 * @var string name of column with value
	 */
	public $column;
	
	public $items = null;
	
	/**
     * @inheritdoc
     */
	public function init()
	{
		parent::init();
		
		$this->initItems();
	}
	
	/**
     * @inheritdoc
     */	
	public function run()
	{
		$data = $this->data;
		$column = $this->column;
		
		//Search for value config
		foreach ($this->items as $i => $item)
		{
			if ($i == $data->$column)
			{
				return $this->renderElement($item);
			}
		}
	}
	
	/**
	 * Initialize items
	 * 
	 * Index items array by value and replace array of default items
	 */
	protected function initItems()
	{
		$initItems = null;
		
		if ($this->items != null)
		{
			foreach ($this->items as $item)
			{
				if (isset($item['value']))
				{
					$i = $item['value'];
					unset($item['value']);
					$initItems[$i] = $item;
				}
				else 
				{
					$initItems = $this->items;	
				}
			}
			
			$this->items = array_replace($this->defaults, $initItems);
		}
		else 
		{
			$this->items = $this->defaults;
		}
	}
	/**
	 * @param array $item array of config items 
	 * @return string rendering content
	 */
	public function renderElement($item)
	{
		/*  @var kirillantv\dynamicvalue\Item */
		$item = new Item($item);
		return $item->renderItem();
	}
	
	/**
	 * Array of default items config getter
	 * 
	 * @return array default items config
	 */
	protected function getDefaults()
	{
		return [
			self::STATUS_ACTIVE => [
			        'label' => 'Active',
			        'options' => [
			    	    'class' => 'btn btn-success btn-block'
			    	    ],
			        ],
			self::STATUS_ARCHIVE => [
			        'label' => 'Archive',
			        'options' => [
			    	    'class' => 'btn btn-info btn-block'
			    	    ],			    		
			        ],
			self::STATUS_ERROR => [
			        'label' => 'Error',
			        'options' => [
			    	    'class' => 'btn btn-danger btn-block'
			    	    ],			    	
			        ]
			];
	}
}