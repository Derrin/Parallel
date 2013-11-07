<?php
include_once('Profession.php');

class ProfessionBuilder {
    public function buildProfessions($json){
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
}

?>