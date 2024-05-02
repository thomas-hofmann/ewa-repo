<?php
header('Content-Type: text/html; charset=utf-8');
echo <<< HTML
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XSS Demo</title>
  </head>
  <body>
  <h1>PHP: XSS</h1>
  <hr>
HTML;

if(isset($_GET['data'])) {
    $formData = $_GET['data'];
    $escapedFormData = htmlspecialchars($_GET['data']);
    echo <<< HTML
        <h2 style="color: red;">Ausgabe ohne htmlspecialchars</h2>
        <div>$formData</div>
        <h2 style="color: green;">Ausgabe mit htmlspecialchars</h2>
        <p>$escapedFormData</p>
    HTML;
}

echo <<< HTML
<h2>Geben Sie ein HTML-Tag ein, was passiert?</h2>
<form accepted-charset="utf-8" method="get" action="xss.php">
    <input type="text" name="data" value="" placeholder="Name" required>
    <input type="submit" value="Abschicken">
</form>
HTML;

echo <<< HTML
</body>
</html>
HTML;

