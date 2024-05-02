<?php
// session muss immer gestartet werden
session_start();
session_destroy();
header('Location: session-output.php');