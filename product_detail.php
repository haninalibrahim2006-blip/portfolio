<?php include("functies.php"); ?>
<?php include("includes/header.php"); ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = getProductById($id);
?>

<?php if ($product): ?>
    <div class="game-detail">
        <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">

        <div class="game-info">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="price">€<?php echo number_format($product['price'], 2); ?></p>

            <h3>Waar gaat deze game over?</h3>
            <p class="game-description">
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </p>

            <a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="button">In winkelwagen</a>
        </div>
    </div>
<?php else: ?>
    <div class="form-box">
        <h2>Game niet gevonden</h2>
    </div>
<?php endif; ?>

<?php include("includes/footer.php"); ?>