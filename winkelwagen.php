<?php include("functies.php"); ?>
<?php include("includes/header.php"); ?>

<h2>Winkelwagen</h2>

<div class="checkout-box">
<?php
$items = getCartItems();
$total = getCartTotal();

if (!empty($items)):
    foreach ($items as $item):
?>
        <p><?php echo htmlspecialchars($item['name']); ?> - €<?php echo number_format($item['price'], 2); ?></p>
<?php
    endforeach;
?>
    <h3>Totaal: €<?php echo number_format($total, 2); ?></h3>
    <a href="checkout.php" class="button">Naar checkout</a>
<?php else: ?>
    <p>Je winkelwagen is leeg.</p>
<?php endif; ?>
</div>

<?php include("includes/footer.php"); ?>