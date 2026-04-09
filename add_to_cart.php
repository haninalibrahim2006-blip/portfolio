<?php
include("functies.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['id'])) {
    addToCart($_GET['id']);
}

header("Location: winkelwagen.php");
exit();