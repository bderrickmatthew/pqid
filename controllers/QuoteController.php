<?php

class QuoteController
{
    public function __construct(private DatabaseTable $quotesTable, private DatabaseTable $authorsTable)
    {
    }

    public function list()
    {
        $title = 'Quote List';

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

        // get total quotes
        $totalQuotes = $this->quotesTable->total();

        // Output buffering for template
        ob_start();
        include __DIR__ . '/../templates/quotes.html.php';
        $output = ob_get_clean();

        return ['output' => $output, 'title' => $title];
    }

    public function home()
    {
        $title = 'MyQuoteStoria';


        ob_start();
        include __DIR__ . '/../templates/home.html.php';
        $output = ob_get_clean();

        return ['output' => $output, 'title' => $title];
    }

    public function delete()
    {
        $this->quotesTable->delete(field: 'id', value: $_POST['id']);
        header(header: 'location: index.php?action=list');
    }

    public function edit()
    {

        if (isset($_POST['quote'])) {
            $quote = $_POST['quote'];
            $quote['author_id'] = 1;


            $this->quotesTable->save(record: $quote);

            header(header: 'location: index.php?action=list');

        } else {

            if (isset($_GET['id'])) {
                $quote = find(pdo: $pdo, table: 'quotes', field: 'id', value: $_GET['id'])[0] ?? null;
            } else {
                $quote = null;
            }

            $title = 'Edit Joke';

            ob_start();

            include __DIR__ . '/../templates/editquote.html.php';

            $output = ob_get_clean();

            return ['output' => $output, 'title' => $title];
        }
    }
}