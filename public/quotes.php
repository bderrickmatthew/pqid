<?php

try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../includes/DatabaseFunctions.php';

    $title = 'Quote List';

    $sql = 'SELECT `quotes`.`id`, `quote_text`, `name`, `email` 
            FROM `quotes` INNER JOIN `authors`
            ON `author_id` = `authors`.`id`';
    // Get quotes from database
    $result = $pdo->query($sql);
    $quotes = $result->fetchAll();

    // get total quotes
    $totalQuotes = totalQuotes($pdo);

    // Output buffering for template
    ob_start();
    include __DIR__ . '/../templates/quotes.html.php';
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/../templates/layout.html.php';

$pdo = null;