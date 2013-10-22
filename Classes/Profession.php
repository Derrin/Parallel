<?php
include_once '/Util.php';

class Profession {
    public static $PROFESSION = array(
        755 => "Jewelcrafting",197 => "Tailoring",164 => "Blacksmithing",
        186 => "Mining",171 => "Alchemy",333 => "Enchanting",202 => "Engineering",
        182 => "Herbalism",393 => "Skinning",165 => "Leatherworking",
        773 => "Inscription",185 => "Cooking",129 => "First Aid",0 => "No profession"); //no profession TODO better
    private $id;
    private $rank;
    private $max;
    
    public function __construct($id=0,$rank=0,$max=0) {
        $this->id = $id;
        $this->rank = $rank;
        $this->max = $max;
    }
    public function getName(){
        return Profession::$PROFESSION[$this->id];
    }
    public function getId(){
        return $this->id;
    }
    public function getIconLink(){
        return Util::getIcon18($this->getIcon());
    }
    public function getIcon(){
        switch($this->id){
            case 755:return "inv_misc_gem_01";
            case 197:return "trade_tailoring";
            case 164:return "trade_blacksmithing";
            case 186:return "inv_pick_02";  
            case 171:return "trade_alchemy";
            case 333:return "trade_engraving";
            case 202:return "trade_engineering";
            case 182:return "trade_herbalism";
            case 393:return "inv_misc_pelt_wolf_01";
            case 165:return "trade_leatherworking";
            case 773:return "inv_inscription_tradeskill01";
            case 185:return "inv_misc_food_15";
            case 129:return "spell_holy_sealofsacrifice";
            case 0  :return "inv_misc_questionmark";
        }
    }
    public function getRank(){
        return $this->rank;
    }
    public function getMax(){
        return $this->max;
    }
}
?>
