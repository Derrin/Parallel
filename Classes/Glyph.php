<?php
include_once '/Util.php';

class Glyph{
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
        return Util::getIcon18($this->icon);
    }
}
?>
