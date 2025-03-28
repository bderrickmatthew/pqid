<form action="" method="post">
    <input type="" name="quote_id" value="<?= $quote['id'] ?>">
    <label for="quote_text">Type your joke here: </label>
    <textarea name="quote_text" id="quote_text" cols="40" rows="3">
        <?= htmlspecialchars(string: $quote['quote_text'], flags: ENT_QUOTES, encoding: 'UTF-8'); ?>
    </textarea>
    <input type="submit" value="Save">
</form>