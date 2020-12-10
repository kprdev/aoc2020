<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$adapters = [];
foreach ($lines as $l) {
    $adapters[] = (int)$l;
}
$adapters[] = 0;
sort($adapters);

/*  What is the total number of distinct ways you can 
arrange the adapters to connect the charging outlet 
to your device? */

# find slices 3 apart
$n = 0;
$parts[$n][0] = $adapters[0];

for ($i = 0; $i < count($adapters)-1; $i++){
    if ($adapters[$i+1] - $adapters[$i] > 1) {
        $n++;
    }
    $parts[$n][] = $adapters[$i+1];
}
print_r($parts);

$prod = 1;
foreach ($parts as $p) {
    switch (count($p)) {
        case 1:  
        case 2:  
            break;
        case 3:
            $prod *= 2; break;
        case 4:
            $prod *= 4; break;
        case 5:
            $prod *= 7; break;
    }
}

print "solution is $prod\n";

/*
1 2 3 4 5
1 2 3 5
1 2 4 5
1 3 4 5
1 2 5
1 4 5
1 3 5

1 2 3 4
1 2 4
1 3 4
1 4

1 2 3
1 3

1 2
*/

?>
