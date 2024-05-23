<?php declare(strict_types=1);

include_once('config.php');
include_once('common.php');

$id = $_GET['id'];

if (!isset($questions[$id])) {
    http_response_code(404);
    echo '404 Not Found';
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post = true;

    // spam protection
    if ($_POST['honey'] != '') {
        die();
    }

    $month = date('Y-m');
    $path = "data/feedback_${id}_${month}.csv";
    $row = implode(',', array_map(function ($name) {
        return '"'.$_POST[$name].'"';
    }, array_keys($questions[$id])));
    file_put_contents($path, "$row\n", FILE_APPEND | LOCK_EX);
}

include('form.php');
