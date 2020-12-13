<?php

$file = file_get_contents('input');
$lines = explode("\n", $file);
unset($lines[count($lines)-1]);

$boat = new boat(10, 1);

foreach ($lines as $l) {
    preg_match('/([a-zA-Z]{1})(\d{1,3})/', $l, $matches);
    $cmd = $matches[1];
    $num = (int)$matches[2];

    switch ($cmd) {
        case 'N':
        case 'S':
        case 'E':
        case 'W':
            $boat->moveWaypoint($cmd, $num); break;
        case 'L':
            $boat->rotateWaypoint(-$num); break;
        case 'R':
            $boat->rotateWaypoint($num); break;
        case 'F':
            $boat->moveShip($num); break;
    }

    $boat->debug();
}

$solution = $boat->manhattanDistance();
print "solution is $solution.\n";

///////////////////////////////////////////////////

class boat {
    public $posX;
    public $posY;
    public $wpX;
    public $wpY;

    function __construct($wpX,$wpY) {
        $this->posX = 0;
        $this->posY = 0;
        $this->wpX = $wpX;
        $this->wpY = $wpY;
    }

    function debug() {
        print "$this->posX $this->posY -- $this->wpX $this->wpY\n";
    }

    // Move towards waypoint.
    function moveShip($m) {
        $this->posX += $this->wpX * $m;
        $this->posY += $this->wpY * $m;

        return $this->manhattanDistance();
    }

    function moveWaypoint($dir, $amount) {
        switch ($dir) {
            case 'N':
                $this->wpY += $amount; break;
            case 'S':
                $this->wpY -= $amount; break;
            case 'E':
                $this->wpX += $amount; break;
            case 'W':
                $this->wpX -= $amount; break;
        }
        return $this->manhattanDistance();
    }

    // Rotate waypoint around the ship
    function rotateWaypoint($change) {
        $newX = 0;
        $newY = 0;

        switch ($change) {
            case -90:
            case 270:
                $newX = -$this->wpY;
                $newY =  $this->wpX;
                break;
            case -180:
            case 180:
                $newX = -$this->wpX;
                $newY = -$this->wpY;
                break;
            case -270:
            case 90:
                $newX =  $this->wpY;
                $newY = -$this->wpX;
                break;
        }

        $this->wpX = $newX;
        $this->wpY = $newY;
        return $this->manhattanDistance();
    }

    function manhattanDistance() {
        return abs($this->posX) + abs($this->posY);
    }
}

?>
