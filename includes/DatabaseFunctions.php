<?php

include __DIR__ . '/DatabaseConnection.php';

function totalQuotes($database): mixed
{
    $stmt = $database->prepare('SELECT COUNT(*) FROM `quotes`');
    $stmt->execute();

    $row = $stmt->fetch();

    return $row[0];
}
function getQuote($pdo, $quoteId): mixed
{
    $stmt = $pdo->prepare('SELECT * FROM `quotes` WHERE `id` = :id');
    $values = [
        'id' => $quoteId
    ];
    $stmt->execute($values);

    return $stmt->fetch();
}

function insertQuote($pdo, $quoteText, $authorId): void
{
    $stmt = $pdo->prepare('INSERT INTO `quotes` (`quote_text`, `author_id`)
                            VALUES (:quote_text, :author_id)');
    $values = [
        ':quote_text' => $quoteText,
        ':author_id' => $authorId
    ];
    $stmt->execute($values);
}

function updateQuote($pdo, $quoteId, $quoteText, $authorId): void
{
    $stmt = $pdo->prepare('UPDATE `quotes` SET
                            `author_id` = :author_id,
                            `quote_text` = :quote_text
                            WHERE `id` = :id');

    $values = [
        ':quote_text' => $quoteText,
        ':author_id' => $authorId,
        ':id' => $quoteId
    ];

    $stmt->execute($values);
}