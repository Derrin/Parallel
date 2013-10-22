<?php

class Head extends GearItem{
    private $transmogitem;
    
    public function __construct($id, $name, $icon, $quality, $itemlevel, $upgrade, $maxupgrade, $gems, $reforge, $set, $suffix,$transmogitem) {
        parent::__construct($id, $name, $icon, $quality, $itemlevel, $upgrade, $maxupgrade, $gems, $reforge, $set, $suffix);
        $this->transmogitem = $transmogitem;
    }
    public function getTransmogItem(){
        return $this->transmogitem;
    }
}

?>
