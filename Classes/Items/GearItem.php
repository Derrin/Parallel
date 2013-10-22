<?php

class GearItem extends Item{
    private $upgrade;
    private $maxupgrade;
    private $gems = array();
    private $reforge;
    private $set = array();
    //suffix for random items!
    private $suffix;
    
    public function __construct($id, $name, $icon, $quality, $itemlevel,$upgrade,$maxupgrade,$gems,$reforge,$set,$suffix) {
        parent::__construct($id, $name, $icon, $quality, $itemlevel);
        $this->upgrade = $upgrade;
        $this->maxupgrade = $maxupgrade;
        $this->gems = $gems;
        $this->reforge = $reforge;
        $this->set = $set;
        $this->suffix = $suffix;
    }
    protected function buildParamsTooltipHook($level){
        //TODO check for null values;
        //"gems=76667&amp"
        $tooltip = parent::buildParamsTooltipHook($level);
        $tooltip .= '&upgd='.$this->upgrade;
        $tooltip .= '&gems=';
        for($i=0;$i<count($this->gems);$i++){
            $tooltip .= $this->gems[$i];
            if($i+1 != count($this->gems))
                $tooltip .=':';
        }
        $tooltip .= '&set=';
        for($i=0;$i<count($this->set);$i++){
            $tooltip .= $this->set[$i];
            if($i+1 != count($this->set))
                $tooltip .=':';
        }
        $tooltip .='&forg='.$this->reforge;
        return $tooltip;
    }
}

?>
