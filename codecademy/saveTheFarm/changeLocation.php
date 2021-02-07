<?php
// Change player location
function changeLocation(){
    global $location;
    echo "Where do you want to go?\n";
    $where = strtolower(readline(">> " ));
    $in_kitchen = $location === "kitchen";
    if ( $in_kitchen && $where === "bathroom" ){
        echo "You go to: bathroom.\n";
        $location = "bathroom";
    }elseif ( $in_kitchen &&  $where === "woods" ){
        echo "You follow the winding path, shivering as you make your way deep into the Terror Woods.";
        $location = "woods";
    }elseif ( $location === "bathroom" && $where === "kitchen" ){
        echo "You go to: kitchen";
        $location = "kitchen";
    }elseif ( $location === "woods" && $where === "kitchen" ){
        echo "You go to: kitchen.\n";
        $location = "kitchen";
    }elseif ( $where === "kitchen" || $where === "bathroom" || $where === "woods") {
        echo "You can't go directly to there from your current location. Try going somewhere else first.\n";
    }else{
        echo "That doesn't make sense. Are you confused? Try 'look around'.\n";
    }
}