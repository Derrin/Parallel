<?php

class RaidProgression {
    private $raidname;
    private $raidid;
    private $bosskills = array();
    
    public function __construct($raidname,$raidid,$bosskills){
        $this->raidname = $raidname;
        $this->raidid = $raidid;
        $this->bosskills = $bosskills;
    }

    public function getRaidName(){
        return $this->raidname;
    }
    public function getRaidId(){
        return $this->raidid;
    }
    public function getbosskills(){
        return $this->bosskills;
    }
}
?>
