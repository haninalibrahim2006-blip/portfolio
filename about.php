<?php include("functies.php"); ?>
<?php include("includes/header.php"); ?>

<div class="form-box">
    <h2>About</h2>
    <p><?php echo nl2br(htmlspecialchars(getContent('about'))); ?></p>
</div>

<?php include("includes/footer.php"); ?>