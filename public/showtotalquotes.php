<?php

if (file_exists(__DIR__ . '/includes/DatabaseConnection.php'))
    echo "here i am";
else
    echo "nara";
include_once __DIR__ . '/includes/DatabaseConnection.php';
include_once __DIR__ . '/includes/DatabaseFunctions.php';


echo totalQuotes($pdo);