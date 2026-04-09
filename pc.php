<?php include("functies.php"); ?>
<?php include("includes/header.php"); ?>

<h2>PC Games</h2>

<div class="grid">
<?php
$products = getProductsByCategory(3);
while ($row = $products->fetch_assoc()):
?>
    <div class="product-card">
        <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
        <h3>
            <a href="product_detail.php?id=<?php echo $row['id']; ?>">
                <?php echo htmlspecialchars($row['name']); ?>
            </a>
        </h3>
        <p>€<?php echo number_format($row['price'], 2); ?></p>
        <a href="add_to_cart.php?id=<?php echo $row['id']; ?>" class="button">In winkelwagen</a>
    </div>
<?php endwhile; ?>
</div>

<?php include("includes/footer.php"); ?>