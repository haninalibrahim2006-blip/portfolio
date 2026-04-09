<?php include("functies.php"); ?>
<?php include("includes/header.php"); ?>

<section class="hero">
    <h1>Welkom bij GameWorld</h1>
    <p>Ontdek PlayStation, Xbox en PC games.</p>
</section>

<form method="GET" action="search.php" class="search-box">
    <input type="text" name="q" placeholder="Zoek een game..." required>
    <button type="submit">Zoeken</button>
</form>

<div class="categories">
    <div class="category-item">
        <a href="playstation.php">
            <img src="images/playstationfoto.jpg" class="category-img" alt="PlayStation">
            <h3>PlayStation</h3>
        </a>
    </div>

    <div class="category-item">
        <a href="xbox.php">
            <img src="images/xboxfoto.jpg" class="category-img" alt="Xbox">
            <h3>Xbox</h3>
        </a>
    </div>

    <div class="category-item">
        <a href="pc.php">
            <img src="images/pcfoto.jpg" class="category-img" alt="PC">
            <h3>PC</h3>
        </a>
    </div>
</div>

<h2>Populaire Games</h2>

<div class="grid">
<?php
$products = getPopularProducts();
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