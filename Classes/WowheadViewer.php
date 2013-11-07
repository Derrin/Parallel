<?php

class WowheadViewer {
    private $character;
    public function __construct($character) {
        $this->character = $character;
    }
    public function buildViewer(){
        $html  ='<object id="wowheadviewer" width="560" height="400" type="application/x-shockwave-flash" data="http://wow.zamimg.com/modelviewer/ZAMviewerfp11.swf" style="visibility: visible;">';
        $html .='<param name="quality" value="high">';
        $html .='<param name="allowscriptaccess" value="always">';
        $html .='<param name="allowfullscreen" value="false">';
        $html .='<param name="menu" value="false">';
        $html .='<param name="bgcolor" value="#999999">';
        $html .='<param name="wmode" value="direct">';
        $html .='<param name="flashvars" value="';
        $html .='model='. $this->getModel();
        $html .= $this->getAppearance();
        $html .='&mode=3&modelType=16&contentPath=http://wow.zamimg.com/modelviewer/';
        $html .=$this->getGear();
        var_dump($this->getGear());
        $html .='">';
        $html .='</object>';
        return $html;
    }
    private function getModel(){
        $gender = Character::$GENDER[$this->character->getGender()];
        $race = Character::$RACE[$this->character->getRace()];
        //undead are called scourge in the zamviewer
        if($race == 'Undead'){       
            $race = 'Scourge';
        }
        //remove whitespaces and capitals e.g. Night ElfFemale -> nightelffemale
        return str_replace(' ', '', strtolower($race.$gender));
    }
    private function getAppearance(){
        $appearance = $this->character->getAppearance();
        $app  = '&sk='.$appearance->getSkinColor();
        $app .= '&ha='.$appearance->getHairVariation();
        $app .= '&hc='.$appearance->getHairColor();
        $app .= '&fa='.$appearance->getFaceVariation();
        $app .= '&fh='.$appearance->getFeatureVariation();
        $app .= '&fc='.$appearance->getHairColor();
        return $app;
    }
    private function getGear(){
        $items = $this->character->getItems();
        if($this->character->getAppearance()->IsHelmShown()){
            $gear[]= $this->getItemLook($items['head']);
        }
        if($this->character->getAppearance()->IsCloakShown()){
            $gear[]=$this->getItemLook($items['back']);
        }
        $gear[]=$this->getItemLook($items['shoulder']);
        $gear[]=$this->getItemLook($items['chest']);
        $gear[]=$this->getItemLook($items['shirt']);
        $gear[]=$this->getItemLook($items['tabard']);
        $gear[]=$this->getItemLook($items['hands']);
        $gear[]=$this->getItemLook($items['wrist']);
        $gear[]=$this->getItemLook($items['waist']);
        $gear[]=$this->getItemLook($items['legs']);
        $gear[]=$this->getItemLook($items['feet']);
        $gear[]=$this->getItemLook($items['mainhand']);
        $gear[]=$this->getItemLook($items['offhand']);
        return '&equipList='.implode(',',array_filter($gear, 'strlen'));
    }
    private function getItemLook($item,$notransmog=false){
        if(!($item instanceof NullGearItem)){
            if($notransmog || is_null($item->getTransmog())){
                return $item->getSlot().','.$item->getDisplayId();
            }
            else{
                return $item->getTransmog()->getSlot().','.$item->getTransmog()->getDisplayId();
            }
        }
        else return '';
    }
}
?>