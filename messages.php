<?php include("functies.php"); ?>
<?php include("includes/header.php"); ?>

<h2>Contact berichten</h2>

<div class="form-box">
<?php
$messages = getContactMessages();

if ($messages->num_rows > 0):
    while ($row = $messages->fetch_assoc()):
?>
        <div style="margin-bottom:20px;">
            <p><strong>Naam:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
            <p><strong>Bericht:</strong> <?php echo htmlspecialchars($row['message']); ?></p>
            <hr>
        </div>
<?php
    endwhile;
else:
    echo "<p>Geen berichten.</p>";
endif;
?>
</div>

<?php include("includes/footer.php"); ?>