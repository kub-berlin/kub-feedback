<!DOCTYPE html>
<html lang="<?php e($translation['code']) ?>" dir="<?php e($translation['dir']) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'">
    <title><?php e(translate('KuB Feedback')) ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <img src="/static/logo.svg" alt="Logo: KuB - Kontakt- und Beratungsstelle für Flüchtlinge und Migrant_innen e.V.">
    </header>
    <?php if ($post) : ?>
        <p><?php e(translate('Deine Antworten wurden gespeichert. Vielen Dank!')) ?></p>
    <?php else : ?>
        <p><?php e(translate('Vielen Dank, dass du uns Feedback gibst! Das Feedback hilft uns dabei, unsere Angebote zu verbessern. Du musst uns nicht sagen, wer du bist.')) ?></p>
        <form method="post">
            <input type="text" name="honey">
            <?php foreach ($questions[$id] as $name => $question) : ?>
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
