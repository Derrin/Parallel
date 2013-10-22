<?php
    include_once('Classes\ArmouryItem.php');
    
    //get item details
    $region = "eu";
    $itemid = isset($_GET['item']) ? $_GET['item'] : 103932;
    
    // make connection
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
            $json = @file_get_contents("http://" . $region . ".battle.net/api/wow/item/". $itemid);
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
                                            $sockets, 
                                            $socketbonus);
                    //insert
                    echo "inserting object!";
                    $sql = "INSERT INTO items (id,name, objectdata) VALUES (".$item->getId().",
                                                                            '".addslashes($item->getName())."',
                                                                            '".addslashes(serialize($item))."')";

                    if (!mysqli_query($con,$sql)){
                        die('Inserting failed : Error: ' . mysqli_error($con));
                    }
                    else{
                        echo "inserted object!";
                        echo "<h1>Item:</h1>";
                        var_dump($item);
                    }
                }
            }
            
                
        }
        else{
        //item does exist
            while($row = mysqli_fetch_array($result)){
                echo "object from database! <br>";
                echo $row['id'];
                echo "<h1>Item:</h1>";
                $item = unserialize($row['objectdata']);
                var_dump($item);
            }
        }
         mysqli_close($con);
    }
?>
