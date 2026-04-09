<?php
include("functies.php");
include("includes/header.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    clearCart();
    $message = "Je bestelling is geplaatst!";
}
?>

<h2>Checkout</h2>

<div class="checkout-box">
<?php if ($message !== ""): ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
<?php else: ?>
    <?php
    $items = getCartItems();
    $total = getCartTotal();
    ?>

    <?php if (!empty($items)): ?>
        <?php foreach ($items as $item): ?>
            <p><?php echo htmlspecialchars($item['name']); ?> - €<?php echo number_format($item['price'], 2); ?></p>
        <?php endforeach; ?>

        <h3>Totaal: €<?php echo number_format($total, 2); ?></h3>

        <form method="POST" action="">
            <input type="text" name="naam" placeholder="Naam" required>
            <input type="text" name="adres" placeholder="Adres" required>
            <input type="text" name="stad" placeholder="Stad" required>
            <button type="submit">Bestellen</button>
        </form>
    <?php else: ?>
        <p>Je winkelwagen is leeg.</p>
    <?php endif; ?>
<?php endif; ?>
</div>

<?php include("includes/footer.php"); ?>