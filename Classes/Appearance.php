<?php
class Appearance {
    private $faceVariation;
    private $skinColor;
    private $hairVariation;
    private $hairColor;
    private $featureVariation;
    private $showHelm;
    private $showCloak;
    
    public function __construct($faceVariation,$skinColor,$hairVariation,$hairColor,$featureVariation,$showHelm,$showCloak) {
        $this->faceVariation = $faceVariation;
        $this->skinColor = $skinColor;
        $this->hairVariation = $hairVariation;
        $this->hairColor = $hairColor;
        $this->featureVariation = $featureVariation;
        $this->showHelm = $showHelm;
        $this->showCloak = $showCloak;
    }
    public function getFaceVariation(){
        return $this->faceVariation;
    }
    public function getSkinColor(){
        return $this->skinColor;
    }
    public function getHairVariation(){
        return $this->hairVariation;
    }
    public function getHairColor(){
        return $this->hairColor;
    }
    public function getFeatureVariation(){
        return $this->featureVariation;
    }
    public function IsHelmShown(){
        return $this->showHelm;
    }
    public function IsCloakShown(){
        return $this->showCloak;
    }
}
?>