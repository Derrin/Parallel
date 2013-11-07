<?php

class ArmouryItem {
    private $id;
    private $displayid;
    private $name;
    private $icon;
    private $quality;
    private $itemlevel;
    private $armourtype;// item subclass = armourtype: plate = 4 leather = 2 mail=3 cloth =1
    private $slot; // item slot
    private $sockets;
    private $socketbonus;
    
    public function __construct($id,$displayid,$name,$icon,$quality,$itemlevel,$armourtype,$slot,$sockets,$socketbonus) {
        $this->id = $id;
        $this->displayid = $displayid;
        $this->name = $name;
        $this->icon = $icon;
        $this->quality = $quality;
        $this->itemlevel = $itemlevel;
        $this->armourtype = $armourtype;
        if($slot == 26) $slot=15;
        $this->slot = $slot;
        $this->sockets = $sockets;
        $this->socketbonus = $socketbonus;
    }
    public function getId(){
        return $this->id;
    }
    public function getDisplayId(){
        return $this->displayid;
    }
    public function getName(){
        return $this->name;
    }
    public function getIcon(){
        return $this->icon;
    }
    public function getQuality(){
        return $this->quality;
    }
    public function getQualityName(){
        $qal="None";
        switch($this->slot)
        {
            case 0:$qal ="Poor";break;
            case 1:$qal ="Common";break;
            case 2:$qal ="Uncommon";break;
            case 3:$qal ="Rare";break;
            case 4:$qal ="Epic";break;
            case 5:$qal ="Legendary";break;
            case 6:$qal ="Artifact";break;
            case 7:$qal ="Heirloom";break;  
        }
        return $qal;
    }
    public function getItemLevel(){
        return $this->itemlevel;
    }
    public function getArmourType(){
        return $this->armourtype;
    }
    public function getSlot(){
        return $this->slot;
    }
    public function getSlotName(){
        $name='None';
        switch($this->slot)
        {
            case 0:$name="None";break;
            case 1:$name="Head";break;
            case 2:$name="Neck";break;
            case 3:$name="Shoulder";break;
            case 4:$name="Shirt";break;
            case 5:$name="Chest";break;
            case 6:$name="Waist";break;
            case 7:$name="Legs";break;
            case 8:$name="Feet";break;
            case 9:$name="Wrist";break;
            case 10:$name="Hands";break;
            case 11:$name="Finger";break;
            case 12:$name="Trinket";break;
            case 13:$name="One-Hand";break;
            case 14:$name="Shield";break;
            case 15:$name="Ranged";break;
            case 16:$name="Cloak";break;
            case 17:$name="Two-Hand";break;
            case 18:$name="Bag";break;
            case 19:$name="Tabard";break;
            case 20:$name="Robe";break;
            case 21:$name="Main Hand";break;
            case 22:$name="Off Hand";break;
            case 23:$name="Held In Off-hand";break;
            case 24:$name="Ammo";break;
            case 25:$name="Thrown";break;
            case 26:$name="Ranged Right";break;
            case 28:$name="Relic";break; 
        }
        return $name;
    }
}
?>