<!DOCTYPE html>
<html lang="<?php e($translation['code']) ?>" dir="<?php e($translation['dir']) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'">
    <meta name="generator" content="https://github.com/kub-berlin/kub-feedback">
    <title><?php e(translate('KuB Feedback')) ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <img src="/static/logo.svg" alt="Logo: KuB - Kontakt- und Beratungsstelle für Flüchtlinge und Migrant_innen e.V.">
        <nav aria-label="<?php e(translate('Sprachen')) ?>">
            <a href="?id=<?php e($id) ?>&lang=de" lang="de" hreflang="de" dir="ltr">Deutsch</a>
            <a href="?id=<?php e($id) ?>&lang=en" lang="en" hreflang="en" dir="ltr">English</a>
            <a href="?id=<?php e($id) ?>&lang=fr" lang="fr" hreflang="fr" dir="ltr">Français</a>
            <a href="?id=<?php e($id) ?>&lang=es" lang="es" hreflang="es" dir="ltr">Español</a>
            <a href="?id=<?php e($id) ?>&lang=ar" lang="ar" hreflang="ar" dir="rtl">العربية</a>
            <a href="?id=<?php e($id) ?>&lang=fa" lang="fa" hreflang="fa" dir="rtl">فارسی</a>
            <a href="?id=<?php e($id) ?>&lang=ru" lang="ru" hreflang="ru" dir="ltr">Русский</a>
        </nav>
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
                    <label><input type="radio" name="<?php e($name) ?>" value="2"> <?php e(translate('Stimme voll und ganz zu')) ?></label>
                    <label><input type="radio" name="<?php e($name) ?>" value="1"> <?php e(translate('Stimme zu')) ?></label>
                    <label><input type="radio" name="<?php e($name) ?>" value="0"> <?php e(translate('Neutral')) ?></label>
                    <label><input type="radio" name="<?php e($name) ?>" value="-1"> <?php e(translate('Stimme nicht zu')) ?></label>
                    <label><input type="radio" name="<?php e($name) ?>" value="-2"> <?php e(translate('Stimme überhaupt nicht zu')) ?></label>
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
