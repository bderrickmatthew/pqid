<?php

namespace App\Controllers;

use Seraph\DatabaseTable;

class Quote
{
    public function __construct(private DatabaseTable $quotesTable, private DatabaseTable $authorsTable)
    {
    }

    public function home()
    {
        $title = 'MyQuoteStoria';

        return [
            'template' => 'home.html.php',
            'title' => $title,
            'variables' => []
        ];
    }

    public function list()
    {
        // Get quotes from database
        $result = $this->quotesTable->findAll();

        $quotes = [];

        foreach ($result as $quote) {
            $author = $this->authorsTable->find(field: 'id', value: $quote['author_id'])[0];

            $quotes[] = [
                'id' => $quote['id'],
                'quote_text' => $quote['quote_text'],
                'created_at' => $quote['created_at'],
                'name' => $author['name'],
                'email' => $author['email'],
            ];
        }

        $title = 'Quote List';

        // get total quotes
        $totalQuotes = $this->quotesTable->total();

        return [
            'template' => 'quotes.html.php',
            'title' => $title,
            'variables' => [
                'totalQuotes' => $totalQuotes,
                'quotes' => $quotes,
            ]
        ];
    }


    public function deleteSubmit()
    {
        $this->quotesTable->delete(field: 'id', value: $_POST['id']);
        header(header: 'location: /quote/list');
    }

    public function editSubmit()
    {
        $quote = $_POST['quote'];
        $quote['author_id'] = 1;
        $this->quotesTable->save($quote);

        header('location: /quote/list');
    }

    public function edit($id = null)
    {
        if (isset($id)) {
            $quote = $this->quotesTable->find('id', $id)[0] ?? null;
        }

        $title = 'Edit Quote';

        return [
            'template' => 'editquote.html.php',
            'title' => $title,
            'variables' => [
                'quote' => $quote ?? null
            ]
        ];
    }
}