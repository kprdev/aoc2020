<?php

$file = file_get_contents('input');
$map = explode("\n", $file);
unset($map[count($map)-1]);

$slopes = array( [1,1] , [3,1] , [5,1] , [7,1] , [1,2] );
$product = 1;

foreach ($slopes as $s) {
    list( $right, $down ) = $s;
    print "right $right down $down \n";

    $trees = 0;
    
    for ($i = 0; $i < count($map); $i = $i + $down) {
        $line = $map[$i];
        $place = $i > 0 ? $place + $right : 1;
    
        if ($place > strlen($line))
            $place = $place - strlen($line);
        $index = $place - 1;

        $repl = $line;
        $repl[$index] = 'O';
    
        if ($line[$index] == '#') {
            $trees++;
            $repl[$index] = 'X';
        }
        //printf("%3d : %2d - %s %s %d\n", $i, $place, $line, $repl, $trees);
    }
    
    print "trees hit is $trees.\n";
    print "--------------------------------------------------------\n";
    $product *= $trees;
}

print "answer is $product.\n";

?>
