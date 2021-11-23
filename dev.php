<?php

require './loader.php';

use Darts\Сircular\PointCounter;
use Darts\Game;

$drop_limit = 5;
$player_list = [
    'Alex',
    'Oleg',
    'Victor',
    'Roman'
];
$radiuses = [
    1 => 10,
    5 => 5,
    10 => 1
];
$max_radius = max(array_keys($radiuses));

$pointcounter = new PointCounter();
$pointcounter->set_radius_point($radiuses);
$game = new Game($pointcounter);
$game->set_drop_limit($drop_limit);


foreach ($player_list as $value) {
    $game->join_player($value);
}

foreach ($player_list as $value) {
    for ($i = 0; $i < $drop_limit; $i++) {
        $x = mt_rand(0, $max_radius * 100) / 100;
        $y = mt_rand(0, $max_radius * 100) / 100;
        $game->drop_dart($value, $x, $y);
    }
}


print_r($game->get_result());
print_r($game->get_tech_result());
