<?php
include("inc/functions.php");

$msg = "";
if(isset($_POST["firstname"]) && isset($_POST["lastname"])) {
  $fn = $_POST["firstname"];
  $ln = $_POST["lastname"];

  if($fn != "" && $ln != "") {
    $msg = "Thank you $fn $ln for contacting RadioGaga.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="author" content="Jouw Naam">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact - Radio Gaga</title>
  <link rel="stylesheet" href="css/style.css?v=1">
</head>
<body>

<header class="topbar">
  <div class="logo">
    <a href="index.php">Radio Gaga</a>
    <p>Contact</p>
  </div>

  <?php displayNavigation(); ?>
</header>

<div class="content">
  <h1>Contact</h1>

  <?php if($msg != "") { echo "<p class='thanks'>$msg</p>"; } ?>

  <form method="post" class="contact-form">
    <label>First Name *</label>
    <input type="text" name="firstname" required>

    <label>Last Name *</label>
    <input type="text" name="lastname" required>

    <label>Email or Phone</label>
    <input type="text" name="contact">

    <label>Message</label>
    <textarea name="message"></textarea>

    <div class="form-buttons">
      <button type="submit">Submit</button>
      <button type="reset">Reset</button>
    </div>
  </form>
</div>

</body>
</html>
