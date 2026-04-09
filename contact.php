<?php include("functies.php"); ?>
<?php include("includes/header.php"); ?>

<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (addContactMessage($_POST['name'], $_POST['email'], $_POST['message'])) {
        $message = "Bericht verzonden!";
    } else {
        $message = "Fout bij verzenden.";
    }
}
?>

<div class="form-box">
    <h2>Contact</h2>

    <?php if ($message != ""): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Naam" required>
        <input type="email" name="email" placeholder="Email" required>
        <textarea name="message" placeholder="Bericht" required></textarea>
        <button type="submit">Verstuur</button>
    </form>
</div>

<?php include("includes/footer.php"); ?>