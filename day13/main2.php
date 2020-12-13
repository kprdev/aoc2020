<?php

if (count($argv) > 1)
    $input = $argv[1];
else
    $input = 'input';

$file = file_get_contents($input);
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$busses = []; 
foreach (explode(',',$lines[1]) as $i => $ids) {
    if ($num = (int)$ids)
        $busses[] = $num;
    else
        $busses[] = 0;
}

print_r($busses);


$jump = $busses[0];
$instanceTimecode = getNextDividend(1, $jump);
$maxFound = 1;

$c = count($busses);
while (true) {
    $found = 0;
    $sm = 0;

    foreach ($busses as $i => $b) {
        if ($b == 0) {
            $found++;
            continue;
        }

        $timecode = $instanceTimecode + $i;

        if ($timecode % $b == 0) {
            if ($i == 0)
                print "----\n";
            $found++;
            $stars = str_repeat('***', ++$sm);
            
            if ($found > $maxFound) {
                $maxFound = $found;
                $jump = $jump * $b;
            }
        } else {
            break;
        }
        
        print "tc $timecode found $found ($i => $b)  $jump $stars\n";
    }

    if ($found == $c) {
        break;
    }

    $instanceTimecode += $jump;
}

$solution = $instanceTimecode;
print "solution is $solution\n";

////////////////////////////////////////////////////////////////

function getNextDividend($startingAt, $divisor) {
    $x = (int)($startingAt / $divisor);
    $dividend = ($x + 1) * $divisor;
    //print "$startingAt ... $x ... $dividend\n";

    return $dividend;
}

?>
