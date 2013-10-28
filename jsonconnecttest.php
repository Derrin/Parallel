<?php
//jsonconnecttest.php
include_once('Classes/JsonConnector.php');

$jsonConn = new JsonConnector();
$json = $jsonConn->pull("http://eu.battle.net/api/wow/character/Silvermoon/Derrin?fields=items,feed,stats,talents,professions,titles,progression");
echo "<pre>" . var_export($json,true) . "</pre>";
?>