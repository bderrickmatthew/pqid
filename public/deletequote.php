<?php

try {
    include __DIR__ . '/includes/DatabaseConnection.php';

    $sql = 'DELETE FROM `quotes` WHERE `id` = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $_POST['id']);
    $stmt->execute();

    header('location: quotes.php');
} catch (PDOException $e) {
    $title = 'An error has occurred';

    $output = 'Database Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/templates/layout.html.php';

$pdo = null;