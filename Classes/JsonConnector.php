<?php
/**
 * Acts as an intermediary between the WoW API and the output JSON. And will cache previously requested URLs.
 * Uses Time-to-Live values + date saved to determine what needs to be re-cached and what does not.
 * @author DDD
 * @version 0.3.0
 */
class JsonConnector {
	
	/* Database Connection details */
	protected $conn;
	private $host = "127.0.0.1";
	private $username = "root";
	private $password = "";
	private $database = "parallel";
	
	/* Time-to-Live Values, in seconds */
	protected $ttl_item = 999999999; // max, aka no refresh
	protected $ttl_character = 86400; // 1 day
	protected $ttl_generic = 86400; // 1 day
	
	/**
	 * Initialises the database connection. Should be try/catched for Throws thrown Exceptions.
	 */
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
	
	/**
	 * Gets contents of the specified URL from the relevant location, based on cache and caching rules.
	 * @param url Is the full URL that you wish to retrieve.
	 */
	public function request($url){
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
	/**
	 * Gets contents of the specified URL, no cache. Can throw Exception.
	 * @param url Is the full URL that you wish to retrieve.
	 */
	public function demand($url){
		try {
			$json = $this->getLive($url);
		} catch(Exception $ex){
			throw $ex;
		}
		return $json;
	}
	
	/**
	 * Returns TRUE if date+ttl is still within range for caching. Returns FALSE if date+ttl is outside range for caching.
	 * @param dSaved A date string that can be parsed by strtotime()
	 * @param ttl A integer containing numbers of seconds, the data should be cached for.
	 */
	private function isFresh($dSaved, $ttl){
		$now = date('U'); // Unix timestamp for Now
		return ($now < (strtotime($dSaved)+$ttl)); // if now is before datesaved+ttl, then TRUE (still cachable), or if after then FALSE (needs pulled/re-cached)
	}
	
	/**
	 * Inserts or Updates the database with new data from live URL.
	 * @param url Is the URL of the page you wish to insert/update.
	 * @param isNew A boolean to determine if to Insert or Update the database.
	 */
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
	
	/**
	 * Private function to get the contents of the specified URL, no cache. Can throw Exception.
	 * @param url Is the full URL that you wish to retrieve.
	 */
	private function getLive($url){
		//JSON isn't cache so pull from WoW API
		$json = @file_get_contents($url);
		if (empty($json) || $json === false) {
			throw new Exception("Failed to get contents from URL (".$url.")");
		}
		return $json;
	}
	
	/**
	 * Private function that parses the URL to determine which TTL value is returned.
	 * @param url Is the full URL that is being parsed.
	 * @return Integer Of the time-to-live, aka time (in seconds) to be cached.
	 */
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