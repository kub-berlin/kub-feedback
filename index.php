<?php declare(strict_types=1);

include_once('translation.php');

$QUESTIONS = [
	'DK' => [
		translate('Waren die Informationen, die du in der Sprechstunde/bei der Anmeldung bekommen hast, klar und verständlich?'),
		translate('Wurdest du in dem Gespräch während der Sprechstunde aufgrund deiner Hautfarbe, deiner Religion, deines Geschlechts oder deiner Herkunft diskriminiert?'),
		translate('Hat der Kurs, den du besuchst/besucht hast, dir beim Deutschlernen weitergeholfen?'),
		translate('Wurdest du in dem Kurs, den du besuchst/besucht hast, aufgrund deiner Hautfarbe, deiner Religion, deines Geschlechts oder deiner Herkunft diskriminiert?'),
	],
	'RB' => [
		translate('Konntest du alle deine Fragen stellen?'),
		translate('Wurden alle deine Fragen beantwortet?'),
		translate('Hast du dich während der Beratung gut aufgehoben gefühlt?'),
		translate('Wie verständlich war die Beratung?'),
	],
];

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
