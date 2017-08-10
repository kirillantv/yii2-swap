<?php
namespace kirillantv\swap\models\management;

use Yii;
use yii\base\Model;
use kirillantv\swap\models\BasicConfig;

class BasicConfiguration extends Model {
	
	public function rules()
    {
        return [
            [['isCustomTitle'], 'safe'],
            [['customTitleFormula'], 'safe']
        ];
    }
    
    private $_isCustomTitle;
    
    public function getIsCustomTitle() 
    {
    	
    	if($this->_isCustomTitle === null)
    	{
    		$this->_isCustomTitle = BasicConfig::findOne(['name' => 'isCustomTitle'])->value;
    	}
    	
    	return $this->_isCustomTitle;
    	
    }
    
    public function setIsCustomTitle($value)
    {
    	$this->_isCustomTitle = $value;
    }
    
    public function updateConfigs() 
    {
    	$isCustomTitle = BasicConfig::findOne(['name' => 'isCustomTitle']);
    	$isCustomTitle->value = $this->isCustomTitle;
    	$isCustomTitle->update();
    	$customTitleFormula = BasicConfig::findOne(['name' => 'customTitleFormula']);
    	$customTitleFormula->value = $this->customTitleFormula;
    	$customTitleFormula->update();
    	
    }
    
    private $_customTitleFormula;
    
    public function getCustomTitleFormula()
    {
    	if($this->_customTitleFormula === null)
    	{
    		$this->_customTitleFormula = BasicConfig::findOne(['name' => 'customTitleFormula'])->value;
    	}
    	
    	return $this->_customTitleFormula;
    }
    
    public function setCustomTitleFormula($value)
    {
    	$this->_customTitleFormula = $value;
    }
}
?>