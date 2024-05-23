<?php declare(strict_types=1);

include_once('config.php');
include_once('common.php');

if ($_POST['token'] !== $token) {
    http_response_code(400);
    exit(0);
}

function group_answers($answers, $questions)
{
    $groups = [];
    foreach ($questions as $i => $q) {
        $groups[$q] = [];
        foreach ($answers as $row) {
            if ($row[$i] !== "") {
                $groups[$q][] = intval($row[$i]);
            }
        }
    }
    return $groups;
}

function average($values)
{
    return array_sum($values) / count($values);
}

function aggregate($values)
{
    $avg = average($values);
    $dists = [];
    foreach ($values as $v) {
        $dists[] = pow($v - $avg, 2);
    }
    $stdev = sqrt(average($dists));

    $s_avg = number_format($avg, 2);
    $s_stdev = number_format($stdev, 2);

    return "$s_avg ± $s_stdev";
}

function get_body($answers, $questions)
{
    $grouped = group_answers($answers, $questions);
    $body = "Das Feedback für diesen Monat:\n\n";
    foreach ($grouped as $question => $a) {
        $n = count($a);
        if ($n === 0) {
            $body .= "$question (keine Antworten)\n";
        } else {
            $stat = aggregate($a);
            $body .= "$question $stat ($n Antworten)\n";
        }
    }
    $body .= "(-1 = Nein, 1 = Ja)\n";
    return $body;
}

$month = date('Y-m', strtotime('-1 month'));
$prev_month = date('Y-m', strtotime('-2 months'));

foreach ($emails as $id => $to) {
    $path = "data/feedback_${id}_${month}.csv";
    $subject = "Feedback $id $month";
    if (file_exists($path)) {
        $body = get_body(readcsv($path), $questions[$id]);
    } else {
        $body = "Diesen Monat gab es kein Feedback";
    }
    mail($to, $subject, $body);
    echo "processed $path\n";

    $prev_path = "data/feedback_${id}_${prev_month}.csv";
    if (file_exists($prev_path)) {
        unlink($prev_path);
        echo "deleted $prev_path\n";
    }
}
