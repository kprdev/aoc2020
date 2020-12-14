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

        $addressMasked = applyRawMask($mask, $address);
        $floats = getFloats($addressMasked);

        foreach ($floats as $f) {
            $int = bindec($f);
            $memory[$int] = $num;
            //print "$int => $num\n";
        }
    }
}

$solution = array_sum($memory);
print "solution is $solution\n";

/////////////////////////////////////////////////////////////////

function applyRawMask($mask, $address) {
    $address = sprintf("%036b", $address);
    $newAdd = '';
    for ($i = 0; $i < strlen($mask); $i++) {
        if ($mask[$i] == 'X')
            $newAdd = $newAdd.'X';
        else {
            $a = (int)$mask[$i] | (int)$address[$i];
            $newAdd .= $a;
        }
    }
    return $newAdd;
}

function getFloats($string) {
    $c = substr_count($string, 'X');
    $max = pow(2, $c) - 1;

    $floats = [];
    for ($i = 0; $i <= $max; $i++) {
        $floats[] = buildFloat($string, $i, $c);
    }

    return $floats;
}

function buildFloat($string, $i, $c) {
    $k = -1;
    $format = '%0'.$c.'b';
    $chars = str_split(sprintf($format, $i));

    foreach ($chars as $ch) {
        $k = strpos($string, 'X', $k+1);
        $string[$k] = $ch;
    }

    return $string;
}

?>
