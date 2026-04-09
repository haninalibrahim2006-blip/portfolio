<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Calculator++</title>
  <link rel="stylesheet" href="style.css"> 
</head>
<body>

<div class="container">
  <div class="top-part">Calculator++</div>

  <div class="bottom-part">
    <form method="post">
      <input type="text" name="num1" placeholder="Nummer 1" required>
      <input type="text" name="num2" placeholder="Nummer 2" required>

      <div class="operations">
        <label><input type="checkbox" name="ops[]" value="add">+</label>
        <label><input type="checkbox" name="ops[]" value="sub">−</label>
        <label><input type="checkbox" name="ops[]" value="mul">×</label>
        <label><input type="checkbox" name="ops[]" value="div">÷</label>
        <label><input type="checkbox" name="ops[]" value="pow">^</label>
        <label><input type="checkbox" name="ops[]" value="sqrt">√</label>
      </div>

      <button type="submit" class="btn-calc">=</button>
      <a href="index.php" class="btn-reset">C</a>
    </form>

    <?php
    // --- PHP-berekeningen ---
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      // Waarden ophalen uit formulier
      $n1 = $_POST['num1'];
      $n2 = $_POST['num2'];
      $ops = $_POST['ops'] ?? [];

      // Controleren of de invoer numeriek is
      if (is_numeric($n1) && is_numeric($n2)) {

        echo "<div class='result-box'>";

        foreach ($ops as $o) {
          switch ($o) {
            case "add":
              echo "$n1 + $n2 = " . ($n1 + $n2) . "<br>";
              break;

            case "sub":
              echo "$n1 - $n2 = " . ($n1 - $n2) . "<br>";
              break;

            case "mul":
              echo "$n1 × $n2 = " . ($n1 * $n2) . "<br>";
              break;

            case "div":
              echo $n2 != 0
                ? "$n1 ÷ $n2 = " . ($n1 / $n2) . "<br>"
                : "Delen door 0!<br>";
              break;

            case "pow":
              echo "$n1 ^ $n2 = " . pow($n1, $n2) . "<br>";
              break;

            case "sqrt":
              echo "√$n1 = " . sqrt($n1) . "<br>";
              break;
          }
        }

        echo "</div>";
      } else {
        echo "<div class='result-box'>Voer geldige nummers in!</div>";
      }
    }
    ?>
  </div>
</div>

</body>
</html>
