<?php
include_once('ArmouryItem.php');
include_once('GearItem.php');
include_once('NullGearItem.php');

class ItemBuilder {
    public function buildItems($json){
        $items = array();
        $itemTypes = array("head","neck","shoulder","back","chest",
                           "shirt","tabard","wrist","hands","waist",
                           "legs","feet","finger1","finger2","trinket1",
                           "trinket2","mainhand","offhand");
        foreach($itemTypes as $key => $value) 
            $items[$value] = new NullGearItem(0); // Creates empty obj to allow method calls to missing items.

        // Generic looping of 'items' json obj
        foreach(get_object_vars($json) as $itemType => $itemObj){
                if(is_object($itemObj)){ // Check that its an object, as some attributes in the 'items' json obj are values and not actual item sub-objects. for example "avarageItemLevel"
                        $itemType = strtolower($itemType); // Issues with: "mainHand" and "offHand", as lowercase-version strings are used elsewhere in code.
                        $items[$itemType] = $this->buildItemObject($itemObj,$itemType);
                }
        }

        return $items;
    }
	
	/**
	 * This method splits the a gear item's JSON into its parts and builds the relevant GearItem class from the parts. Also does the checking for empty values.
	 * @author DDD
	 * @param jsonGearItem - An obj from the character's items
	 * @param itemType - A string value of item type, for example "head" or "neck".
	 * @return GearItem
	 **/
	private function buildItemObject($jsonGearItem,$itemType){
            $gems = array();
            $setPieces = null;
            $reforge = null;
            $transmogItem = null;
            $upgradesCurrent = null;
            $upgradesTotal = null;
            $randomEnch = null;
            $enchant = null;

            foreach(get_object_vars($jsonGearItem->tooltipParams) as $ttName => $ttValue){
                    switch($ttName){
                            case "gem0":
                            case "gem1":
                            case "gem2":
                            case "gem3":
                            case "gem4":
                                    $gems[] = $ttValue;
                                    break;
                            case "set":
                                    $setPieces = $ttValue;
                                    break;
                            case "reforge":
                                    $reforge = $ttValue;
                                    break;
                            case "transmogItem":
                                    $transmogItem = $ttValue;
                                    break;
                            case "upgrade":
                                    $upgradesCurrent = $ttValue->current;
                                    $upgradesTotal = $ttValue->total;
                                    break;
                            case "suffix":
                                    $randomEnch = $ttValue;
                                    break;
                            case "enchant":
                                    $enchant = $ttValue;
                                    break;
                    }
            }
            $item = new GearItem($jsonGearItem->id);
            $item->setUpgrade($upgradesCurrent);
            $item->setMaxUpgrade($upgradesTotal);
            $item->setGems($gems);
            $item->setReforge($reforge);
            $item->setSet($setPieces);
            $item->setSuffix($randomEnch);
            $item->setTransmog($transmogItem);
            $item->setEnchant($enchant);
            //TODO EXTRA SOCKET???
            //$item->setExtraSocket($sock)
            //TODO TINKER
            //$item->setTinker($tink);
            //TODO WEAPON INFO
            //$item->setWeaponInfo($weap);
            return $item;
	}
    public function getItem($itemid){
        //TODO REWORK A BIT
        $con=mysqli_connect("localhost","root","","parallel");
        // Check connection
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else{
            //check if item exists in database
            $result = mysqli_query($con,"SELECT * FROM items where id=".$itemid);
            $rowcount = mysqli_num_rows($result);
            if($rowcount==0){
            //item doesn't exist yet
                $json = @file_get_contents("http://eu.battle.net/api/wow/item/". $itemid);
                if ($json === false) {
                    echo '<h1>Item not found, good day sir!</h1>';
                    // to logfile character that couldn't be found!
                    // server may be down too!
                } else {
                    //decode the json and put the result in $result
                    $result = json_decode($json);
                    //check if there is data in the $results object
                    if (count(get_object_vars($result)) == 0) {
                        echo '<h1>Item not found, data empty, good day sir!</h1>';
                    } else {
                        if($result->hasSockets){
                            foreach($result->socketInfo->sockets as $value){
                                $sockets[] = $value->type;
                            }
                            $socketbonus = $result->socketInfo->socketBonus;
                        }
                        else{
                            $sockets = array();
                            $socketbonus="";
                        }
                        $item = new ArmouryItem($result->id, 
                                                $result->displayInfoId, 
                                                $result->name, 
                                                $result->icon, 
                                                $result->quality, 
                                                $result->itemLevel, 
                                                $result->itemSubClass,
                                                $result->inventoryType,
                                                $sockets, 
                                                $socketbonus);
                        //insert
//                        echo "inserting object!";
                        $sql = "INSERT INTO items (id,name, objectdata) VALUES (".$item->getId().",
                                                                                '".addslashes($item->getName())."',
                                                                                '".addslashes(serialize($item))."')";

                        if (!mysqli_query($con,$sql)){
                            die('Inserting failed : Error: ' . mysqli_error($con));
                        }
                        else{
//                            echo "inserted object!";
//                            echo "<h1>Item:</h1>";
                            var_dump($item);
                        }
                    }
                }


            }
            else{
            //item does exist
                while($row = mysqli_fetch_array($result)){
//                    echo "object from database! <br>";
//                    echo $row['id'];
//                    echo "<h1>Item:</h1>";
                    $item = unserialize($row['objectdata']);
//                    var_dump($item);
                }
            }
            return $item;
             mysqli_close($con);
        }
    }
}
?>