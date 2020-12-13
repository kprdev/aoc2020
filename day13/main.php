<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);


$targetStamp = $lines[0];

$busses = []; 
foreach (explode(',',$lines[1]) as $i => $ids) {
    if ($num = (int)$ids)
        $busses[] = $num;
}

print "time is $targetStamp\n";

$timecode = PHP_INT_MAX;
foreach ($busses as $n) {
    // first stop after target for each bus
    $x = (int)($targetStamp / $n) + 1;

    $stoptime = $x * $n;
    $wait = $stoptime - $targetStamp;

    if ($stoptime < $timecode) {
        $solution = $n * $wait;
        $timecode = $stoptime;
    }
    print "stop time: $stoptime bus: $n wait: $wait\n";
}

print "solution is $solution.\n";

?>
