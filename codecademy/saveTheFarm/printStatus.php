<?php

// Print Current Status
function printStatus()
{
    global $location, $wearing_glasses, $wearing_contacts, $has_mushrooms, $has_soup, $is_hungry, $needs_to_pee;

    echo "You are in: $location\n";
    if ($wearing_contacts) {
        echo "You are wearing contacts.\n";
    }
    if ($wearing_glasses) {
        echo "You are wearing glasses.\n";
    }
    if ($has_mushrooms) {
        echo "You are holding mushrooms.\n";
    }
    if ($has_soup) {
        echo "You are holding a scalding-hot bowl of mushroom soup.\n";
    }
    if ($needs_to_pee) {
        echo "You need to pee!\n";
    }
    echo "You are " . ($is_hungry ? "hungry" : "well-fed and energetic") . ".\n";
}
