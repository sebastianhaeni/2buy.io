<?php
include __DIR__ . '/../../vendor/autoload.php';

$tplDir = __DIR__ . '/../templates';
$tmpDir = __DIR__ . '/cache/';
$loader = new Twig_Loader_Filesystem($tplDir);

// force auto-reload to always have the latest version of the template
$twig = new Twig_Environment($loader, array(
    'cache' => $tmpDir,
    'auto_reload' => true
));
$twig->addExtension(new Twig_Extensions_Extension_I18n());
// configure Twig the way you want

// iterate over all your templates
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($tplDir), RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
    // force compilation
    if ($file->isFile()) {
        $templateName = str_replace($tplDir, '', $file);
        $twig->loadTemplate($templateName);
    }
}

