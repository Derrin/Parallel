<?php
//jsonconnecttest.php
include_once('Classes/JsonConnector.php');

try {
	$jsonConn = new JsonConnector();
	$json = $jsonConn->request("http://eu.battle.net/api/wow/character/Silvermoon/Derrin?fields=items,feed,stats,talents,professions,titles,progression");
	echo "<pre>"; var_dump(json_decode($json)); echo "</pre>";
} catch(Exception $ex){
	echo "<span style='color:red;'>" . $ex->getMessage() . "</span>";
}
?>