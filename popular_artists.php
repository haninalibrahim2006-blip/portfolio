<?php
include("inc/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Benjamin Porobic">
    <title>Popular Artists</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="topbar">
    <a class="logo" href="index.php">Radio Gaga</a>
    <?php displayNavigation(); ?>
</header>

<main class="simple-page">
    <h1>Popular Artists</h1>
    <?php displayPopularArtists(); ?>
</main>

</body>
</html>
