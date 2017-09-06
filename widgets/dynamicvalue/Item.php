<?php 
/**
 * This file is part of Yii2-DynamicValue project
 * (c) kirillantv <http://github.com/kirillantv/>
 * 
 * For more information read README and LICENSE file 
 */
 
namespace kirillantv\swap\widgets\dynamicvalue;

use yii\base\Object;
use yii\helpers\Html;

/**
 * Class Item renders HTML content for value
 */
class Item extends Object
{
	/**
	 * @var array|string|null the URL for the hyperlink tag.
	 * @see yii\helpers\Url::to()
	 */
	public $link;
	
	/**
	 * @var string label for tag
	 */
	public $label;
	
	/**
	 * @var array the tag options in terms of name-value pairs
	 */
	public $options;
	
	/**
	 * Initialize Item object
	 */
	public function init()
	{
		parent::init();
	}
	
	/**
	 * Renders HTML content for value.
	 * If link is defined it renders Hyperlink tag, if not it will generate tag, that you define in item config
	 * 
	 * @return string HTML
	 */
	public function renderItem()
	{
		if ($this->hasLink())
		{
			return $this->renderLink();
		}
		else 
		{
			return $this->renderTag();
		}
	}
	
	/**
	 * Checks whether item config has link
	 * 
	 * @return boolean whether item config has link
	 */
	public function hasLink()
	{
		return $this->link != null ? true : false;
	}
	
	/**
	 * Returns HTML tag. If tag is not defined in config it will return <div>
	 * 
	 * @property string HTML tag
	 * @return string HTML tag
	 */
	public function getTag()
	{
		if ($this->tag == null)
		{
			$this->tag = 'div';
		}
		
		return $this->tag;
	}
	
	/**
	 * Sets HTML tag
	 */
	public function setTag($value)
	{
		$this->tag = $value;
	}
	
	/**
	 * Returns HTML string of link
	 * 
	 * @return string HTML with <a> tag
	 * @see yii\helpers\Html
	 */
	protected function renderLink()
	{
		return Html::a($this->label, $this->link, $this->options);
	}
	
	/**
	 * Returns HTML string
	 * 
	 * @return string HTML
	 * @see yii\helpers\Html
	 */
	protected function renderTag()
	{
		return Html::tag($this->tag, $this->label, $this->options);
	}
}