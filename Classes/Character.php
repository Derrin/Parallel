<?php

class Character {
    // 24->neutral panda, 25 -> alliance, 26 -> horde
    public static $RACE = array(1 => "Human",2 => "Orc",3 => "Dwarf",
        4 => "Night Elf",5 => "Undead",6 => "Tauren",7 => "Gnome",
        8 => "Troll",9 => "Goblin",10=> "Blood Elf",11=> "Draenei",
        22=> "Worgen",24=> "Pandaren",25=> "Pandaren",26=> "Pandaren");
    public static $GENDER = array(0 => "Male",1 => "Female");
    public static $CLASS = array(1 => "Warrior",2 => "Paladin",
        3 => "Hunter",4 => "Rogue",5 => "Priest",6 => "Death Knight",
        7 => "Shaman",8 => "Mage",9 => "Warlock",10=> "Monk",11=> "Druid");
    
    // power -> mana / rage / energy / focus
    // raceicons???
    private $lastupdate;
    private $realm;
    private $name;
    private $title;
    private $class;
    private $guild;
    private $race;
    private $gender;
    private $level;
    private $thumbnail;
    private $achievementPoints;
    private $totalHonorableKills;
    private $specs;
    private $professions = array();
    private $items = array();
    private $averageIlvl;
    private $averageIlvlEquipped;
    private $progression = array();
    private $appearance;
    
    function __construct($name,$title,$class,$race,$gender,$level,$averageIlvl,$averageIlvlEquipped,$achievementPoints,$totalHonorableKills,$thumbnail,$guild,$realm,$lastUpdate){
        $this->name = $name;
        $this->title = $title;
        $this->class = $class;
        $this->race = $race;
        $this->gender = $gender;
        $this->level = $level;
        $this->averageIlvl = $averageIlvl;
        $this->averageIlvlEquipped = $averageIlvlEquipped;
        $this->achievementPoints = $achievementPoints;
        $this->totalHonorableKills = $totalHonorableKills;
        $this->thumbnail = $thumbnail;
        $this->guild = $guild;
        $this->realm = $realm;
        $this->lastupdate = $lastUpdate;
    }

    //Get methods
    public function getLastUpdate() {
        return $this->lastupdate;
    }
    public function getName(){
        return $this->name;
    }
    public function getClass() {
        return $this->class;
    }
    public function getAchievementPoints() {
       return $this->achievementPoints; 
    }
    public function getRace() {
        return $this->race;
    }
    public function getRealm() {
        return $this->realm;
    }
    public function getGuild() {
        return $this->guild;
    } 
    public function getGender() {
        return $this->gender;
    }
    public function getLevel() {
        return $this->level;
    }
    public function getTotalHonorableKills() {
        return $this->totalHonorableKills;
    }
    public function setSpecs($specs){
        $this->specs = $specs;
    }
    public function getSpecs()
    {
        return $this->specs;
    }
    public function setProgress($progression){
        $this->progression = $progression;
    }
    public function getProgress(){
        return $this->progression;
    }
    public function getTitle(){
        return $this->title;
    }
    public function setProfessions($professions){
       $this->professions = $professions;
    }
    public function getProfessions() {
        return $this->professions;
    }
    public function setItems($items){
        $this->items = $items;
    }
    public function getItems(){
        return $this->items;
    }
    public function setAverageIlvl($averageIlvl){
        $this->averageIlvl = $averageIlvl;
    }
    public function getAverageIlvl(){
        return $this->averageIlvl;
    }
    public function setAverageIlvlEquipped($averageIlvlEquipped){
        $this->averageIlvlEquipped = $averageIlvlEquipped;
    }
    public function getAverageIlvlEquipped(){
        return $this->averageIlvlEquipped;
    }
    public function getAppearance(){
        return $this->appearance;
    }
    public function setAppearance($appearance){
        $this->appearance = $appearance;
    }
    public function getThumbnailLink($type=""){
        $output='http://eu.battle.net/static-render/eu/'.$this->thumbnail;
        switch($type){
            case "avatar":
                $output = $output."-avatar.jpg";
                break;
            case "card":
                $output = $output."-card.jpg";
                break;
            case "main":
                $output = $output."-profilemain.jpg";
                break;
            default :
                $output = $output."-inset.jpg";
        }
        return $output;
    }
}
?>
