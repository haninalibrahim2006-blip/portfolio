<?php
$mysqli = new mysqli("localhost", "root", "", "gameworld_db");

if ($mysqli->connect_error) {
    die("Connectie mislukt: " . $mysqli->connect_error);
}
?>