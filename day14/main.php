<?php

if (count($argv) > 1)
    $input = $argv[1];
else
    $input = 'input';

$file = file_get_contents($input);
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$memory = [];

foreach ($lines as $l) {
    list($cmd, $arg) = explode(' = ', $l);
    if ($cmd == 'mask') {
        $mask = $arg;
    } else {
        preg_match('/^mem\[(\d+)\]/', $cmd, $matches);
        $address = (int)$matches[1];
        $num = (int)$arg;
        print "----\n$mask - $address => $num\n";

        // apply selective bitmask to num
        $maskedNum = applyBitmask($mask, $num);
        $memory[$address] = $maskedNum;
    }
}

$solution = array_sum($memory);
print "solution is $solution\n";

///////////////////////////////////////////////////

function applyBitmask($string, $v) {
    for ($i = strlen($string)-1; $i >= 0; $i--) {
        if ($string[$i] == 'X')
            continue;
        
        $m = 1 << (strlen($string) - $i - 1);
        if ($string[$i] == '0')
            $v = ~(~$v | $m); 
        elseif ($string[$i] == '1')
            $v = ($v | $m); 

        printf("%36b %d\n", $v, $v);
    }

    return $v;
}

?>
