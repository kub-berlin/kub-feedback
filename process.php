<?php declare(strict_types=1);

include_once('config.php');

function send_mail_with_attachment($to, $subject, $message, $attachment) {
    // https://stackoverflow.com/questions/12301358

    $boundary = md5('whatever');

    $additional_headers = [
        'MIME-Version' => '1.0',
        'Content-Type' => "multipart/mixed; boundary=$boundary",
    ];

    $body .= "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= "$message\r\n\r\n";

    $body .= "--$boundary\r\n";
    $body .= "Content-Type: text/csv; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$attachment\"\r\n\r\n";
    $body .= file_get_contents($attachment) . "\r\n\r\n";
    $body .= "--$boundary--";

    return mail($to, $subject, $body, $additional_headers);
}

if ($_POST['token'] !== $token) {
    http_response_code(400);
    exit(0);
}

$month = date('Y-m', strtotime('-1 month'));
$prev_month = date('Y-m', strtotime('-2 months'));

foreach ($emails as $id => $to) {
    $path = "feedback_${id}_${month}.csv";
    $subject = "Feedback $id $month";
    if (file_exists($path)) {
        send_mail_with_attachment($to, $subject, "Im Anhang findet ihr das Feedback für diesen Monat.", $path);
        echo "sent $path";
    } else {
        mail($to, $subject, "Diesen Monat gab es kein Feedback");
    }

    $prev_path = "feedback_${id}_${prev_month}.csv";
    if (file_exists($prev_path)) {
        unlink($prev_path);
        echo "deleted $prev_path";
    }
}
