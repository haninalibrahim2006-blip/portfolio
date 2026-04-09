<?php
include("inc/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Benjamin Porobic">
    <title>Artists</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="topbar">
    <a class="logo" href="index.php">Radio Gaga</a>
    <?php displayNavigation(); ?>
</header>

<main class="simple-page">
    <h1>Artists</h1>
    <?php displayArtists(); ?>
</main>

</body>
</html>
