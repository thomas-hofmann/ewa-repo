<?php
session_start();
function databaseConnect() {
        $host = "localhost";
        /********************************************/
        // This code switches from the the local installation (XAMPP) to the docker installation 
        if (gethostbyname('mariadb') != "mariadb") { // mariadb is known?
            $host = "mariadb";
        }
        /********************************************/

        $database = new MySQLi($host, "public", "public", "SQL_Injection");

        if (mysqli_connect_errno()) {
            throw new Exception("Connect failed: " . mysqli_connect_error());
        }

        // set charset to UTF8!!
        if (!$database->set_charset("utf8")) {
            throw new Exception($database->error);
        }

    return $database;
}

function selectData($database, $mail, $password) {
    // $mail = $database->real_escape_string($mail);
    // $password = $database->real_escape_string($password);
    $sql = "SELECT * FROM accounts WHERE Email = '$mail' AND SecretPassword = '$password';";
    $_SESSION['sql'] = $sql;
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

function selectDataEscaped($database, $mail, $password) {
    $mail = $database->real_escape_string($mail);
    $password = $database->real_escape_string($password);
    $sql = "SELECT * FROM accounts WHERE Email = '$mail' AND SecretPassword = '$password';";
    $_SESSION['sqlEscaped'] = $sql;
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


$database = databaseConnect();

header('Content-Type: text/html; charset=utf-8');
echo <<< HTML
    <!DOCTYPE html>
    <html lang="de">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>SQL Injection Demo</title>
        </head>
        <body>
        <h1>SQL-Injection</h1>
        <hr>
HTML;

if(isset($_POST['mail']) && isset($_POST['password'])) {
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $data = selectData($database, $mail, $password);
    $dataEscaped = selectDataEscaped($database, $mail, $password);

    if(isset($_SESSION['sql'])) {
        echo '<h2>Ausgeführtes SQL Statement</h2>';
        echo '<h3>Ohne real_escape_string</h3>';
        echo '<p style="color: red;">';
        echo $_SESSION['sql'];
        echo '</p>';
        echo '<h3>Mit real_escape_string</h3>';
        echo '<p style="color: green;">';
        echo $_SESSION['sqlEscaped'];
        echo '</p>';
    }

    echo '<h2>Empfangene Daten</h2>';
    echo '<h3>Ohne real_escape_string</h3>';
    echo '<pre style="color: red;">';
    var_dump($data);
    echo '</pre>';
    echo '<h3>Mit real_escape_string</h3>';
    echo '<pre style="color: green;">';
    var_dump($dataEscaped);
    echo '</pre>';
}

echo <<< HTML
    <h2>Bitte loggen Sie sich ein</h2>
    <h3>Richtige Daten</h3>
    <p>Nutzer: <b>hans.mustermann@mail.com</b> <br>Passwort: <b>123</b></p>
    <form action="sql-injection.php" method="post" accepted-charset="utf-8">
        <input type="text" name="mail" value="" placeholder="Mail">
        <input type="text" name="password" value="" placeholder="Passwort">
        <input type="submit" value="Abschicken">
    </form>
    <h3>Einige Angriffmöglichkeiten</h3>
        <p>
            <b>Angriff 1:</b> Nutzer und Passwort so manipulieren das ein Statement immer true ist
            <ul>
                <li>
                    Nutzer und Passwort: <b>' or ""='</b>
                </li>
            </ul>
        </p>
        <p>
            <b>Angriff 2:</b> Passwortabfrage aushebelt durch erweitern der Abfrage
            <ul>
                <li>
                    Nutzer: <b>xxx' OR 1 = 1 -- ' ]</b>
                    Passwort: <b>egal</b>
                </li>
            </ul>
        </p>
        <p>
            <b>Angriff 3:</b> Daten einer bekannten Mailadresse auslesen ohne Passwort
            <ul>
                <li>
                    Nutzer: <b>JohnDoe@yahoo.com' -- '</b>
                    Passwort: <b>egal</b>
                </li>
            </ul>
        </p>
    </body>
</html>
HTML;
