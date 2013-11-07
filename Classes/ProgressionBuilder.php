<?php
include_once('RaidProgression.php');
include_once('BossKills.php');

class ProgressionBuilder {
    public function buildProgress($json){
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
    public function buildBossKills($json){
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