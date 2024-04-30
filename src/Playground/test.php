<?php
// Erstellen eines assoziativen Arrays mit einem Schlüssel, der ein Array ist
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
echo "Name: " . $student["name"] . "<br>";
echo "Alter: " . $student["alter"] . " Jahre<br>";
echo "Fächer: ";
foreach ($student["fächer"] as $fach) {
    echo $fach . ", ";
}
echo "<br>";
echo "Adresse: " . $student["adresse"]["straße"] . ", " . $student["adresse"]["stadt"] . ", " . $student["adresse"]["plz"] . "<br>";
?>