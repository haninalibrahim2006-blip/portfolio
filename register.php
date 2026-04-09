<?php
include("functies.php");
include("includes/header.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result = registerUser($_POST['username'], $_POST['email'], $_POST['password']);

    if ($result === true) {
        $message = "Registratie gelukt!";
    } else {
        $message = $result;
    }
}
?>

<div class="form-box">
    <h2>Registreren</h2>

    <?php if ($message != ""): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Gebruikersnaam" required>
        <input type="email" name="email" placeholder="E-mailadres" required>
        <input type="password" name="password" placeholder="Wachtwoord" required>
        <button type="submit">Registreren</button>
    </form>
</div>

<?php include("includes/footer.php"); ?>