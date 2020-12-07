<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$bagmap = [];
foreach ($lines as $i => $l) {
    print "$i $l\n";
    $parts = explode(' bags contain ', $l);
    if ($parts[1] == 'no other bags.') {
        $bagmap[$parts[0]] = [];
        print_r($bagmap[$parts[0]]);
        continue;
    }
    $parts[1] = str_replace(' bags', '', substr($parts[1],0,-1));
    $parts[1] = str_replace(' bag', '', $parts[1]);
    $holds = explode(', ',$parts[1]);

    foreach ($holds as $h) {
        $i = strpos($h, ' ');
        $n = (int)substr($h, 0, $i);
        $key = substr($h, $i+1);
        $bagmap[$parts[0]][$key] = $n;
    }

    //print_r($bagmap[$parts[0]]);
}

//print_r($bagmap);

$solution = bagInColors("shiny gold", $bagmap);
print "solution is $solution\n";

/////////////////////////////////////////////////////////////////////////////

function bagInColors($findColor, $bagmap, $target = NULL, $depth = 0) {
    // return count of how many bags the color is in
    
    $count = 0;
    $pad = "";
    $pad = str_pad($pad, 2 * $depth, ".");
    if (is_null($target)) {
        foreach ($bagmap as $color => $bags) {
            $found = false;
            foreach ($bags as $subColor => $num) {
                if ($subColor == $findColor) {
                    $found = true;
                    break;
                } else {
                    if (bagInColors($findColor, $bagmap, $subColor, $depth+1)) {
                        $found = true;
                        break;
                    }
                }
            }
            if ($found)
                $count++;
        }
    } else {
        foreach ($bagmap[$target] as $subColor => $num) {
            if ($subColor == $findColor) {
                $count++;
            } else {
                if (bagInColors($findColor, $bagmap, $subColor, $depth+1))
                    $count++;
            }
        }
    }
    printf("%s %15s %15s %2d %d\n", $pad, $findColor, $target, $depth, $count);
    return $count;
}

?>
