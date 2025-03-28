<?php

try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../includes/DatabaseFunctions.php';

    if (isset($_POST['quote_text'])) {
        updateQuote(pdo: $pdo, quoteId: $_POST['quote_id'], quoteText: $_POST['quote_text'], authorId: 1);

        header(header: 'location:quotes.php');
    } else {
        $quote = getQuote(pdo: $pdo, quoteId: $_GET['id']);

        $title = 'Edit Joke';

        ob_start();

        include __DIR__ . '/../templates/editquote.html.php';

        $output = ob_get_clean();
    }

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/../templates/layout.html.php';

$pdo = null;