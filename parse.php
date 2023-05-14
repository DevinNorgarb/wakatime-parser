<?php
ini_set('memory_limit', '1024M');

include 'vendor/autoload.php';

use Carbon\Carbon;
use Carbon\CarbonInterval;

$top_level_stuff = JsonMachine\JsonMachine::fromFile('wakatime-dnorgarbgmail.com-6757f838ed894ae78208a0883665098a.json');

$total_seconds = 0;
$total_seconds_by_category = [];
$total_seconds_by_language = [];

foreach ($top_level_stuff as $k => $level_property) {
    if ($k == 'days') {
        foreach ($level_property as $num_day => $day) {
            if (isset($day['categories'][0])) {
                $category_name = $day['categories'][0]['name'];
                $category_seconds = $day['categories'][0]['total_seconds'];
                $total_seconds += $category_seconds;

                if (!isset($total_seconds_by_category[$category_name])) {
                    $total_seconds_by_category[$category_name] = 0;
                }
                $total_seconds_by_category[$category_name] += $category_seconds;
            }

            if (isset($day['languages'][0])) {
                foreach ($day['languages'] as $key => $langs) {
                    $language_name = $langs['name'];
                    $language_seconds = $langs['total_seconds'];
                    $total_seconds += $language_seconds;

                    if (!isset($total_seconds_by_language[$language_name])) {
                        $total_seconds_by_language[$language_name] = 0;
                    }
                    $total_seconds_by_language[$language_name] += $language_seconds;
                }
            }
        }
    }
}

$time_behind_pc = CarbonInterval::seconds($total_seconds)->cascade()->forHumans();

$dt = Carbon::now();
$days = $dt->diffInDays($dt->copy()->addSeconds($total_seconds));
$hours = $dt->diffInHours($dt->copy()->addSeconds($total_seconds));
$minutes = $dt->diffInMinutes($dt->copy()->addSeconds($total_seconds));

dump('Total time tracked: ');
dump('-------------------');
dump('Total in days: ' . $days);
dump('Total in hours: ' . $hours);
dump('Total in minutes: ' . $minutes);
dump('Total time behind PC: ' . $time_behind_pc);

dump('-------------------');
dump('Time tracked by category:');
foreach ($total_seconds_by_category as $category_name => $category_seconds) {
    $category_time = CarbonInterval::seconds($category_seconds)->cascade()->forHumans();
    dump($category_name . ': ' . $category_time);
}

dump('-------------------');
dump('Time tracked by language:');
foreach ($total_seconds_by_language as $language_name => $language_seconds) {
    $language_time = CarbonInterval::seconds($language_seconds)->cascade()->forHumans();
    dump($language_name . ': ' . $language_time);
}
