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
  <h1>XSS</h1>
  <hr>
HTML;

if(isset($_POST['data'])) {
    $formData = $_POST['data'];
    $escapedFormData = htmlspecialchars($_POST['data']);
    echo <<< HTML
        <h2>Formdaten</h2>
        <h3 style="color: red;">Ausgabe ohne htmlspecialchars</h3>
        <div>$formData</div>
        <h3 style="color: green;">Ausgabe mit htmlspecialchars</h3>
        <p>$escapedFormData</p>
    HTML;
}

echo <<< HTML
<h2>Geben Sie ein HTML-Tag ein, was passiert?</h2>
<form accepted-charset="utf-8" method="post" action="xss.php">
    <input type="text" name="data" value="" placeholder="Name" required>
    <input type="submit" value="Abschicken">
</form>
HTML;

echo <<< HTML
</body>
</html>
HTML;

