<?php
include_once('/Util.php');

class Spec {
    private $activespec;
    private $specname;
    private $icon;
    private $role;
    private $talents = array();
    private $majorglyphs = array();
    private $minorglyphs = array();
    
    //set talents and set major and minor glyphs?
    public function __construct($specname= "N/A",$role="N/A",$icon="inv_misc_questionmark",$activespec= false) {
        $this->specname = $specname;
        $this->role = $role;
        $this->icon = $icon;
        $this->activespec = $activespec;
    }

    public function isActiveSpec() {
        return $this->activespec;
    }
    public function getSpecName(){
        return $this->specname;
    }
    public function getRole() {
        return $this->role;
    }
    public function setTalents($talents)
    {
        $this->talents = $talents;
    }
    public function getTalents(){
        return $this->talents;
    }
    public function setMajorGlyphs($majorglyphs){
        $this->majorglyphs = $majorglyphs;
    }
    public function getMajorGlyphs(){
        return $this->majorglyphs;
    }
    public function setMinorGlyphs($minorglyphs){
        $this->minorglyphs = $minorglyphs;
    }
    public function getMinorGlyphs(){
        return $this->minorglyphs;
    }
    public function getIconLink(){
        return Util::getIcon36($this->icon);
    }
}

?>
