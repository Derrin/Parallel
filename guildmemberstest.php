<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <style>
            body{
                /*background-color: #9395ff;*/
            }
        </style>
        <script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script>
        <script>var wowhead_tooltips = {"colorlinks": false, "iconizelinks": false, "renamelinks": true};</script>
    </head> 
    <body>

<?php
    error_reporting(E_ALL);
    include_once('Classes\JsonConnector.php');
    include_once('Classes\Character.php');
    //ini_set('max_execution_time', 300);
    $ranks = array(0 => 'Guildmaster',
                   1 => 'Officer',
                   2 => 'Officeralt',
                   3 => 'Core Raider',
                   4 => 'Raider',
                   5 => 'Trial Raider',
                   6 => 'Social',
                   7 => 'Inactive');
    $region = "eu";
    $server = "Silvermoon";

    //guild parameter only for pugs and recruits, not for guildaudits
	$characterURL = "http://" . $region . ".battle.net/api/wow/guild/" . $server . "/Parallel?fields=members";
//	try {
		$jsonConn = new JsonConnector();
		$json = $jsonConn->request($characterURL);
	
	
        //decode the json and put the results in $results
        $results = json_decode($json);
        //check if there is data in the $results object
        if (count(get_object_vars($results)) == 0) {
            echo '<h1>Char not found, data empty, good day sir!</h1>';
        } else {
            echo '<h1>Guildlist</h1>';
            echo '<table border="1">';
            echo '<tr><th><b>Name</b></th><th><b>Level</b></th><th><b>Gender</b></th><th><b>Race</b></th><th><b>Class</b></th><th><b>Rank</b></th><th><b>Achievements</b></th></tr>';
            var_dump($results->members[0]);
            foreach($results->members as $toon){
                $member = $toon->character;
                echo '<tr><td>';
                if($member->level>10)
                    echo '<img width="32px" height="32px" src="http://eu.battle.net/static-render/eu/'.$member->thumbnail.'" style="border: 1px solid #000000">';
                echo '<a href="./test.php?character=' . $member->name.'">';
                echo '<b>'.$member->name.'</b></a></td><td>'.$member->level.'</td>';
                echo '<td>'.Character::$GENDER[$member->gender].'</td><td>'.Character::$RACE[$member->race].'</td>';
                echo '<td>';
                if(isset($member->spec->name)) 
                    echo $member->spec->name;
                echo ' '.Character::$CLASS[$member->class].'</td>';
                echo '<td>'.$ranks[$toon->rank].'</td>';
                echo '<td>'.$member->achievementPoints.'</td></tr>';
            }
            echo '</table>';
            //JSON DUMP
//            echo "<hr><h1>Json dump</h1><hr>";
//            var_dump($results);
        }
?>
    </body>
</html>
