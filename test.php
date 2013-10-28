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
    //echo '<a href="http://www.wowhead.com/item=94820" class="q4" rel="rand=-339">abc</a>';
    error_reporting(E_ALL);
    include_once('Classes\CharacterBuilder.php');
	include_once('Classes\JsonConnector.php');

    //ini_set('max_execution_time', 300);
    //http://eu.battle.net/api/wow/character/Silvermoon/Derrin?fields=items,feed,stats,talents,professions,titles,progression
    //http://jsonviewer.stack.hu/#http://eu.battle.net/api/wow/character/silvermoon/beariath?fields=talents,guild,items,progression
    //different image options : avatar, profilemain, inset, card
    //http://eu.battle.net/static-render/eu/silvermoon/187/91856571-avatar.jpg


    $char = isset($_GET['character']) ? $_GET['character'] : "Derrin";

    $region = "eu";
    $server = "Silvermoon";

    //guild parameter only for pugs and recruits, not for guildaudits
	$characterURL = "http://" . $region . ".battle.net/api/wow/character/" . $server . "/" . $char . "?fields=talents,stats,guild,items,progression,professions,titles";
	try {
		$jsonConn = new JsonConnector();
		$json = $jsonConn->request($characterURL);
	
	
        //decode the json and put the results in $results
        $results = json_decode($json);
        //check if there is data in the $results object
        if (count(get_object_vars($results)) == 0) {
            echo '<h1>Char not found, data empty, good day sir!</h1>';
        } else {
            $builder = new CharacterBuilder();
            $character = $builder->buildCharacter($results);

            //Character details
            echo '<h1>Character details</h1>';
            echo '<img src="' . $character->getThumbnailLink("inset") . '"><br>';
            echo 'Last Update:' . ($character->getLastUpdate() > 0 ? date('d/m/Y H:i:s', $character->getLastUpdate() / 1000) : "/");
            echo '<br>Name:';
            echo '<a href="http://' . $region . ".battle.net/api/wow/character/" . $server . "/" . $char . '?fields=talents,stats,guild,items,progression,professions,titles">' . $character->getName() . '</a>';
			echo '&nbsp;(<a href="http://' . $region . ".battle.net/wow/en/character/" . $server . "/" . $char . '/advanced">Armory</a>)';
            // check if title is empty!
            echo '<br>Title + name:' . str_replace("%s", $character->getName(), $character->getTitle());
            echo '<br>Guild:' . $character->getGuild();
            echo '<br>Realm:' . $character->getRealm();
            echo '<br>Class:' . Character::$CLASS[$character->getClass()];
            echo '<br>Gender:' . Character::$GENDER[$character->getGender()];
            echo '<br>Race:' . Character::$RACE[$character->getRace()];
            echo '<br>Level:' . $character->getLevel();
            echo '<br>Achievement Points:' . $character->getAchievementPoints();
            echo '<br>Honorable Kills:' . $character->getTotalHonorableKills();

            $profarray = $character->getProfessions();
            $prof1 = $profarray[0];
            $prof2 = $profarray[1];
            $prof3 = $profarray[2];
            $prof4 = $profarray[3];
            echo '<br>Profession 1:<img src="' . $prof1->getIconLink() . '"> ' . $prof1->getName() . " " . $prof1->getRank() . " / " . $prof1->getMax();
            echo '<br>Profession 2:<img src="' . $prof2->getIconLink() . '"> ' . $prof2->getName() . " " . $prof2->getRank() . " / " . $prof2->getMax();
            echo '<br>Profession 3:<img src="' . $prof3->getIconLink() . '"> ' . $prof3->getName() . " " . $prof3->getRank() . " / " . $prof3->getMax();
            echo '<br>Profession 4:<img src="' . $prof4->getIconLink() . '"> ' . $prof4->getName() . " " . $prof4->getRank() . " / " . $prof4->getMax();
            
            //Gear
            echo '<h1>Gear</h1>';
            echo 'AverageIlvl:' . $character->getAverageIlvl();
            echo '<br>AverageIlvlEquipped:' . $character->getAverageIlvlEquipped();
            $items = $character->getItems();
            echo '<table border="1">';
            echo '<tr><th><b>Slot</b></th><th><b>Item</b></th><th><b>Transmog</b></th></tr>';
            echo '<tr><td><b>Head</b></td><td>'.$items['head']->buildWowHeadToolTip().'</td><td>'.$items['head']->buildWowHeadToolTipTransmog().'</td></tr>';
            echo '<tr><td><b>Neck</b></td><td>'.$items['neck']->buildWowHeadToolTip().'</td><td>&nbsp;</td></tr>';
            echo '<tr><td><b>Shoulder</b></td><td>'.$items['shoulder']->buildWowHeadToolTip().'</td><td>'.$items['shoulder']->buildWowHeadToolTipTransmog().'</td></tr>';
            echo '<tr><td><b>Back</b></td><td>'.$items['back']->buildWowHeadToolTip().'</td><td>'.$items['back']->buildWowHeadToolTipTransmog().'</td></tr>';
            echo '<tr><td><b>Chest</b></td><td>'.$items['chest']->buildWowHeadToolTip().'</td><td>'.$items['chest']->buildWowHeadToolTipTransmog().'</td></tr>';
            echo '<tr><td><b>Wrists</b></td><td>'.$items['wrist']->buildWowHeadToolTip().'</td><td>'.$items['wrist']->buildWowHeadToolTipTransmog().'</td></tr>';
            echo '<tr><td><b>Hands</b></td><td>'.$items['hands']->buildWowHeadToolTip().'</td><td>'.$items['hands']->buildWowHeadToolTipTransmog().'</td></tr>';
            echo '<tr><td><b>Waist</b></td><td>'.$items['waist']->buildWowHeadToolTip().'</td><td>'.$items['waist']->buildWowHeadToolTipTransmog().'</td></tr>';
            echo '<tr><td><b>Legs</b></td><td>'.$items['legs']->buildWowHeadToolTip().'</td><td>'.$items['legs']->buildWowHeadToolTipTransmog().'</td></tr>';
            echo '<tr><td><b>Feet</b></td><td>'.$items['feet']->buildWowHeadToolTip().'</td><td>'.$items['feet']->buildWowHeadToolTipTransmog().'</td></tr>';
            echo '<tr><td><b>Finger 1</b></td><td>'.$items['finger1']->buildWowHeadToolTip().'</td><td>&nbsp;</td></tr>';
            echo '<tr><td><b>Finger 2</b></td><td>'.$items['finger2']->buildWowHeadToolTip().'</td><td>&nbsp;</td></tr>';
            echo '<tr><td><b>Trinket 1</b></td><td>'.$items['trinket1']->buildWowHeadToolTip().'</td><td>&nbsp;</td></tr>';
            echo '<tr><td><b>Trinket 2</b></td><td>'.$items['trinket2']->buildWowHeadToolTip().'</td><td>&nbsp;</td></tr>';
            echo '<tr><td><b>Weapon</b></td><td>'.$items['mainhand']->buildWowHeadToolTip().'</td><td>'.$items['mainhand']->buildWowHeadToolTipTransmog().'</td></tr>';
            echo '<tr><td><b>Off Hand</b></td><td>'.$items['offhand']->buildWowHeadToolTip().'</td><td>'.$items['offhand']->buildWowHeadToolTipTransmog().'</td></tr>';
            echo '<tr><td><b>Shirt</b></td><td>'.$items['shirt']->buildWowHeadToolTip().'</td><td>&nbsp;</td></tr>';
            echo '<tr><td><b>Tabard</b></td><td>'.$items['tabard']->buildWowHeadToolTip().'</td><td>&nbsp;</td></tr>';
            echo '</table>';
            
            echo '<h1>3D view</h1>';
            echo '<p>';
            echo '<object id="dsjkgbdsg2346" width="560" height="400" type="application/x-shockwave-flash" data="http://wow.zamimg.com/modelviewer/ZAMviewerfp11.swf" style="visibility: visible;">';
            echo '<param name="quality" value="high">';
            echo '<param name="allowscriptaccess" value="always">';
            echo '<param name="allowfullscreen" value="false">';
            echo '<param name="menu" value="false">';
            echo '<param name="bgcolor" value="#999999">';
            echo '<param name="wmode" value="direct">';
            echo '<param name="flashvars" value="model=humanmale&skins=6&modelType=16&contentPath=http://wow.zamimg.com/modelviewer/&equipList=3,112767,5,112579,10,112580,7,112581">';
            echo '</object></p>';

            //Talents
            echo '<h1>Spec</h1>';
            echo '<table border="1">';
            echo '<tr><td><b>Primary spec</b></td><td><b>Secondary spec</b></td></tr>';
            echo '<tr><td>';
            $specs = $character->getSpecs();
            $spec1 = $specs[0];
            $spec2 = $specs[1];
            echo '<img src="' . $spec1->getIconLink() . '">';
            echo '<b>' . $spec1->getSpecName() . '</b></td>';
            echo '<td>';
            echo '<img src="' . $spec2->getIconLink() . '">';
            echo '<b>' . $spec2->getSpecName() . '</b></td></tr>';
            echo '<tr><td><b>Talents</b></td><td><b>Talents</b></td></tr>';
            for ($i = 0; $i < 6; $i++) {
                echo '<tr><td>';
                $talents1 = $spec1->getTalents();
                $talents2 = $spec2->getTalents();

                echo '<img src="' . $talents1[$i]->getIconLink() . '">';
                if ($talents1[$i]->getId() > 0)
                    echo '<a href="http://www.wowhead.com/spell=' . $talents1[$i]->getId() . '">' . $talents1[$i]->getName() . '</a></td>';
                else
                    echo $talents1[$i]->getName() . '</td>';
                echo '<td>';
                echo '<img src="' . $talents2[$i]->getIconLink() . '">';
                if ($talents2[$i]->getId() > 0)
                    echo '<a href="http://www.wowhead.com/spell=' . $talents2[$i]->getId() . '">' . $talents2[$i]->getName() . '</a></td>';
                else
                    echo $talents2[$i]->getName() . '</td>';
                echo '</tr>';
            }
            echo '<tr><td><b>Major Glyphs</b></td><td><b>Major Glyphs</b></td></tr>';
            for ($i = 0; $i < 3; $i++) {
                echo '<tr><td>';
                $majorglyphs1 = $spec1->getMajorGlyphs();
                $majorglyphs2 = $spec2->getMajorGlyphs();
                echo '<img src="' . $majorglyphs1[$i]->getIconLink() . '">';
                if ($majorglyphs1[$i]->getId() > 0)
                    echo '<a href="http://www.wowhead.com/item=' . $majorglyphs1[$i]->getId() . '">' . $majorglyphs1[$i]->getName() . '</a></td>';
                else
                    echo $majorglyphs1[$i]->getName() . '</td>';
                echo '<td>';
                echo '<img src="' . $majorglyphs2[$i]->getIconLink() . '">';
                if ($majorglyphs2[$i]->getId() > 0)
                    echo '<a href="http://www.wowhead.com/item=' . $majorglyphs2[$i]->getId() . '">' . $majorglyphs2[$i]->getName() . '</a></td>';
                else
                    echo $majorglyphs2[$i]->getName() . '</td>';
                echo '</td></tr>';
            }
            echo '<tr><td><b>Minor Glyphs</b></td><td><b>Minor Glyphs</b></td></tr>';
            for ($i = 0; $i < 3; $i++) {
                echo '<tr><td>';
                $minorglyphs1 = $spec1->getMinorGlyphs();
                $minorglyphs2 = $spec2->getMinorGlyphs();
                echo '<img src="' . $minorglyphs1[$i]->getIconLink() . '">';
                if ($minorglyphs1[$i]->getId() > 0)
                    echo '<a href="http://www.wowhead.com/item=' . $minorglyphs1[$i]->getId() . '">' . $minorglyphs1[$i]->getName() . '</a></td>';
                else
                    echo $minorglyphs1[$i]->getName() . '</td>';
                echo '<td>';
                echo '<img src="' . $minorglyphs2[$i]->getIconLink() . '">';
                if ($minorglyphs2[$i]->getId() > 0)
                    echo '<a href="http://www.wowhead.com/item=' . $minorglyphs2[$i]->getId() . '">' . $minorglyphs2[$i]->getName() . '</a></td>';
                else
                    echo $minorglyphs2[$i]->getName() . '</td>';
                echo '</td></tr>';
            }
            echo '</table>';
            //Progress
            echo '<h1>Progress</h1>';
            echo '<table border="1">';
            echo '<tr><th>Boss</th><th>LFR</th><th>LFR Killtime</th><th>Flex</th><th>Flex Killtime</th><th>Normal</th><th>Normal Killtime</th><th>Heroic</th><th>Heroic Killtime</th></tr>';
            $progress = $character->getProgress();
            for ($i = 0; $i < count($progress); $i++) {

                $raid = $progress[$i];
                echo '<tr><td colspan="9" align="left"><b>' . $raid->getRaidName() . '</b></td></tr>';
                for ($b = 0; $b < count($raid->getBosskills()); $b++) {
                    $bosses = $raid->getBosskills();
                    echo '<tr><td>' . $bosses[$b]->getBossName() . '</td>';
                    echo '<td>' . $bosses[$b]->getLfrKills() . '</td>';
                    echo '<td>' . $bosses[$b]->getLfrKillTime() . '</td>';
                    echo '<td>' . $bosses[$b]->getFlexKills() . '</td>';
                    echo '<td>' . $bosses[$b]->getFlexKillTime() . '</td>';
                    echo '<td>' . $bosses[$b]->getNormalKills() . '</td>';
                    echo '<td>' . $bosses[$b]->getNormalKillTime() . '</td>';
                    echo '<td>' . $bosses[$b]->getHeroicKills() . '</td>';
                    echo '<td>' . $bosses[$b]->getHeroicKillTime() . '</td>';
                    echo '</td></tr>';
                }
            }
            echo '</table>';

            //JSON DUMP
            echo "<hr><h1>Json dump</h1><hr>";
            var_dump($results->items);
            var_dump($results);
        }
    } catch(Exception $ex){
		echo "<span style='color:red;'>" . $ex->getMessage() . "</span>";
	}
?>
    </body>
</html>