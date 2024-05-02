<?php
session_start();

header('Content-Type: text/html; charset=utf-8');
echo <<< HTML
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Output</title>
  </head>
  <body>
  <h1>PHP: Session Output</h1>
  <nav>
    <a href="session-input.php" target="_blank">Session Input</a>
  </nav>
  <hr>
HTML;

if(count($_SESSION)) {
    echo '<h2>Inhalt von $_SESSION</h2>';
    echo '<pre>';
    var_dump($_SESSION);
    echo '</pre>';
    echo '<a href="session-destroy.php">Session zerstören</a>';
}

echo <<< HTML
</body>
</html>
HTML;

