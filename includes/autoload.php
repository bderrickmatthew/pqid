<?php

function autoloader($className)
{
    $fileName = str_replace(search: '\\', replace: '/', subject: $className) . '.php';

    $file = __DIR__ . '/../' . $fileName;

    include $file;
}

spl_autoload_register(callback: 'autoloader');