<?php
// Serve static files directly
if (preg_match('/\.(?:css|js|jpg|jpeg|png|gif)$/', $_SERVER["REQUEST_URI"])) {
    $file = __DIR__ . '/public' . $_SERVER["REQUEST_URI"];
    if (file_exists($file)) {
        // Set correct content type header
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        switch ($extension) {
            case 'css':
                header('Content-Type: text/css');
                break;
            case 'js':
                header('Content-Type: application/javascript');
                break;
            // Add other content types as needed
        }
        readfile($file);
        return true;
    }
    return false;
}

// Remove /public/ from the URI if present
$uri = str_replace('/public/', '/', $_SERVER['REQUEST_URI']);

// Set the base path for includes
chdir(__DIR__ . '/public');

// Include the requested file
$file = 'index.php';
if ($uri !== '/') {
    $file = ltrim($uri, '/');
}

if (file_exists($file)) {
    require $file;
} else {
    require 'index.php';
}