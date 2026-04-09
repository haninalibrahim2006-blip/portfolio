<?php include("functies.php"); ?>
<?php include("includes/header.php"); ?>

<div class="blog-layout">

    <aside class="blog-sidebar">
        <h3>Categorieën</h3>
        <a href="blog.php">Alle posts</a>
        <a href="blog.php?category=1">New Products</a>
        <a href="blog.php?category=2">Game Reviews</a>
        <a href="blog.php?category=3">Console Reviews</a>
        <a href="add_blog.php" class="button">Nieuwe blog toevoegen</a>
    </aside>

    <section class="blog-content">
        <h2>Blog</h2>

        <?php
        if (isset($_GET['category'])) {
            $posts = getBlogPostsByCategory($_GET['category']);
        } else {
            $posts = getAllBlogPosts();
        }

        if ($posts && $posts->num_rows > 0):
            while ($row = $posts->fetch_assoc()):
        ?>
            <div class="blog-card">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><strong>Auteur:</strong> <?php echo htmlspecialchars($row['author']); ?></p>
                <p><strong>Datum:</strong> <?php echo htmlspecialchars($row['post_date']); ?></p>
                <p><strong>Categorie:</strong> <?php echo htmlspecialchars(getCategoryName($row['category_id'])); ?></p>
                <p><?php echo htmlspecialchars(substr($row['content'], 0, 120)); ?>...</p>
                <a href="blog_detail.php?id=<?php echo $row['id']; ?>" class="button">Read more</a>
            </div>
        <?php
            endwhile;
        else:
            echo "<p>Er zijn nog geen blogposts.</p>";
        endif;
        ?>
    </section>

</div>

<?php include("includes/footer.php"); ?>