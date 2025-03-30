<form action="" method="post">
    <input type="hidden" name="quote[id]" value="<?= $quote['id'] ?? '' ?>">
    <label for="quote_text">Type your joke here: </label>
    <textarea name="quote[quote_text]" id="quote_text" cols="40" rows="3">
        <?= $quote['quote_text'] ?? '' ?>
    </textarea>
    <input type="submit" name="submit" value="Save">
</form>