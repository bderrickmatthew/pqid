<?php
try {
    include __DIR__ . '/../includes/DatabaseConnection.php';
    include __DIR__ . '/../classes/DatabaseTable.php';
    include __DIR__ . '/../controllers/QuoteController.php';

    $quotesTable = new DatabaseTable(pdo: $pdo, table: 'quotes', primaryKey: 'id');
    $authorsTable = new DatabaseTable(pdo: $pdo, table: 'authors', primaryKey: 'id');

    $quoteController = new QuoteController(quotesTable: $quotesTable, authorsTable: $authorsTable);

    $action = $_GET['action'] ?? 'home';

    $page = $quoteController->$action();

    $title = $page['title'];
    $output = $page['output'];

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage();
}

include __DIR__ . '/../templates/layout.html.php';