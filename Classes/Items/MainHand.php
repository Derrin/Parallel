<?php
class MainHand extends GearItem implements Transmogable {
    private $transmogitem;
	private $transmogable = true;
    private $enchant;
	private $extraSocket;//legendary
    private $weaponinfo;
	
	public function __construct($id, $name, $icon, $quality, $itemlevel, $upgrade, $maxupgrade, $gems, $reforge, $set, $suffix, $enchant, $transmogitem) {
        parent::__construct($id, $name, $icon, $quality, $itemlevel, $upgrade, $maxupgrade, $gems, $reforge, $set, $suffix, $enchant);
        $this->transmogitem = $transmogitem;
    }
    public function getTransmogItem(){
        return $this->transmogitem;
    }
}
?>