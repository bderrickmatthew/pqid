<?php

namespace App;

use Seraph\DatabaseTable;
use App\Controllers\Quote;
use App\Controllers\Author;
use PDO;

class QuoteWebsite
{
    public function getDefaultRoute()
    {
        return "quote/home";
    }

    public function getController(string $controllerName)
    {
        $pdo = new PDO(dsn: "mysql:host=localhost;dbname=quotes_db;port=3307;charset=utf8mb4", username: "root", password:
            "root");

        $quotesTable = new DatabaseTable(pdo: $pdo, table: 'quotes', primaryKey: 'id');
        $authorsTable = new DatabaseTable(pdo: $pdo, table: 'authors', primaryKey: 'id');

        ///
        if ($controllerName === 'quote') {
            $controller = new Quote(quotesTable: $quotesTable, authorsTable: $authorsTable);
        } elseif ($controllerName === 'author') {
            $controller = new Author(authorsTable: $authorsTable);
        }

        return $controller;
    }
}