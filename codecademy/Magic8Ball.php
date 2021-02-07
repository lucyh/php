<?php

$answers = [ "It is certain.", "It is decidedly so."
    , "Without a doubt.",  "Yes - definitely."
    , "You may rely on it.", "As I see it, yes."
    , "Most likely.", "Outlook good.", "Yes."
    , "Signs point to yes.", "Reply hazy, try again."
    , "Ask again later.", "Better not tell you now."
    , "Cannot predict now.", "Concentrate and ask again."
    , "Don't count on it.", "My reply is no."
    , "My sources say no.", "Outlook not so good."
    , "Very doubtful." ];
function magic8Ball(){
    echo "Please enter a yes or no question:\n";
    $question = readline(">> ");
    echo "Your question was $question.\n";
    $nbr = rand(0,19);
    global $answers;
    echo "{$answers[$nbr]}\n";
}

magic8Ball();

strv