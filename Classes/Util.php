<?php
if (!defined('DS')) define("DS",DIRECTORY_SEPARATOR);

class Util {
    public static function getIcon18($item){
        return "http://media.blizzard.com/wow/icons/18/".$item.".jpg";
    }
    public static function getIcon36($item){
        return "http://media.blizzard.com/wow/icons/36/".$item.".jpg";
    }
    public static function getIcon56($item){
        return "http://media.blizzard.com/wow/icons/56/".$item.".jpg";
    }
}

?>