<?php
$myArray = ['name' => 'Thomas', 'age' => 35];
$myJsonString = json_encode($myArray);

header('Content-Type: application/json');
echo $myJsonString;