<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

# PART 2 ============================================================
# Fix the program so that it terminates normally by 
# changing exactly one jmp (to nop) or nop (to jmp). 
# What is the value of the accumulator after the program terminates?

foreach ($lines as $j => $line) {
    $orig = $line;
    if (substr($line, 0, 3) == 'acc') {
        continue;
    } elseif (substr($line, 0 , 3) == 'nop')  {
        $lines[$j] = str_replace('nop', 'jmp', $line);
        if (!findLoop($lines))
            break;
        $lines[$j] = $orig;
    } elseif (substr($line, 0, 3) == 'jmp') {
        $lines[$j] = str_replace('jmp', 'nop', $line);
        if (!findLoop($lines))
            break;
        $lines[$j] = $orig;
    }
}

/////////////////////////////////////////////////////////////////////

function findLoop($lines) {
    $accumulator = 0;
    $linelog = [];
    $i = 0;
    while (true) {
        if (array_key_exists($i, $linelog)) {
            print "line $i repeating, accumulator is $accumulator\n";
            return true;
        }

        if ($i == count($lines)) {
            print "program finished. accumulator is $accumulator\n";
            return false;
        }

        $line = $lines[$i];
        $cmd = substr($line,0,3);
        $num = (int)substr($line,4);

        $linelog[$i] = 1;
        
        // process command
        if ($cmd == 'acc') {
            $accumulator += $num;
            //print "acc $num, new accumulator value is $accumulator\n";
            $i++;
        } elseif ($cmd == 'jmp') {
            $i += $num;
            //print "jmp $num, new command at $i\n";
        } elseif ($cmd == 'nop') {
            //print "nop ------\n";
            $i++;
        }
    }
}

?>
