<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$highestID = 0;
foreach ($lines as $i => $line) {
    list($row, $seat) = findSeat($line);

    $seatmap[$row][$seat] = 'X';

    $id = $row * 8 + $seat;
    if ($id > $highestID)
        $highestID = $id;
    print "$id   $highestID\n";
}

/////////////////////////////////////////////

function findSeat($line) {
    $rowMax = 128;
    $range = $rowMax / 2;
    var_dump($line);

    for ($i = 0; $i < 7; $i++) {

        if ($line[$i] == 'F')
            $rowMax = $rowMax - $range;
        elseif ($line[$i] == 'B')
            $rowMax = $rowMax;

        //printf("%3d %2d %s %3d - %3d\n", $rowMax, $range, $line[$i], $rowMax - $range, $rowMax - 1);
        $range = $range / 2;
    }
    $row = $rowMax - 1;

    $max = 8;
    $range = $max / 2;
    for ($i = 7; $i < 10; $i++) {
        if ($line[$i] == 'L')
            $max = $max - $range;
        
        //printf("%3d %2d %s %3d - %3d\n", $max, $range, $line[$i], $max - $range, $max - 1);
        $range = $range / 2;
    }
    $seat = $max - 1;

    return array($row, $seat);
}

?>
