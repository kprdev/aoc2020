<?php

$file = file_get_contents('input');
$map = explode("\n", $file);
unset($map[count($map)-1]);

# each line is 31 characters long

$place = 29;
$trees = 0;
$right = 3;

foreach ($map as $i => $line) {
    $place = $place + $right;
    if ($place > strlen($line))
        $place = $place - strlen($line);
    $index = $place - 1;

    $repl = $line;
    $repl[$index] = 'O';

    if ($line[$index] == '#') {
        $trees++;
        $repl[$index] = 'X';
    }

    printf("%2d - %s %s %d\n", $place, $line, $repl, $trees);

}

print "trees hit is $trees.\n";

?>
