<?php

class BossKills{
    private $bossname;
    private $lfrkills;
    private $lfrkilltime;
    private $flexkills;
    private $flexkilltime;
    private $normalkills;
    private $normalkilltime;
    private $heroickills;
    private $heroickilltime;
    
    public function __construct($bossname,$lfrkills,$lfrkilltime,$flexkills,$flexkilltime,$normalkills,$normalkilltime,$heroickills,$heroickilltime) {
        $this->bossname = $bossname;
        $this->lfrkills = $lfrkills;
        $this->lfrkilltime = $lfrkilltime;
        $this->flexkills = $flexkills;
        $this->flexkilltime = $flexkilltime;
        $this->normalkills = $normalkills;
        $this->normalkilltime = $normalkilltime;
        $this->heroickills = $heroickills;
        $this->heroickilltime = $heroickilltime;
    }

    public function getBossName(){
        return $this->bossname;
    }
    public function getLfrKills(){
        return $this->lfrkills;
    }
    public function getLfrKillTime($sec=false){
        if(!$sec)return (($this->lfrkilltime>0) ? date('d/m/Y',$this->lfrkilltime/1000): "/");
        else return $this->lfrkilltime;
    }
    public function getFlexKills(){
        return $this->flexkills;
    }
    public function getFlexKillTime($sec=false){
        if(!$sec)return (($this->flexkilltime>0) ? date('d/m/Y',$this->flexkilltime/1000): "/");
        else return $this->flexkilltime;
    }
    public function getNormalKills(){
        return $this->normalkills;
    }
    public function getNormalKillTime($sec=false){
        if(!$sec)return (($this->normalkilltime>0) ? date('d/m/Y',$this->normalkilltime/1000): "/");
        else return $this->normalkilltime;
    }
    public function getHeroicKills(){
        return $this->heroickills;
    }
    public function getHeroicKillTime($sec=false){
        if(!$sec)return (($this->heroickilltime>0) ? date('d/m/Y',$this->heroickilltime/1000): "/");
        else return $this->heroickilltime;
    }
}
?>
