<?php

use App\QuoteWebsite;
use Seraph\EntryPoint;

include __DIR__ . '/includes/autoload.php';

$uri = strtok(string: ltrim(string: $_SERVER['REQUEST_URI'], characters: '/'), token: '?');

$quoteWebsite = new QuoteWebsite();
$entryPoint = new EntryPoint(website: $quoteWebsite);
$entryPoint->run(uri: $uri);