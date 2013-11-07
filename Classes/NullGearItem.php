<?php
class NullGearItem Extends GearItem{
    
    public function __construct($id=0){
        $this->itemid = $id;
    }
    public function getArmouryItem(){
        return null;    
    }
    public function getTransmog(){
        return null; 
    }
    public function buildWowHeadToolTip($level=90){
            $tooltip  = $this->buildParamsTooltipHook($level);
            return $tooltip;
    }
    public function buildParamsTooltipHook($level=90){
            $tooltip = "No item present";
            return $tooltip;
    }
}
?>