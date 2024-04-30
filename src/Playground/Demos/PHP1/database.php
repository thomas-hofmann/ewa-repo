<?php

function databaseConnect() {
        $host = "localhost";
        /********************************************/
        // This code switches from the the local installation (XAMPP) to the docker installation 
        if (gethostbyname('mariadb') != "mariadb") { // mariadb is known?
            $host = "mariadb";
        }
        /********************************************/

        $database = new MySQLi($host, "public", "public", "reisebuero");

        if (mysqli_connect_errno()) {
            throw new Exception("Connect failed: " . mysqli_connect_error());
        }

        // set charset to UTF8!!
        if (!$database->set_charset("utf8")) {
            throw new Exception($database->error);
        }

    return $database;
}

function getData($database) {
    $sql = "SELECT Zielflughafen, Land FROM zielflughafen";

    $recordset = $database->query($sql);
    if (!$recordset) {
        throw new Exception("Abfrage fehlgeschlagen: " . $database->error);
    }
    
    $result = array();
    $record = $recordset->fetch_assoc();
    while ($record) {
        $result[] = $record;
        $record = $recordset->fetch_assoc();
    }

    $recordset->free();
    return $result;
}

// Beide Funktionen die wir oben erstellt haben aufrufen und den return wert einer variable zuordnen

// Datenbank Verbindung
$database = databaseConnect();

// Daten aus der Datenbank holen
$data = getData($database);

// Jetzt wollen wir unsere Daten sinnvoll ausgeben indem wir HTML verwenden.
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
    <h1>Database Demo</h1>
    <hr>
HTML;

foreach($data as $index => $item) {
    echo '<p>';
    echo $index + 1 . ' - <b>Zielflughafen:</b> ' . $item['Zielflughafen'] . ', <b>Land:</b> ' . $item['Land'];
    echo '</p>';
}

echo <<< HTML
</body>
</html>
HTML;


