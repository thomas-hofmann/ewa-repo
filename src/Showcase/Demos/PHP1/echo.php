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
    <h1>Echo: Demo</h1>
    <hr>
HTML;

$firstname = 'Thomas';
$lastname = 'Hofmann';

echo <<< HTML
    <section>
        <h2>HEREDOC</h2>
        <p>$firstname</p>
        <p>$lastname</p>
    </section>
HTML;

echo '<section>';
echo '<h2>ECHO</h2>';
echo '<p>' . $firstname . '</p>';
echo '<p>' . $lastname . '</p>';
echo '</section>';


echo <<< HTML
</body>
</html>
HTML;

