<?php

$play_count = 0;
$correct_guesses = 0;
$guess_high = 0;
$guess_low = 0;

echo "I'm going to think of numbers between 1 and 10 (inclusive).\nDo you think you can guess correctly?\n";

function guessNumber(){
    global $play_count;
    global $correct_guesses;
    global $guess_high;
    global $guess_low;

    $play_count++;
    $nbr = rand(1,10);
    echo "\nEnter your guess:\n";
    $guessStr = readline(">> ");
    $guess = intval($guessStr);
    echo "Round : $play_count\n";
    echo "Guess : $guessStr\n";
    echo "Number: ".strval($nbr)."\n";
    if ( $guess === $nbr ){
        $correct_guesses++;
    }elseif ( $guess < $nbr ){
        $guess_low++;
    }else{
        $guess_high++;
    }
}

while ( $play_count < 10 ){
    guessNumber();
}
$pct_correct = ($correct_guesses/$play_count)*100;
$pct_high = ($guess_high/$play_count)*100;
$pct_low = ($guess_low/$play_count)*100;
echo "After $play_count rounds:\n";
echo "==$pct_correct% of your guesses were correct\n";
echo "==$pct_low% of your guesses were low\n";
echo "==$pct_high% of your guesses were high\n";
echo "When you guessed wrong, you tended to guess ".($guess_low > $guess_high ? "low" : "high")."\n"; 