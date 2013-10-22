<?php

class Talent {
    private $id;
    private $name;
    private $icon;
        
    public function __construct($id=0,$name="N/A",$icon="inv_misc_questionmark") {
        $this->id = $id;
        $this->name = $name;
        $this->icon = $icon;   
    }
    
    public function getName(){
        return $this->name;
    }
    public function getId(){
        return $this->id;
    }
    public function getIconLink(){
        //http://media.blizzard.com/wow/icons/36/ gets them bigger
        //56
        return "http://media.blizzard.com/wow/icons/18/".$this->icon.".jpg";
    }
}
?>
