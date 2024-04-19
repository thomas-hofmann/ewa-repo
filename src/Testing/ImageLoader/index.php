<?php
echo <<< HTML
  <!DOCTYPE html>
  <html lang="de">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap und jQuery Beispiel</title>
    <!-- Neueste Bootstrap CSS -->
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body class="body__custom">

  <!-- Dein Inhalt hier -->
  <div class="container container__main">
    <div id="output" class="flex-container">
HTML;

$dirPath = 'output/';
$files = scandir($dirPath, SCANDIR_SORT_DESCENDING);
$files = array_diff($files, array('.', '..'));

usort($files, function($a, $b) use ($dirPath) {
  return filemtime($dirPath . $b) - filemtime($dirPath . $a);
});

$files = array_slice($files, 0, 12);
$files = array_reverse($files);

foreach($files as $file) {
  $filePath = $dirPath . '/' . $file;
    if (is_file($filePath)) {
      echo '<div class="flex-item"><img class="flex-image" src="output/' . $file . '"></div>';
    }
}
echo <<< HTML
   </div>
  </div>
  <!-- Neueste jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <!-- Neueste Bootstrap JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- Logic hier -->
  <script src="logic.js"></script>
  </body>
  </html>
HTML;