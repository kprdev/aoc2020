<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);

$items = [];

unset($lines[count($lines)-1]);
foreach ($lines as $i => $line) {
    $parts = explode(' ', $line);
    $limits = explode('-', $parts[0]);

    $item['lo'] = (int)$limits[0];
    $item['hi'] = (int)$limits[1];
    $item['al'] = $parts[1][0];
    $item['pw'] = $parts[2];

    $items[] = $item;
}

print (count($lines) . " lines of input\n");
print (count($items) . " items parsed\n");
unset($lines);

# count valid passwords
$count = 0;

foreach ($items as $i => $item) {
    str_replace($item['al'], '^', $item['pw'], $c);

    if ($item['pw'][$item['lo'] - 1] == $item['al'] xor
        $item['pw'][$item['hi'] - 1] == $item['al']) 
    {
        $count++;
    }
}

print ("Found $count good passwords.\n");

?>
