<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$wpx = 10;
$wpy = 1;

$x = 0;
$y = 0;
$deg = 90;

foreach ($lines as $l) {
    preg_match('/([a-zA-Z]{1})(\d{1,3})/', $l, $matches);
    $cmd = $matches[1];
    $num = (int)$matches[2];

    switch ($cmd) {
        case 'N':
            $wpy += $num; break;
        case 'S':
            $wpy -= $num; break;
        case 'E':
            $wpx += $num; break;
        case 'W':
            $wpx -= $num; break;
        case 'L':
            list ($wpx, $wpy) = rotateWaypoints($wpx, $wpy, -$num);
            break;
        case 'R':
            list ($wpx, $wpy) = rotateWaypoints($wpx, $wpy, $num);
            break;
        case 'F':
            $x += $wpx * $num;
            $y += $wpy * $num;
            break;
    }
}

$solution = manhattanDistance($x, $y);
print "solution is $solution.\n";

///////////////////////////////////////////////////

function rotateWaypoints($x, $y, $deg) {
    $newX = 0;
    $newY = 0;

    switch ($deg) {
        case -90:
        case 270:
            $newX = -$y;
            $newY = $x;
            break;
        case -180:
        case 180:
            $newX = -$x;
            $newY = -$y;
            break;
        case -270:
        case 90:
            $newX = $y;
            $newY = -$x;
            break;
    }

    return array($newX, $newY);
}

function manhattanDistance($x, $y) {
    return abs($x) + abs($y);
}

?>
