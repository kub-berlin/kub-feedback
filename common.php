<?php declare(strict_types=1);

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

function get_language()
{
    $langs = ['de', 'en', 'fr', 'es', 'ar', 'fa', 'ru'];

    if (isset($_GET['lang']) && in_array($_GET['lang'], $langs)) {
        return $_GET['lang'];
    } elseif (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
        $accept = parse_accept_language($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        return match_language($accept, $langs, $langs[0]);
    } else {
        return $langs[0];
    }
}

function readcsv($file)
{
    $fh = fopen($file, 'r');
    $rows = [];
    if (empty($fh)) {
        return $rows;
    };
    while (($row = fgetcsv($fh)) !== false) {
        $rows[$row[0]] = $row[1];
    }
    fclose($fh);
    return $rows;
}

function get_translation($code)
{
    $translation = readcsv("translations/$code.csv");
    $translation['code'] = $code;
    $translation['dir'] = in_array($code, ['ar', 'fa']) ? 'rtl' : 'ltr';
    return $translation;
}

$translation = get_translation(get_language());

function translate($string)
{
    global $translation;
    return $translation[$string] ?? $string;
}

function e($string)
{
    echo htmlspecialchars(strval($string), ENT_QUOTES, 'UTF-8');
}
