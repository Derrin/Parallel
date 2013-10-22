<?php
class NullGearItem Extends Item{
    
	public function __construct($id=0,$name="",$icon="",$quality=0,$itemlevel=0)
    {
        $this->itemid = $id;
        $this->itemname = $name;
        $this->icon = $icon;
        $this->quality = $quality;
        $this->itemlevel = $itemlevel;
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