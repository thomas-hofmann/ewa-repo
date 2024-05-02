<?php
session_start();

if(isset($_POST['sessionData'])) {
    // Speichere Formulardaten unter dem key data 
    $_SESSION['data'] = $_POST['sessionData'];

    // Andere Keys zum testen
    // $_SESSION['data2'] = $_POST['sessionData'];
    // $_SESSION['data3'] = $_POST['sessionData'];

    // PRG PATTERN
    // Seite wird neu OHNE Formulardaten geladen
    header('Location: session-input.php');
    exit();
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
  <h1>PHP: Session Input</h1>
  <nav>
    <a href="/session-output.php" target="_blank">Session Output</a>
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