<?php	

abstract class Page
{
    
    protected $_database = null;
    
    protected function __construct() 
    {
        // $config = include('/kunden/homepages/3/d1006869723/htdocs//config.php');
		// $config = $config['pizza-service'];

		$host = "localhost";
        /********************************************/
        // This code switches from the the local installation (XAMPP) to the docker installation 
        if (gethostbyname('mariadb') != "mariadb") { // mariadb is known?
            $host = "mariadb";
        }

        $host_name  = $host;
		$database   = 'pizzaservice';
		$user_name  = 'public';
		$password   = 'public';

		$this->_database = new MySQLi($host_name, $user_name, $password, $database);
		
		if (mysqli_connect_errno())
		throw new Exception("Datenbankfehler: " . mysqli_connect_error());
    }

	protected function dumb($item): void {
		echo '<pre style="background: black; color: lightGreen;">';
		var_dump($item);
		echo '</pre>';
	}
    
    protected function generatePageHeader($headline = ""): void
    {
        $headline = htmlspecialchars($headline);
		header("Content-type: text/html; charset=UTF-8");

		$extraJS = '';
		if ($headline == 'Pizza - Kunde') {
			$extraJS = '<script src="logic-costumer.js"></script>';
		}

		echo <<<HTML
		<!DOCTYPE HTML>
		<html lang="de">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="icon" href="images/favicon.png">
			<title>$headline</title>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
			<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
			<script src="https://kit.fontawesome.com/bb7ebab3a0.js" crossorigin="anonymous"></script>
			<link rel="stylesheet" type="text/css" href="style.css">
			<script src="logic.js"></script>
			$extraJS
		</head>
		<body>
			<header class="container container__main order header">
				<div class="heading">
					<h1>Pizza-Service</h1>
				</div>
				<div class="keyvisual">
					<img src="images/keyvisual.png" class="img-fluid order__header" alt="Keyvisual">
				</div>
				<div class="order__text">
					<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
						<a class="navbar-brand" href="index.php">Home</a>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse text-right" id="navbarNavAltMarkup">
						<div class="navbar-nav">
							<a class="nav-item nav-link" href="costumer.php">Kunde</a>
							<a class="nav-item nav-link" href="baker.php">Bäcker</a>
							<a class="nav-item nav-link" href="driver.php">Fahrer</a>
						</div>
						</div>
				</nav>
				</div>
				<div class="seperator">
				</div>
				<p><small>Disclaimer: Nur zu Demonstrationszwecken. Funktionalität nicht vollständig/richtig!</small></p>
				<div class="seperator">
				</div>
			</header>
HTML;
        
    }

    protected function generatePageFooter(): void
	{
		echo <<<HTML
		<footer class="container container__main footer p-2">
			<small><i class="fa-regular fa-copyright"></i> Thomas Hofmann</small>
		</footer>
		</body>
		</html>
HTML;
    
    }

    protected function processReceivedData(): void
    {
       
    }
} 