<?php
header('Content-Type: text/html; charset=utf-8');

echo <<< HTML
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Array-Demo</title>
  </head>
  <body>
    <h1>Array Demo</h1>
    <hr>
HTML;

// Erstellen eines assoziativen Arrays
$student = [
    "name" => "Max Mustermann",
    "alter" => 20,
    "fächer" => ["Mathematik", "Informatik", "Physik"],
    "adresse" => [
        "straße" => "Musterstraße 123",
        "stadt" => "Musterstadt",
        "plz" => "12345"
    ]
];

// Zugriff auf Werte
echo "<h2>Ein Student</h2>";
echo "<p>Name: " . $student["name"] . "</p>";
echo "<p>Alter: " . $student["alter"] . " Jahre</p>";
echo "<p>Fächer: ";
foreach ($student["fächer"] as $fach) {
    echo $fach . ", ";
}
echo "</p>";
echo "<p>Adresse: " . $student["adresse"]["straße"] . ", " . $student["adresse"]["stadt"] . ", " . $student["adresse"]["plz"] . "</p>";
echo "<hr>";

// Array im Array
echo "<h2>Array aus Studenten</h2>";
$students = [$student, $student, $student];
echo "<pre>";
var_dump($students);
echo "</pre>";
echo <<< HTML
</body>
</html>
HTML;