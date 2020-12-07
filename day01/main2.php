<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);

unset($lines[count($lines)-1]);
foreach ($lines as $i => $line) {
	$lines[$i] = (int)$line;
}


$length = count($lines);

print "$length items in input.\n";

foreach ($lines as $i => $int1)
    foreach ($lines as $j => $int2) 
        foreach ($lines as $k => $int3) {
            if ($i == $j || $j == $k || $i == $k)
                continue;
            
            $sum = $int1 + $int2 + $int3;
            if ($sum == 2020) {
                $product = $int1 * $int2 * $int3;
                print "found product is $product\n";
                exit;
            }
       }

?>
