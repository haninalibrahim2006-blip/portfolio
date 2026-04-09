<?php include("functies.php"); ?>
<?php include("includes/header.php"); ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$post = getBlogPostById($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    addComment($id, $_POST['name'], $_POST['comment']);
}
?>

<?php if ($post): ?>
    <div class="form-box">
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><strong>Auteur:</strong> <?php echo htmlspecialchars($post['author']); ?></p>
        <p><strong>Datum:</strong> <?php echo htmlspecialchars($post['post_date']); ?></p>
        <p><strong>Categorie:</strong> <?php echo htmlspecialchars(getCategoryName($post['category_id'])); ?></p>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
    </div>

    <div class="form-box comments-box">
        <h3>Comments</h3>

        <?php
        $comments = getCommentsByPostId($id);
        if ($comments && $comments->num_rows > 0):
            while ($comment = $comments->fetch_assoc()):
        ?>
            <div class="comment-item">
                <p><strong><?php echo htmlspecialchars($comment['name']); ?></strong></p>
                <p><?php echo htmlspecialchars($comment['comment']); ?></p>
            </div>
        <?php
            endwhile;
        else:
            echo "<p>Nog geen comments.</p>";
        endif;
        ?>

        <h3>Leave a comment</h3>
        <form method="POST" action="" onsubmit="return validateCommentForm()">
            <input type="text" name="name" id="commentName" placeholder="Naam" required>
            <textarea name="comment" id="commentText" placeholder="Comment" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>

    <script>
    function validateCommentForm() {
        let name = document.getElementById("commentName").value.trim();
        let comment = document.getElementById("commentText").value.trim();

        if (name === "" || comment === "") {
            alert("Vul naam en comment in.");
            return false;
        }
        return true;
    }
    </script>
<?php else: ?>
    <div class="form-box">
        <h2>Blog niet gevonden</h2>
    </div>
<?php endif; ?>

<?php include("includes/footer.php"); ?>