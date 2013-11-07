<?php
class GearItem{
    private $armouryitem;
    private $itemid;
    
    private $upgrade;
    private $maxupgrade;
    private $gems;
    private $reforge;
    private $set;
    //suffix for random items!
    private $suffix;
    private $transmog;
    private $transmogLL;//used for lazy loading
    private $enchant;
    private $extraSocket;
    private $tinker;
    private $weaponinfo;
    
    public function __construct($id) {
        $this->itemid = $id;
    }
    
//ArmouryItem Interface
    public function getArmouryItem(){
        if(is_null($this->armouryitem)){
            //fetch + assign
            $builder = new ItemBuilder();
            $this->armouryitem = $builder->getItem($this->itemid); 
        }
        return $this->armouryitem;    
    }
    public function getDisplayId(){
        return $this->getArmouryItem()->getDisplayId();
    }
    public function getItemName(){
        return $this->getArmouryItem()->getName();
    }
    public function getIconLink(){
        return Util::getIcon36($this->getArmouryItem()->getIcon());
    }
    public function getQuality(){
        return $this->getArmouryItem()->getQuality();
    }
    public function getItemLevel(){
        return $this->getArmouryItem()->getItemLevel();
    }
    public function getArmourType(){
        return $this->getArmouryItem()->getArmourType();
    }  
    public function getSlot(){
        return $this->getArmouryItem()->getSlot();
    }

//getters and setters
    public function getItemId(){
        return $this->itemid;
    }
    public function getUpgrade(){
        return $this->upgrade;
    }
    public function setUpgrade($upg){
        $this->upgrade = $upg;
    }
    public function getMaxUpgrade(){
        return $this->maxupgrade;
    }
    public function setMaxUpgrade($max){
        $this->maxupgrade = $max;
    }
    public function getGems(){
        return $this->gems;
    }
    public function setGems($gems){
        $this->gems = $gems;
    }
    public function getReforge(){
        return $this->reforge;
    }
    public function setReforge($ref){
        $this->reforge = $ref;
    }
    public function getSet(){
        return $this->set;
    }
    public function setSet($set){
        $this->set = $set;
    }
    public function getSuffix(){
        return $this->suffix;
    }
    public function setSuffix($suffix){
        $this->suffix = $suffix;
    }
    public function getTransmog(){
        //lazy load transmog
        if(isset($this->transmogLL) && is_null($this->transmog)){
            //fetch + assign
            //TODO getinstance with builders?
            $builder = new ItemBuilder();
            $this->transmog = $builder->getItem($this->transmogLL); 
        }
        return $this->transmog;  
    }
    public function setTransmog($tmog){
        $this->transmogLL = $tmog;
    }
    public function getEnchant(){
        return $this->enchant;
    }
    public function setEnchant($ench){
        $this->enchant = $ench;
    }
    public function getExtraSocket(){
        return $this->extraSocket;
    }
    public function setExtraSocket($sock){
       $this->extraSocket = $sock;
    }
    public function getTinker(){
       return $this->tinker;
    }
    public function setTinker($tink){
        $this->tinker = $tink;
    }
    public function getWeaponInfo(){
        return $this->weaponinfo;
    }
    public function setWeaponInfo($weap){
        $this->weaponinfo = $weap;
    }
    
    
    public function buildWowHeadToolTip($level=90){
        //$level -> character itemlevel for hairlooms
        $tooltip  = '<a href="http://www.wowhead.com/item=';
        $tooltip .= $this->itemid.'"';
        $tooltip .= 'class="q'.$this->getQuality().'"';
        $tooltip .= 'rel="';
        $tooltip .= $this->buildParamsTooltipHook($level);
        $tooltip .= '" target="_blank">';
        $tooltip .= '<img src="'.$this->getIconLink().'">';
        $tooltip .= $this->getItemName();
        $tooltip .= '</a>';
        return $tooltip;
    }
    protected function buildParamsTooltipHook($level){
        //TODO check for null values;
        $tooltip = 'lvl=' + $level;
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
            //TODO REWRITE
		if($tmItem = $this->transmogLL){
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
