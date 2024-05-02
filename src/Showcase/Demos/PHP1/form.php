<?php
header('Content-Type: text/html; charset=utf-8');
echo <<< HTML
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First-Page</title>
  </head>
  <body>
    <h1>Formular Demo</h1>
    <hr>
HTML;

if(isset($_POST['data'])) {
    echo '<h2>$_POST Inhalt</h2>';
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";
    $formData = $_POST['data'];
    echo <<< HTML
        <h2>Ausgabe</h2>
        <p>$formData</p>
    HTML;
}

if(isset($_GET['data'])) {
  echo '<h2>$_GET Inhalt</h2>';
  echo "<pre>";
  var_dump($_GET);
  echo "</pre>";
  $formData = $_GET['data'];
  echo <<< HTML
      <h2>Ausgabe</h2>
      <p>$formData</p>
  HTML;
}

/*
  Wie müssen wir unser form-tag ergänzen für:
    1. Wir wollen es an sich selbst schicken?
    2. Wir wollen es via POST verschicken
    3. Wir wollen es via GET verschicken

    Was muss in action und method stehen?
*/
echo <<< HTML
<h2>Eingabe</h2>
<form accepted-charset="utf-8" method="" action="">
    <input type="text" name="data" value="" placeholder="Name" required>
    <input type="submit" value="Abschicken">
</form>
HTML;

echo <<< HTML
</body>
</html>
HTML;

