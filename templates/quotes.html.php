<p><?= $totalQuotes ?> quotes have been submitted to MyQuoteStoria</p>
<?php foreach ($quotes as $quote): ?>
<blockquote>
    <p>
        <?= htmlspecialchars(string: $quote['quote_text'], flags: ENT_QUOTES, encoding: 'UTF-8'); ?>

        (by <a
            href="mailto:<?= htmlspecialchars(string: $quote['email'], flags: ENT_QUOTES, encoding: 'UTF-8'); ?>"><?= htmlspecialchars(string: $quote['name'], flags: ENT_QUOTES, encoding: 'UTF-8'); ?></a>)

        <a href="editjoke.php?id=<?= $quote['id'] ?>">Edit</a>
    </p>
    <form action="deletequote.php" method="post">
        <input type="hidden" name="id" value="<?= $quote['id'] ?>">
        <input type="submit" value="Delete">
    </form>
    </p>
</blockquote>
<?php endforeach; ?>