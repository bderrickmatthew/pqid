<?php

$requestUri = $_SERVER['REQUEST_URI'];

// Static file serving
if (preg_match(pattern: '/\.(css|js|jpg|jpeg|png|gif)$/', subject: $requestUri)) {
    $filePath = __DIR__ . '/public' . $requestUri;

    if (file_exists(filename: $filePath) && is_readable(filename: $filePath)) {
        $fileExtension = pathinfo(path: $filePath, flags: PATHINFO_EXTENSION);
        $mimeTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ];

        header(header: 'Content-Type: ' . ($mimeTypes[$fileExtension] ?? 'application/octet-stream'));
        readfile(filename: $filePath);
        exit; // Stop further processing
    } else {
        http_response_code(response_code: 404);
        echo '404 File Not Found';
        exit;
    }
}

// Application routing
$uri = parse_url(url: $requestUri, component: PHP_URL_PATH);
$uri = ltrim(string: str_replace(search: '/public/', replace: '/', subject: $uri), characters: '/');

$allowedFiles = [
    'index.php',
    'quotes.php',
    'editquote.php',
    'deletequote.php',
    'addquote.php'
    // Add other allowed files
];

if (in_array(needle: $uri, haystack: $allowedFiles) && file_exists(filename: __DIR__ . '/public/' . $uri)) {
    chdir(directory: __DIR__ . '/public');
    require $uri;
} else {
    chdir(directory: __DIR__ . '/public');
    require 'index.php'; // Default fallback
}