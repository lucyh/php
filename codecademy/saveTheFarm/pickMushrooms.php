<?php

#If the location is the woods, pick mushrooms; otherwise, you cannot pick mushrooms
function pickMushrooms()
{
    global $location, $has_mushrooms;
    if ($location !== "woods") {
        echo "There aren't any mushrooms to pick.\n";
    } else {
        echo "You've picked some mushrooms.\n";
        $has_mushrooms = true;
    }
}