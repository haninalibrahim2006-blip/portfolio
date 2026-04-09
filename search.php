<?php include("functies.php"); ?>
<?php include("includes/header.php"); ?>

<h2>Zoekresultaten</h2>

<?php
$query = isset($_GET['q']) ? trim($_GET['q']) : "";
?>

<div class="grid">
<?php
if ($query !== "") {
    $results = searchProducts($query);

    if ($results && $results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
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
<?php
        }
    } else {
        echo "<p>Geen games gevonden voor: <strong>" . htmlspecialchars($query) . "</strong></p>";
    }
} else {
    echo "<p>Vul eerst een zoekwoord in.</p>";
}
?>
</div>

<?php include("includes/footer.php"); ?>