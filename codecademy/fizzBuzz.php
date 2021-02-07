<?php

$output = [];
for ($counter = 1; $counter <= 100; $counter++) {
    global $output;
    $nbrReplace = "";
    if ($counter % 3 === 0) {
        $nbrReplace .= "Fizz";
    }
    if ($counter % 5 === 0) {
        $nbrReplace .= "Buzz";
    }
    if ($counter % 3 !== 0 && $counter % 5 !== 0) {
        $nbrReplace .= $counter;
    }
    $output[] = $nbrReplace;
}
echo implode($output, " ");
echo "\n";

/*foreach ( $output as $word ){
  if ( $word === "Fizz" ){
    continue;
  }
  echo $word."\n";
  if ( $word === "FizzBuzz" ){
    break;
  }
}*/