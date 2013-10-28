<?php
class JsonConnector {
	
	protected $conn;
	private $host = "127.0.0.1";
	private $username = "root";
	private $password = "";
	private $database = "parallel";
	
	protected $ttl_item = 999999999; // max, aka no refresh
	protected $ttl_character = 86400; // 1 day
	protected $ttl_generic = 86400; // 1 day
	
	public function __construct() {
		try {
			$this->conn = mysqli_connect($this->host,$this->username,$this->password,$this->database);
			// Check connection
			if (mysqli_connect_errno()){
				throw new Exception("Failed to connect to MySQL: " . mysqli_connect_error());
			}
		} catch(Exception $ex){
			throw $ex;
		}
	}
	
	public function pull($url){
		$result = mysqli_query($this->conn,"SELECT * FROM jsoncache WHERE url='" . $url . "';");
        $rowcount = mysqli_num_rows($result);
        if($rowcount==1){
			while($row = mysqli_fetch_array($result)){
				if($this->isFresh($row['date_saved'],$row['time_to_live'])){
					return $row['json'];
				}
				// else: needs an update
				break;
            }			
		}
		try {
			$json = $this->saveFresh($url,($rowcount!=1));
		} catch(Exception $ex){
			throw $ex;
		}
		return $json;
		
	}
	
	private function isFresh($dSaved, $ttl){
		$now = date('U');
		return ($now < (strtotime($dSaved)+$ttl)); // if now is before datesaved+ttl, then TRUE (still cachable), or if after then FALSE (needs pulled/re-cached)
	}
	
	private function saveFresh($url,$isNew){
		try {
			$json = $this->getLive($url);
			$json = addslashes($json);
		} catch(Exception $ex){
			throw $ex;
		}
		
		$datenow = date('c');
		$ttl = $this->calcTTL($url);
		if($isNew){
			$sql = "INSERT INTO jsoncache (url, date_saved, time_to_live, json) VALUES ('".$url."','".$datenow."',".$ttl.", '".$json."')";
		} else {
			$sql = "UPDATE jsoncache SET date_saved = '".$datenow."', time_to_live='".$ttl."', json='".$json."' WHERE url = '".$url."';";
		}
		
		if (!mysqli_query($this->conn,$sql)){
			throw new Exception('Insert/Update failed -- Error: ' . mysqli_error($this->conn));
		}
		return stripslashes($json);
	}
	
	private function getLive($url){
		//JSON isn't cache so pull from WoW API
		$json = @file_get_contents($url);
		if (empty($json) || $json === false) {
			throw new Exception("Failed to get contents from URL (".$url.")");
		}
		return $json;
	}
	
	private function calcTTL($url){
		if($pos = strpos($url,"/api/wow/item/")){
			return $this->ttl_item;
		}
		if($pos = strpos($url,"/api/wow/character/")){
			return $this->ttl_character;
		}
		return $this->ttl_generic;
	}
}	
?>