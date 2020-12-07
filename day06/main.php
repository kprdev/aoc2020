<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$records = [];
$currentrecord = [];

foreach ($lines as $line) {
    if (strlen($line) == 0) {
        # create new record
        $records[] = $currentrecord;
        unset($currentrecord);
        $currentrecord = [];
    } else {
        # parse line
        for ($i = 0; $i < strlen($line); $i++) {
            $c = $line[$i];
            if (!array_key_exists($c,$currentrecord))
                $currentrecord[$c] = 1;
            else
                $currentrecord[$c]++;
        }
    }
}
$records[] = $currentrecord;

# count total
$total = 0;
foreach ($records as $r) {
    $total = $total + count($r);
}

print "total is $total\n";
?>
