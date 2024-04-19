<?php
session_start();

if(isset($_POST['sessionData'])) {
    $_SESSION['data'] = $_POST['sessionData'];
    header('Location: session-input.php');
}

header('Content-Type: text/html; charset=utf-8');
echo <<< HTML
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Input</title>
  </head>
  <body>
  <h1>Session Input</h1>
  <nav>
    <a href="/playground/php2/session-output.php" target="_blank">Session Output</a>
  </nav>
  <hr>
HTML;

echo <<< HTML
    <h2>Etwas in der Session speichern</h2>
    <form action="session-input.php" method="post" accepted-charset="utf-8">
        <input type="text" name="sessionData" value="" placeholder="Schreib etwas">
        <input type="submit" value="Abschicken">
    </form>
HTML;

echo <<< HTML
</body>
</html>
HTML;