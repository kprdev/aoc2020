<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$records = [];
$currentrecord = [];
$people = 0;

foreach ($lines as $line) {
    if (strlen($line) == 0) {
        # create new record
        $records[] = $currentrecord;
        unset($currentrecord);
        $currentrecord = [];
        $people = 0;
    } else {
        $thisLine = [];
        # parse line
        for ($i = 0; $i < strlen($line); $i++) {
            $c = $line[$i];
            if (!array_key_exists($c,$thisLine))
                $thisLine[$c] = 1;
            else
                $thisLine[$c]++;
        }
        $people++;

        if ($people > 1) {
            $newrecord = array_intersect_key($thisLine, $currentrecord);
            $currentrecord = $newrecord;
        } else {
            $currentrecord = $thisLine;
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
