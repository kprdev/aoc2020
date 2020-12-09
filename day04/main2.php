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
    if (count(array_intersect($reqKeys, array_keys($r))) == 7) {
        $fails = 0;

        #check field values
        $val = (int)$r['byr'];
        if ($val < 1920 || $val > 2002) {
            $fails++;
        }
        
        $iyr = (int)$r['iyr'];
        if ($iyr < 2010 || $iyr > 2020) {
            $fails++;
        }
    
        $eyr = (int)$r['eyr'];
        if ($eyr < 2020 || $eyr > 2030) {
            $fails++;
        }

        $hgt = $r['hgt'];
        if (preg_match('/([0-9]{2,3})(cm|in)/', $hgt, $matches)) {
            $num = $matches[1];
            $unit = $matches[2];

            if ($unit == 'cm') {
                if ($num < 150 || $num > 193) {
                    $fails++;
                }
            } elseif ($unit == 'in') {
                if ($num < 59 || $num > 76) {
                    $fails++;
                }
            }
        } else {
            $fails++;
        }

        $hcl = $r['hcl'];
        if (!preg_match('/#[a-zA-Z0-9]{6}/', $hcl)) {
            $fails++;
        }

        $ecl = $r['ecl'];
        if (!preg_match('/(amb|blu|brn|gry|grn|hzl|oth)/', $ecl)) {
            $fails++;
        }

        $pid = $r['pid'];
        if (!preg_match('/^[0-9]{9}$/', $pid)) {
            $fails++;
        }

        if ($fails) {
            continue;
        }


        $valid++;
        //printf("byr:%s iyr:%s eyr:%s hgt:%5s hcl:%s ecl:%s pid:%s\n", 
        //    $r['byr'], $r['iyr'], $r['eyr'], $r['hgt'], 
        //    $r['hcl'], $r['ecl'], $r['pid']);
    }
    else {
        //print_r($r);
        //print "passport $i missing fields\n";
    }
}

print "valid count is $valid\n";

?>
