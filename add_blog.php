<?php include("functies.php"); ?>
<?php include("includes/header.php"); ?>

<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = addBlogPost(
        $_POST['title'],
        $_POST['author'],
        $_POST['post_date'],
        $_POST['category_id'],
        $_POST['content']
    );

    if ($result === true) {
        $message = "Blog post toegevoegd!";
    } else {
        $message = $result;
    }
}
?>

<div class="form-box">
    <h2>Nieuwe blog toevoegen</h2>

    <?php if ($message != ""): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="title" placeholder="Titel" required>
        <input type="text" name="author" placeholder="Auteur" required>
        <input type="date" name="post_date" required>

        <select name="category_id" required>
            <option value="">Kies een categorie</option>
            <option value="1">New Products</option>
            <option value="2">Game Reviews</option>
            <option value="3">Console Reviews</option>
        </select>

        <textarea name="content" placeholder="Inhoud" required></textarea>
        <button type="submit">Opslaan</button>
    </form>
</div>

<?php include("includes/footer.php"); ?>