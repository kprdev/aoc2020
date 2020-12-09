<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

#passports fields separated by spaces, passports separated by lines

# parse into records
$records = [];
$newrecord = [];
$currentrecord = [];

foreach ($lines as $line) {
    if (strlen($line) == 0) {
        # create new record
        $records[] = $currentrecord;
        unset($currentrecord);
        $currentrecord = [];
    } else {
        # parse line
        $parts = explode(" ", $line);
        foreach ($parts as $p) {
            list ($key, $val) = explode(":", $p);
            $currentrecord[$key] = $val;
        }
    }
}

$records[] = $currentrecord;

# look for valid passports
# missing cid is ok
# missing other fields is invalid

$valid = 0;
$reqKeys = array('byr','iyr','eyr','hgt','hcl','ecl','pid');
foreach ($records as $i => $r) {
    if (count(array_intersect($reqKeys, array_keys($r))) == 7)
        $valid++;

    var_dump($r);
    print $valid . "\n";
}

print "valid count is $valid\n";

?>
