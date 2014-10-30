<?php
/**
 * This script sets up gettext.
 */
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

// Use cookie setting
$lang = $request->cookies->getAlpha('lang');

// Detect best language to display
if (empty($lang) || ! in_array($lang, $config['i18n']['languages'])) {
    $lang = $request->getPreferredLanguage($config['i18n']['languages']);
}

// Set language
putenv('LC_ALL=' . $lang . '.UTF-8');
echo setlocale(LC_ALL, $lang );

// Specify the location of the translation tables
bindtextdomain('messages', __DIR__);
bind_textdomain_codeset('messages', 'UTF-8');

// Choose domain
textdomain('messages');

return $lang;