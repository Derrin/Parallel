<?php
//include_once 'Util.php';
abstract class Item {
    //item quality
    const POOR=0,COMMON=1,UNCOMMON=2,RARE=3,EPIC=4,LEGENDARY=5,ARTIFACT=6,HEIRLOOM=7;
    
    private $itemid;
    private $itemname;
    private $icon;
    private $quality;
    private $itemlevel;
    
    public function __construct($id,$name,$icon,$quality,$itemlevel)
    {
        $this->itemid = $id;
        $this->itemname = $name;
        $this->icon = $icon;
        $this->quality = $quality;
        $this->itemlevel = $itemlevel;
    }
    public function buildWowHeadToolTip($level=90){
        //$level -> character itemlevel for hairlooms
        $tooltip  = '<a href="http://www.wowhead.com/item=';
        $tooltip .= $this->itemid.'"';
        $tooltip .= 'class="q'.$this->quality.'"';
        $tooltip .= 'rel="';
        $tooltip .= $this->buildParamsTooltipHook($level);
        $tooltip .= '" target="_blank">';
        $tooltip .= '<img src="'.$this->getIconLink().'">';
        $tooltip .= $this->itemname;
        $tooltip .= '</a>';
        return $tooltip;
    }
    protected function buildParamsTooltipHook($level){
        $tooltip = 'lvl=' + $level;
        return $tooltip;
    }
	public function buildWowHeadToolTipTransmog($level=90){
		return;
	}
	
    public function getItemId(){
        return $this->itemid;
    }
    public function getItemName(){
        return $this->itemname;
    }
    public function getIconLink(){
        return Util::getIcon36($this->icon);
    }
    public static function LookupDisplayId()
    {
        //wowhead uses different display id's
        
        $EntryId = $this->itemid; //make this singleton, so only one lookup per item
        if( !is_int( $EntryId ) )
        {
            trigger_error( "'$EntryId' is not a valid item entry ID.", E_USER_WARNING );
            return null;
        }
       
        $Url = sprintf( "http://www.wowhead.com/item=%u?xml", $EntryId );
        $Xml = file_get_contents( $Url );
        $Xml = simplexml_load_string( $Xml );
       
        if( isset( $Xml->error ) )
        {
            trigger_error( $Xml->error, E_USER_WARNING );
            return null;
        }
       
        $DisplayId = $Xml->item->icon["displayId"];
       
        return intval( $DisplayId );
    }
}

interface Transmogable {
	public function getTransmogItem();
}
?>
