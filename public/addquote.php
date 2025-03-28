<?php


if (isset($_POST['quote_text'])) {
    try {
        include __DIR__ . '/../includes/DatabaseConnection.php';
        include __DIR__ . '/../includes/DatabaseFunctions.php';

        insertQuote(pdo: $pdo, quoteText: $_POST['quote_text'], authorId: 1);


        header(header: 'Location: /quotes.php');
        exit();

    } catch (PDOException $e) {
        $title = 'An error has occurred';
        $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
    }
} else {

    $title = 'Add Quote';

    ob_start();

    include __DIR__ . '/../templates/addquote.html.php';

    $output = ob_get_clean();
}



include __DIR__ . '/../templates/layout.html.php';

$pdo = null;