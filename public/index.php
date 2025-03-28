<?php
try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../includes/DatabaseFunctions.php';

    $title = 'Home';

    // Get total number of quotes
    $totalQuotes = totalQuotes($pdo);

    // Fix template path by going up one level from public
    ob_start();
    include __DIR__ . '/../templates/home.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
}

include __DIR__ . '/../templates/layout.html.php';