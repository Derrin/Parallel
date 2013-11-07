<?php
include_once('Util.php');
include_once('Character.php');
include_once('Appearance.php');
include_once('SpecBuilder.php');
include_once('ItemBuilder.php');
include_once('ProgressionBuilder.php');
include_once('ProfessionBuilder.php');

class CharacterBuilder {
    private $specBuilder;
    private $itemBuilder;
    private $profBuilder;
    private $progBuilder;
    
    public function __construct(){
        //initialise builders
        $this->specBuilder = new SpecBuilder();
        $this->itemBuilder = new ItemBuilder();
        $this->profBuilder = new ProfessionBuilder();
        $this->progBuilder = new ProgressionBuilder();
    }
    public function buildCharacter($json){
        //build character
        $character = $this->buildToon($json);
        //build appearance
        $character->setAppearance($this->buildAppearance($json->appearance));
        //build specs
        $character->setSpecs($this->specBuilder->buildSpecs($json->talents));
        //build items
        $character->setItems($this->itemBuilder->buildItems($json->items));
        //build stats
        //$character->setStats($this->buildStats($json->stats));
        //build professions
        $character->setProfessions($this->profBuilder->buildProfessions($json->professions));  
        //build progress
        $character->setProgress($this->progBuilder->buildProgress($json->progression->raids));
        
        return $character;
    }
    private function buildToon($json){
        // check if title array exists
        if(isset($json->titles)){
            $title = "";
            // selects the active title
            for($i=0;$i<count($json->titles);$i++){
                if (isset($json->titles[$i]->selected) && $json->titles[$i]->selected==true){
                    $title=$json->titles[$i]->name;
                    break;//break when active title is found
                }
            }
        }
        
        //process thumbnail
        $thumbtemp = explode("-", $json->thumbnail);
        $thumbnail = $thumbtemp[0];
        // check if player is in a guild
        if(isset($json->guild->name)) $guild = $json->guild->name; 
        else $guild = "";
        
        return new Character(
                $json->name,
                $title,
                $json->class,
                $json->race,
                $json->gender,
                $json->level,
                $json->items->averageItemLevel,
                $json->items->averageItemLevelEquipped,
                $json->achievementPoints,
                $json->totalHonorableKills,
                $thumbnail,
                $guild,
                $json->realm,
                $json->lastModified);
    }
    private function buildAppearance($json){
        return new Appearance($json->faceVariation, 
                              $json->skinColor, 
                              $json->hairVariation, 
                              $json->hairColor, 
                              $json->featureVariation, 
                              $json->showHelm, 
                              $json->showCloak);
    }
}
?>