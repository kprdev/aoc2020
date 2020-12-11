<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$seats = [];
foreach ($lines as $i => $line) {
    $seats[] = str_split($line);
}

/*
-If a seat is empty (L) and there are no occupied seats adjacent to it, the seat becomes occupied.
-If a seat is occupied (#) and four or more seats adjacent to it are also occupied, the seat becomes empty.
-Otherwise, the seat's state does not change.
*/

$pass = 0;
while (true) {
    $pass++;
    print "============================================ pass $pass start ===========\n";
    $newSeats = [];
    $changes = 0;
    
    foreach ($seats as $i => $row) {
        $newRow = [];
        
        for ($j = 0; $j < count($row); $j++) {
            # seat is empty?
            if ($row[$j] == 'L') {
                # how many adjacent occupied?
                $x = getMatchingSeats($i, $j, $seats);
                //print "$i $j has $x occupied\n";
                if ($x == 0) {
                    $newRow[] = '#';
                    $changes++;
                } else
                    $newRow[] = 'L';
                
            } elseif ($row[$j] == '#') {
                $x = getMatchingSeats($i, $j, $seats);
                if ($x >= 4) {
                    $newRow[] = 'L';
                    $changes++;
                } else
                    $newRow[] = '#';
                
            } else {
                $newRow[] = '.';
            }
        }

        $newSeats[] = $newRow;
    }

    foreach ($newSeats as $row) {
        printArr($row);
    }

    if (!$changes)
        break;
    else
        $seats = $newSeats; 
}

$occupied = countSeats('#', $seats);
print "solution is $occupied.\n";


/////////////////////////////////////////////////

function getMatchingSeats($i, $j, $seats, $find = '#') {
    $count = 0;

    $count += checkRow($i-1, $j, $seats, false, $find);
    $count += checkRow($i  , $j, $seats, true, $find);
    $count += checkRow($i+1, $j, $seats, false, $find);

    return $count;
}

function checkRow($i, $j, $seats, $skipMiddle = false, $match) {
    $count = 0;

    if ($i < 0 || $i > count($seats)-1)
        return 0;
    for ($b = $j-1; $b <= $j + 1; $b++) {
        if ($b < 0 || $b > count($seats[$i])-1)
            continue;
        if ($skipMiddle && $b == $j) {
            continue;
        }
        if ($seats[$i][$b] == $match)
            $count++;
        
    }
    return $count;
}

function printArr($a) {
    $s = implode('',$a);
    print "$s\n";
}

function countSeats($find, $seats) {
    $count = 0;
    foreach ($seats as $i => $row) {
        foreach ($row as $j => $s) {
            if ($s == $find)
                $count++;
        }
    }
    return $count;
}

?>
