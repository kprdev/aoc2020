<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$x = 0;
$y = 0;
$deg = 90;

foreach ($lines as $l) {
    preg_match('/([a-zA-Z]{1})(\d{1,3})/', $l, $matches);
    $cmd = $matches[1];
    $num = (int)$matches[2];

    switch ($cmd) {
        case 'N':
            $y += $num; break;
        case 'S':
            $y -= $num; break;
        case 'E':
            $x += $num; break;
        case 'W':
            $x -= $num; break;
        case 'L':
            $deg = rotateShip($deg, -$num);
            break;
        case 'R':
            $deg = rotateShip($deg, $num);
            break;
        case 'F':
            switch ($deg) {
                case 0:
                    $y += $num; break;
                case 180:
                    $y -= $num; break;
                case 90:
                    $x += $num; break;
                case 270:
                    $x -= $num; break;
            }
    }
}

$solution = manhattanDistance($x, $y);
print "solution is $solution.\n";

///////////////////////////////////////////////////

function rotateShip($current, $change) {
    $new = $current + $change;

    if ($new < 0)
        $new += 360;
    elseif ($new >= 360)
        $new -= 360;

    return $new;
}

function manhattanDistance($x, $y) {
    return abs($x) + abs($y);
}

?>
