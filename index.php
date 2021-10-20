<?php

include 'vendor/autoload.php';

use Carbon\Carbon;
use Carbon\CarbonInterval;

$top_level_stuff = JsonMachine\JsonMachine::fromFile('wakatime-dnorgarbgmail.com-6757f838ed894ae78208a0883665098a.json');


// [git@github.com:DevinNorgarb/wakadump-parser.git
//     "categories" => array:1 [
//       0 => array:9 [
//         "decimal" => "6.73"
//         "digital" => "6:44:44"
//         "hours" => 6
//         "minutes" => 44
//         "name" => "Coding"
//         "percent" => 100.0
//         "seconds" => 44
//         "text" => "6 hrs 44 mins"
//         "total_seconds" => 24284.890617132
//       ]
//     ]
$total_seconds = 0;
foreach($top_level_stuff as $k => $level_property) {
    if($k == 'days') {
        foreach($level_property as $num_day => $day) {
            if(isset($day['categories'][0])) {
                $total_seconds += $day['categories'][0]['total_seconds'];
            }
        }
    }
}

$time_behind_pc = CarbonInterval::seconds($total_seconds)->cascade()->forHumans();


$dt = Carbon::now();
$days = $dt->diffInDays($dt->copy()->addSeconds($total_seconds));
$hours = $dt->diffInHours($dt->copy()->addSeconds($total_seconds));
$minutes = $dt->diffInMinutes($dt->copy()->addSeconds($total_seconds));


dump(
 "Total in days ". $days . PHP_EOL.
 "Total in hours ". $hours . PHP_EOL .
 "Total in minutes ". $minutes . PHP_EOL);
dump("-----------------");
dump($time_behind_pc);
