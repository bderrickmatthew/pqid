<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--CSS-->
    <link rel="stylesheet" href="/base.css">

    <title><?= $title ?></title>
</head>

<body>
    <header>MyQuoteStoria</header>
    <nav>
        <ul>
            <li><a href="/index.php">Home</a></li>
            <li><a href="/quotes.php">Quotes List</a></li>
            <li><a href="/addquote.php">Add a new Quote</a></li>
        </ul>
    </nav>

    <main>
        <?= $output ?>
    </main>

    <footer>
        &copy; MyQuoteStoria 2025
    </footer>

</body>

</html>