<?php
session_start();

header('Content-Type: text/html; charset=utf-8');
echo <<< HTML
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session</title>
  </head>
  <body>
  <h1>Session Output</h1>
  <nav>
    <a href="/playground/php2/session-input.php" target="_blank">Session Input</a>
  </nav>
  <hr>
HTML;

if(isset($_SESSION['data'])) {
    $data = $_SESSION['data'];
    echo '<h2>Inhalt von $_SESSION</h2>';
    echo '<pre>';
    var_dump($_SESSION);
    echo '</pre>';
} else {
    $data = 'Leer';
}
echo <<< HTML
    <section>
        <h2>Ist etwas in der Session?</h2>
        <p>$data</p>
        <a href="/playground/php2/session-destroy.php">Session löschen</a>
    </section>
HTML;

// Zerstört die Session und löscht alle Daten
// session_destroy();
echo <<< HTML
</body>
</html>
HTML;

