<?php
include_once('/Util.php'); //nog te wijzigen
include_once('Character.php');
include_once('Spec.php');
include_once('Talent.php');
include_once('Glyph.php');
include_once('Profession.php');
include_once('RaidProgression.php');
include_once('BossKills.php');
include_once('Items\Item.php');
include_once('Items\GearItem.php');
include_once('Items\Head.php');

class CharacterBuilder {
    public function buildCharacter($json){
        //build character
        $character = $this->buildToon($json);
        //build specs
        $character->setSpecs($this->buildSpecs($json->talents));
        //build items
        $character->setItems($this->buildItems($json->items));
        //build stats
        //$character->setStats($this->buildStats($json->stats));
        //build professions
        $character->setProfessions($this->buildProfessions($json->professions));  
        //build progress
        $character->setProgress($this->buildProgress($json->progression->raids));
        
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
    private function buildSpecs($json){
        $specs[0] = $this->buildSpec($json[0]);
        $specs[1] = $this->buildSpec($json[1]);
        
        return $specs;
    }
    private function buildSpec($json){
        //check if the spec is set
        if(isset($json->spec->name)){
            $selected = (isset($json->selected) && $json->selected== true);
            $spec = new Spec($json->spec->name,
                    $json->spec->role,
                    $json->spec->icon,
                    $selected);
        }
        else $spec = new Spec();
        
        // set talents and glyphs
        $spec->setTalents($this->buildTalents($json->talents));
        $spec->setMajorGlyphs($this->buildGlyphs($json->glyphs->major));
        $spec->setMinorGlyphs($this->buildGlyphs($json->glyphs->minor));
        
        return $spec;
    }
    private function buildTalents($json){
        $MAXTALENTS=6;
        // fill in the talents
        for($i=0;$i<$MAXTALENTS;$i++){
            if(isset($json[$i]->tier)){
                $talents[$json[$i]->tier] = new Talent($json[$i]->spell->id,
                        $json[$i]->spell->name,
                        $json[$i]->spell->icon);
            }
        }
        // fill in the talents that are not selected / available yet
        for($i=0;$i<$MAXTALENTS;$i++){
            if(!isset($talents[$i]))
                $talents[$i] = new Talent();
        }
        ksort($talents);
        return $talents;
    }
    private function buildGlyphs($json){
        $MAXGLYPHS=3;
        // fill in the talents
        for($i=0;$i<$MAXGLYPHS;$i++){
            if(isset($json[$i]->glyph)){
                $glyphs[$i] = new Talent($json[$i]->item,
                        $json[$i]->name,
                        $json[$i]->icon);
            }
        }
        // fill in the glyphs that are not selected / available yet
        for($i=0;$i<$MAXGLYPHS;$i++){
            if(!isset($glyphs[$i]))
                $glyphs[$i] = new Glyph();
        }
        ksort($glyphs);
        return $glyphs;
    }
    private function buildProfessions($json){
        //check if professions are set
        //primary professions
        if(isset($json->primary[0]->id))
            $professions[0] = new Profession($json->primary[0]->id,$json->primary[0]->rank,$json->primary[0]->max);
        else $professions[0] = new Profession();
        
        if(isset($json->primary[1]->id))
            $professions[1] = new Profession($json->primary[1]->id,$json->primary[1]->rank,$json->primary[1]->max);
        else $professions[1] = new Profession();
        
        // secondary professions, might need to change as profession numbers in array are hardcoded
        // first aid
        if(isset($json->secondary[0]->id))
            $professions[2] = new Profession($json->secondary[0]->id,$json->secondary[0]->rank,$json->secondary[0]->max);
        else $professions[2] = new Profession();
        
        //cooking
        if(isset($json->secondary[3]->id))
            $professions[3] = new Profession($json->secondary[3]->id,$json->secondary[3]->rank,$json->secondary[3]->max);
        else $this->professions[3] = new Profession();

        return $professions;
    }
    private function buildItems($json){
        $items = array();
        //headpiece
        //__construct($id, $name, $icon, $quality, $itemlevel, $upgrade, $maxupgrade, $gems, $reforge, $set, $suffix) {
        
        //check for null values
        $items['head'] = new Head(
                $json->head->id,
                $json->head->name,
                $json->head->icon,
                $json->head->quality,
                $json->head->itemLevel,
                $json->head->tooltipParams->upgrade->current,
                $json->head->tooltipParams->upgrade->total,
                array(0 => $json->head->tooltipParams->gem0,
                      1 => $json->head->tooltipParams->gem1),
                /*$json->head->tooltipParams->reforge*/0,
                /*$json->head->tooltipParams->set,*/array(),
                /*$json->head->tooltipParams->suffix*/0,
                /*$json->head->tooltipParams->transmogItem*/0);
        return $items;
        //neck
        //shoulder
        //back
        //chest
        //shirt
        //tabard
        //wrist
        //hands
        //waist
        //legs
        //feet
        //finger1
        //finger2
        //trinket1
        //trinket2
        //mainhand
        //offhand     
    }
    private function buildProgress($json){
        $progress = array();
        $raid = array(0 => 6738,//SoO
                      1 => 6622,//ToT
                      2 => 6067,//ToES
                      3 => 6297,//HoF
                      4 => 6125);//MSV
                      //
        //loop over raids
        for($i=0;$i<count($json);$i++){
            //check if raid is ok to keep (id in the $raidarray)
            if(in_array($json[$i]->id,$raid)){
                $raidname = $json[$i]->name;
                $raidid = $json[$i]->id;
                $bosskills = array();
                //process bosskills
                for($b=0;$b<count($json[$i]->bosses);$b++){
                    $bosskills[] = $this->buildBossKills($json[$i]->bosses[$b]);
                } 
                //gets the key from the $raid array based on the jsonid, so ToT will be 1, for sorting purposes
                $id = array_keys($raid, $json[$i]->id);
                $progress[$id[0]] = new RaidProgression($raidname, $raidid, $bosskills);
            }
        }
        ksort($progress); //sort by key
        return $progress;     
    }
    private function buildBossKills($json){
        $bossname = $json->name;
        $lfrkills = isset($json->lfrKills)? $json->lfrKills : 0;
        $lfrkilltime = isset($json->lfrTimestamp)? $json->lfrTimestamp : 0;
        $flexkills = isset($json->flexKills)? $json->flexKills : 0;
        $flexkilltime = isset($json->flexTimestamp)? $json->flexTimestamp : 0;
        $normalkills = isset($json->normalKills)? $json->normalKills : 0;
        $normalkilltime = isset($json->normalTimestamp)? $json->normalTimestamp : 0;
        $heroickills = isset($json->heroicKills)? $json->heroicKills : 0;
        $heroickilltime = isset($json->heroicTimestamp)? $json->heroicTimestamp : 0;
        return new BossKills($bossname, $lfrkills, $lfrkilltime, $flexkills, $flexkilltime, $normalkills, $normalkilltime, $heroickills, $heroickilltime);
    }
}
?>