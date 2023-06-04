<?php
    ini_set('memory_limit', '1024M');

    include 'vendor/autoload.php';

    use Carbon\Carbon;
    use Carbon\CarbonInterval;

    if ($argc < 2) {
        echo "Please provide the JSON file name as a command-line argument.\n";
        exit(1);
    }

    $jsonFile = $argv[1];
    $top_level_stuff = JsonMachine\JsonMachine::fromFile($jsonFile);

    $total_seconds = 0;
    $total_seconds_by_category = [];
    $total_seconds_by_language = [];
    $total_seconds_by_project = [];

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


                if (isset($day['projects'][0])) {
                    foreach ($day['projects'] as $key => $project) {
                        $project_name = $project['name'];
//                    dump($project_name . ': ' . $project['grand_total']['total_seconds']);
                        $project_seconds = $project['grand_total']['total_seconds'];
                        $total_seconds += $project_seconds;

                        if (!isset($total_seconds_by_project[$project_name])) {
                            $total_seconds_by_project[$project_name] = 0;
                        }
                        $total_seconds_by_project[$project_name] += $project_seconds;
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

    echo 'Total time tracked: ' . "\n";
    echo '-------------------' . "\n";
    echo 'Total in days: ' . $days . "\n";
    echo 'Total in hours: ' . $hours . "\n";
    echo 'Total in minutes: ' . $minutes . "\n";
    echo 'Total time behind PC: ' . $time_behind_pc . "\n";

    echo '-------------------' . "\n";
    echo 'Time tracked by category:' . "\n";
    $total_number_of_seconds_by_category_for_humans = [];
    foreach ($total_seconds_by_category as $category_name => $category_seconds) {
        $category_time = CarbonInterval::seconds($category_seconds)->cascade()->forHumans();
        $total_number_of_seconds_by_category_for_humans[$category_name] = $category_time;

    }

    dump( '-------------------' . "\n");
    dump( 'Time tracked by language:' . "\n");
    $total_number_of_seconds_by_language_for_humans = [];
    foreach ($total_seconds_by_language as $language_name => $language_seconds) {
        $language_time = CarbonInterval::seconds($language_seconds)->cascade()->forHumans();
        $total_number_of_seconds_by_language_for_humans[$language_name] = $language_time;

    }

    dump( '-------------------' . "\n");
    dump( 'Time tracked by project:' . "\n");
    $total_number_of_seconds_by_project_for_humans = [];
    foreach ($total_seconds_by_project as $project_name => $project_seconds) {
        $project_time = CarbonInterval::seconds($project_seconds)->cascade()->forHumans();
        $total_number_of_seconds_by_project_for_humans[$project_name] = $project_time;

    }
    dump($total_number_of_seconds_by_category_for_humans, $total_number_of_seconds_by_language_for_humans, $total_number_of_seconds_by_project_for_humans);
?>
