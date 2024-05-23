<?php declare(strict_types=1);

include_once('config.php');
include_once('translation.php');

function e($string)
{
    echo htmlspecialchars(strval($string), ENT_QUOTES, 'UTF-8');
}

$id = $_GET['id'];
$questions = $QUESTIONS[$id];

if (!$questions) {
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
    $path = "feedback_${id}_${month}.csv";
    $row = implode(',', array_map(function($name) {
        return '"'.$_POST[$name].'"';
    }, array_keys($questions)));
    file_put_contents($path, "$row\n", FILE_APPEND | LOCK_EX);
}

include('form.php');
