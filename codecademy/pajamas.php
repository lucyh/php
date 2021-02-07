<?php
class StringUtils{
    public static function secondCase($text){
        $textUpd = strtolower($text);
        if ( strlen($textUpd) > 1 ){
            $textUpd[1] = strtoupper($textUpd[1]);
        }
        return $textUpd;
    }
}

class Pajamas{
    private $owner, $fit, $color;
    function __construct( $owner = "unclaimed"
        , $fit = "poor"
        , $color = "magenta"){
        $this->owner = StringUtils::secondCase($owner);
        $this->fit = $fit;
        $this->color = $color;
    }
    function setFit($fit){
        $this->fit = $fit;
    }
    function describe(){
        return "The $this->color pajamas are owned by $this->owner and fit {$this->fit}ly.";
    }
}

class ButtonablePajamas extends Pajamas{
    private $button_state = "unbuttoned";
    function describe(){
        return parent::describe()." They are currently $this->button_state.";
    }
    function toggleButtons(){
        if ( $this->button_state === "unbuttoned" ){
            $this->button_state = "buttoned";
        }else{
            $this->button_state = "unbuttoned";
        }
    }
}

$chicken_PJs = new Pajamas("CHICKEN","nice", "purple");
echo $chicken_PJs->describe()."\n";
$chicken_PJs->setFit("bad");
echo $chicken_PJs->describe()."\n";

$moose_PJs = new ButtonablePajamas("MooSe");
echo $moose_PJs->describe()."\n";
$moose_PJs->toggleButtons();
echo $moose_PJs->describe()."\n";