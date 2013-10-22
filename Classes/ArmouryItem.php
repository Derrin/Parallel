<?php

class ArmouryItem {
    private $id;
    private $displayid;
    private $name;
    private $icon;
    private $quality;
    private $itemlevel;
    private $armourtype;// item subclass = armourtype: plate = 4 leather = 2 mail=3 cloth =1
    private $sockets;
    private $socketbonus;
    
    public function __construct($id,$displayid,$name,$icon,$quality,$itemlevel,$armourtype,$sockets,$socketbonus) {
        $this->id = $id;
        $this->displayid = $displayid;
        $this->name = $name;
        $this->icon = $icon;
        $this->quality = $quality;
        $this->itemlevel = $itemlevel;
        $this->armourtype = $armourtype;
        $this->sockets = $sockets;
        $this->socketbonus = $socketbonus;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->name;
    }
}
    
?>