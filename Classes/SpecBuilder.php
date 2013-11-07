<?php
include_once('Spec.php');
include_once('Talent.php');
include_once('Glyph.php');

class SpecBuilder {
    public function buildSpecs($json){
        $specs[0] = $this->buildSpec($json[0]);
        $specs[1] = $this->buildSpec($json[1]);
        
        return $specs;
    }
    private function buildSpec($json){
        //check if the spec is set
        if(isset($json->spec->name)){
            $selected = (isset($json->selected) && $json->selected== true);
            $spec = new Spec($json->spec->name,
                    $json->spec->role,
                    $json->spec->icon,
                    $selected);
        }
        else $spec = new Spec();
        
        // set talents and glyphs
        $spec->setTalents($this->buildTalents($json->talents));
        $spec->setMajorGlyphs($this->buildGlyphs($json->glyphs->major));
        $spec->setMinorGlyphs($this->buildGlyphs($json->glyphs->minor));
        
        return $spec;
    }
    public function buildTalents($json){
        $MAXTALENTS=6;
        // fill in the talents
        for($i=0;$i<$MAXTALENTS;$i++){
            if(isset($json[$i]->tier)){
                $talents[$json[$i]->tier] = new Talent($json[$i]->spell->id,
                        $json[$i]->spell->name,
                        $json[$i]->spell->icon);
            }
        }
        // fill in the talents that are not selected / available yet
        for($i=0;$i<$MAXTALENTS;$i++){
            if(!isset($talents[$i]))
                $talents[$i] = new Talent();
        }
        ksort($talents);
        return $talents;
    }
    function buildGlyphs($json){
        $MAXGLYPHS=3;
        // fill in the talents
        for($i=0;$i<$MAXGLYPHS;$i++){
            if(isset($json[$i]->glyph)){
                $glyphs[$i] = new Talent($json[$i]->item,
                        $json[$i]->name,
                        $json[$i]->icon);
            }
        }
        // fill in the glyphs that are not selected / available yet
        for($i=0;$i<$MAXGLYPHS;$i++){
            if(!isset($glyphs[$i]))
                $glyphs[$i] = new Glyph();
        }
        ksort($glyphs);
        return $glyphs;
    }
}

?>