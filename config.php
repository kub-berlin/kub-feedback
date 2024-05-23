<?php declare(strict_types=1);

$token = 'CHANGME';

$emails = [
	'DK' => 'test@example.com',
	'RB' => 'test@example.com',
]

$questions = [
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
