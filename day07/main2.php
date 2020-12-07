<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$bagmap = [];
foreach ($lines as $i => $l) {
    print "$i $l\n";
    $parts = explode(' bags contain ', $l);
    if ($parts[1] == 'no other bags.') {
        $bagmap[$parts[0]] = [];
        print_r($bagmap[$parts[0]]);
        continue;
    }
    $parts[1] = str_replace(' bags', '', substr($parts[1],0,-1));
    $parts[1] = str_replace(' bag', '', $parts[1]);
    $holds = explode(', ',$parts[1]);
    //print_r($holds);

    foreach ($holds as $h) {
        //print "$h \n";
        $i = strpos($h, ' ');
        $n = (int)substr($h, 0, $i);
        $key = substr($h, $i+1);
        $bagmap[$parts[0]][$key] = $n;
    }

    //print_r($bagmap[$parts[0]]);
}

//print_r($bagmap);

$solution = countBags("shiny gold", 1, $bagmap);
print "solution is $solution\n";

////////////////////////////////////////////////////////////////////

function countBags($target, $multiplier, $bagmap, $depth = 0) {
    // count the bag itself starting at depth 1
    $count = $depth > 0 ? $multiplier : 0;

    foreach ($bagmap[$target] as $color => $num) {
        $count += $multiplier * countBags($color, $num, $bagmap, $depth+1);
        print "$depth $count $color $num \n";
    }

    return $count;
}

?>
