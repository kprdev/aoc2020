<?php

$time_start = microtime(true); 

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$nums = [];
foreach ($lines as $l) {
    $nums[] = (int)$l;
}

// answer from part 1
$targetsum = 375054920;

$count = 0;
foreach ($nums as $i => $n) {
    for ($j = $i+1; $j < count($nums); $j++) {

        $list = array_slice($nums, $i, $j - $i);
        print "$count\r"; $count++;

        $sum = array_sum($list);
        if ($sum == $targetsum) {
            $a = min($list);
            $b = max($list);
            $c = $a + $b;
            print "\nlist found at position $i to $j, min $a max $b for answer $c\n";
            print_r($list);
            echo 'Total execution time in seconds: ' . (microtime(true) - $time_start) . "\n";
            die;
        }
    }
}

?>
