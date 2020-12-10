<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$adapters = [];
foreach ($lines as $l) {
    $adapters[] = (int)$l;
}

sort($adapters);

/*  Find a chain that uses all of your 
    adapters to connect the charging outlet 
    to your device's built-in adapter and 
    count the joltage differences between 
    the charging outlet, the adapters, and 
    your device. What is the number of 1-jolt 
    differences multiplied by the number of 
    3-jolt differences? */

$diffs = [];
$current = 0;
foreach ($adapters as $i => $n) {
    $d = $n - $current;
    if (array_key_exists($d, $diffs))
        $diffs[$d]++;
    else
        $diffs[$d] = 1;
    
    //printf("i %4d n %4d curr %4d d %4d\n", $i, $n, $current, $d);
    $current = $n;
}
$diffs[3]++;

$solution = $diffs[1] * $diffs[3];
print "solution is $solution\n";

?>
