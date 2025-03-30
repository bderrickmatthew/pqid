<?php

use App\QuoteWebsite;
use Seraph\EntryPoint;

# include __DIR__ . '/includes/autoload.php';
require __DIR__ . '/vendor/autoload.php';

$uri = ltrim(string: parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), characters: '/');
#$uri = strtok(string: ltrim(string: $_SERVER['REQUEST_URI'], characters: '/'), token: '?');

if ($uri == 'index.php') {
    header(header: 'Location: /');
    exit;
}

$quoteWebsite = new QuoteWebsite();
$entryPoint = new EntryPoint(website: $quoteWebsite);
$entryPoint->run(uri: $uri, method: $_SERVER['REQUEST_METHOD']);