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
    <h1>Live-Coding: Auflösung</h1>
    <hr>
HTML;

echo <<< HTML
    <header>
    <h1>Header</h1>
    <img alt="Eine Katze" src="cat.jpg" style="max-width:50%; height: auto; border: 1px solid gray;">
    </header>
HTML;

$data = [
    0 => [
        'link' => 'https://www.youtube.de/',
        'text' => 'youtube',
    ],
    1 => [
        'link' => 'https://www.google.de/',
        'text' => 'google',
    ],
    2 => [
      'link' => 'https://www.wikipedia.de/',
      'text' => 'wikipedia',
  ],
];

echo '<h2>Navigation</h2>';

foreach($data as $item) {
    $link = $item['link'];
    $linkText = $item['text'];
    
    echo <<< HTML
        <a href="$link" target="_blank">$linkText</a>
    HTML;
}

if(isset($_POST['name'])) {
    echo '<section>';
    echo '<h2>Formdaten sind vorhanden</h2>';
    echo '<p>' . $_POST['name'] . '</p>';
    echo '</section>';
}

echo <<< HTML
    <section>
    <h2>Content</h2>
    <p>Hier wird ein Formular an sich selbst abgeschickt.</p>
    <form action="live-coding.php" method="post" accept-charset="utf-8">
        <p>
        <label for="myname">Name</label><br>
        <input id="myname" type="text" name="name" value="" required placeholder="Name eingeben...">
        </p>
        <p>
        <input type="submit" value="Abschicken">
        </p>
    </form>
    </section>
    <footer class="container">
        <h2>Footer</h2>
        <p><small>Thomas Hofmann ©</small></p>
    </footer>
HTML;

echo <<< HTML
    </body>
</html>
HTML;
