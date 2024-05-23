<?php declare(strict_types=1);

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

function parse_accept_language($accept_language)
{
	$result = array();
	$parts = array_map('trim', explode(',', $accept_language));
	foreach (array_reverse($parts) as $part) {
		if (str_contains($part, ';q=')) {
			[$lang, $q] = explode(';q=', $part, 2);
			$result[$lang] = floatval($q);
		} else {
			$result[$part] = 1;
		}
	}
	return $result;
}

function match_language($accept, $candidates, $fallback)
{
	$best = $fallback;
	$best_q = 0;
	foreach ($candidates as $lang) {
		foreach ($accept as $l => $q) {
			if (str_starts_with($lang, $l) && $q > $best_q) {
				$best = $lang;
				$best_q = $q;
			}
		}
	}
	return $best;
}

function get_preferred_language()
{
	$langs = ['de', 'en', 'fr', 'es', 'ar', 'fa', 'ru'];
	$accept = parse_accept_language($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
	return match_language($accept, $langs, $langs[0]);
}

function get_lang($code)
{
	$lang = parse_ini_file(__DIR__."/langs/$code.ini") ?? [];
	$lang['code'] = $code;
	return $lang;
}

$lang = get_lang(get_preferred_language());
$id = $_GET['id'];
$questions = $QUESTIONS[$id];

if (!$questions) {
	http_response_code(404);
	echo '404 Not Found';
	die();
}

function translate($string)
{
	return $lang[$string] ?? $string;
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

?><!DOCTYPE html>
<html lang="<?php e($lang['code']) ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Security-Policy" content="default-src 'self'">
	<title><?php e(translate('KuB Feedback')) ?></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<img src="/static/logo.svg" alt="KuB">
	</header>
	<?php if ($post) : ?>
		<p><?php e(translate('Deine Antworten wurden gespeichert. Vielen Dank!')) ?></p>
	<?php else : ?>
		<p><?php e(translate('Vielen Dank, dass du uns Feedback gibst! Das Feedback hilft uns dabei, unsere Angebote zu verbessern. Du musst uns nicht sagen, wer du bist.')) ?></p>
		<form method="post">
			<label>
				<?php e(translate('Wer hat dich beraten?')) ?>
				<input type="text" name="subject">
			</label>
			<input type="text" name="honey">
			<?php foreach ($questions as $name => $question) : ?>
				<fieldset>
					<legend><?php e($question) ?></legend>
					<label><input type="radio" name="<?php e($name) ?>" value="1"> <?php e(translate('Ja')) ?></label>
					<label><input type="radio" name="<?php e($name) ?>" value="0"> <?php e(translate('Neutral')) ?></label>
					<label><input type="radio" name="<?php e($name) ?>" value="-1"> <?php e(translate('Nein')) ?></label>
				</fieldset>
			<?php endforeach ?>
			<button><?php e(translate('Abschicken')) ?></button>
		</form>
	<?php endif ?>
	<footer>
		<a href="https://kub-berlin.org/impressum/"><?php e(translate('Impressum')) ?></a>
		&middot;
		<a href="https://kub-berlin.org/datenschutz/"><?php e(translate('Datenschutz')) ?></a>
	</footer>
</body>
</html>
