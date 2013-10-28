<?php
class GearItem extends Item{
    private $upgrade;
    private $maxupgrade;
    private $gems = array();
    private $reforge;
    private $set = array();
    //suffix for random items!
    private $suffix;
	private $enchant;
	
	private $transmogable = false; //TODO - DDD: need to add support for this across child classes.
    
    public function __construct($id, $name, $icon, $quality, $itemlevel, $upgrade,$maxupgrade, $gems, $reforge, $set, $suffix, $enchant) {
        parent::__construct($id, $name, $icon, $quality, $itemlevel);
        $this->upgrade = $upgrade;
        $this->maxupgrade = $maxupgrade;
        $this->gems = $gems;
        $this->reforge = $reforge;
        $this->set = $set;
        $this->suffix = $suffix;
		$this->enchant = $enchant;
    }
    protected function buildParamsTooltipHook($level){
        //TODO check for null values;
        $tooltip = parent::buildParamsTooltipHook($level);
        if($this->upgrade){
			$tooltip .= '&upgd='.$this->upgrade;
		}
		if($this->gems){
			$gemStr = '';
			foreach($this->gems as $gem) $gemStr .= $gem.':';
			$tooltip .= '&gems=' . trim($gemStr,':');
		}
        if($this->set){
			$pcsStr = '';
			foreach($this->set as $setPiece) $pcsStr .= $setPiece.':';
			$tooltip .= '&pcs=' . trim($pcsStr,':');
		}
        if($this->reforge){
			$tooltip .='&forg='.$this->reforge;
		}
		if($this->suffix){
			$tooltip .='&rand='.$this->suffix;
		}
		if($this->enchant){
			$tooltip .='&ench='.$this->enchant;
		}
        return $tooltip;
    }
	
	
	
	public function buildWowHeadToolTipTransmog($level=90){
		if($tmItem = $this->getTransmogItem()){
			$itemURL = "http://eu.battle.net/api/wow/item/" . $tmItem;
			try{
				$jsonConnector = new JsonConnector();
				$json = $jsonConnector->request($itemURL);
				$rawItem = json_decode($json);
				$itemObj = new GearItem(
					$rawItem->id,
					$rawItem->name,
					$rawItem->icon,
					$rawItem->quality,
					$rawItem->itemLevel,
					null,
					null,
					null,
					null,
					null,
					null,
					null
				);
				//var_dump($itemObj);die;
				return $itemObj->buildWowHeadToolTip($level);
			} catch(Exception $ex){}
		}
		return;
		
	}
	
}

?>
