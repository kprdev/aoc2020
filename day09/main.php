<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$nums = [];
foreach ($lines as $l) {
    $nums[] = (int)$l;
}

$preambleLen  = 25;

for ($i = 0; $i < count($lines) - $preambleLen + 1; $i++) {
    $list = array_slice($nums, $i, $preambleLen);
    $target = $nums[$i + $preambleLen];

    $found = findSum($list, $target);
    if (!$found) {
        print "sum of $target not found.\n";
        break;
    }
}
die;

function findSum($list, $target) {
    foreach ($list as $i => $n) {
        foreach ($list as $j => $m) {
            //print "$n($i) $m($j) $target\n";
            if ($i == $j)
                continue;
            if ($n + $m == $target) {
                print "sum found $n [$i] + $m [$j] = $target\n";
                return true;
            }
        }
    }
    return false;
}

?>
