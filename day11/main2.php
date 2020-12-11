<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$seats = [];
foreach ($lines as $i => $line) {
    $seats[] = str_split($line);
}

/*
If a seat is empty (L) and there are no occupied seats visible to it, the seat becomes occupied.
If a seat is occupied (#) and five or more seats visible to it are also occupied, the seat becomes empty.
Otherwise, the seat's state does not change.
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
                # how many visible occupied?
                $x = getVisibleMatches($i, $j, $seats);
                //print "$i $j has $x occupied\n";
                
                if ($x == 0) {
                    $newRow[] = '#';
                    $changes++;
                } else
                    $newRow[] = 'L';
                
            } elseif ($row[$j] == '#') {
                $x = getVisibleMatches($i, $j, $seats);
                if ($x >= 5) {
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

function getVisibleMatches($i, $j, $seats, $find = '#') {
    $count = 0;
    $count += checkDirectionOccupied($i, $j, $seats, 0, 1)
                + checkDirectionOccupied($i, $j, $seats, 1, 1)
                + checkDirectionOccupied($i, $j, $seats, 1, 0)
                + checkDirectionOccupied($i, $j, $seats, 1,-1)
                + checkDirectionOccupied($i, $j, $seats, 0,-1)
                + checkDirectionOccupied($i, $j, $seats,-1,-1)
                + checkDirectionOccupied($i, $j, $seats,-1, 0)
                + checkDirectionOccupied($i, $j, $seats,-1, 1);
    return $count;
}

function checkDirectionOccupied($i, $j, $seats, $stepH, $stepV, $match = '#') {
    //print "check direction starting $i,$j direction h,v $stepH,$stepV\n";
    $x = $j;
    $y = $i;
    $occupied = 0;
    while (true) {
        $x += $stepH;
        $y += $stepV;
        //print "checking row $y col $x\n";

        if ($y < 0 || $y > count($seats)-1)
            break;
        if ($x < 0 || $x > count($seats[$y])-1)
            break;

        if ($seats[$y][$x] == '#') {
            $occupied++;
            break;
        } elseif ($seats[$y][$x] == 'L') {
            break;
        }
    }
    return $occupied;
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
