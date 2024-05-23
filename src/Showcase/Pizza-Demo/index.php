<?php	// UTF-8 marker äöüÄÖÜß€

require_once './page.php';

class index extends Page
{
   
    protected function __construct() 
    {
        parent::__construct();
        
    }

	protected function getViewData():array {
		$sql = "SELECT * FROM article";

        $recordset = $this->_database->query($sql);
        if (!$recordset) {
            throw new Exception("Abfrage fehlgeschlagen: " . $this->_database->error);
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
    
    protected function generateView(): void {

		$data = $this->getViewData();
		$this->generatePageHeader('Pizza - Home');
		echo <<<HTML
		<section class="container container__main order pb-2">
			<header class="heading">
				<h2>Speisekarte</h2>
			</header>
			<div class="seperator">
			</div>
			<div class="row pizza__row">
HTML;

foreach($data as $item) {
	$pizzaId = $item['article_id'];
	$pizzaName = $item['name'];
	$pizzaPrice = $item['price'];
	$pizzaPriceNaming = $item['price'] . '€';
	$pizzaImagePath = $item['picture'];
	echo <<< HTML
		<div class="col-lg-4 col-md-4 col-sm-12">
			<img src="$pizzaImagePath" class="order__img" onclick="addPizza('$pizzaName', $pizzaPrice, $pizzaId); formCheck();" alt="$pizzaName">
			<p class="mt-0"><span class="font-weight-bold mb-0">Pizza $pizzaName</span><br> - $pizzaPriceNaming - <p>
		</div>
	HTML;
}

echo <<<HTML
		</div>
		</section>
		<section class="container container__main order pb-4">
			<header class="heading">
				<h2>Warenkorb</h2>
			</header>
			<div class="seperator">
			</div>
			<form action="index.php" id="orderForm" method="post">
				<div class="row shoppingcart__row">
					<div  class="col-lg-6 col-md-6 col-sm-12 text-left">
						<input class="form-control order__adress" oninput="formCheck();" id="address" name="address" type="text" value="" placeholder="Adresse eingeben">
						<select name="cart[]" id="cart" class="cart form-select rounded" multiple></select>
						<output id="price" class="mt-2 mb-2 price__output rounded">Gesamtpreis: 0€</output>
					</div>
					<div  class="col-lg-6 col-md-6 col-sm-12 text-left shoppingcart__buttons">
						<p>
							<button type="button" class="btn btn-dark" onclick="deleteSelected(); formCheck();"><i class="fa fa-trash-o" aria-hidden="true"></i> Auswahl löschen</button>
						</p>
						<p>
							<button type="button" class="btn btn-dark" onclick="deleteAll(); formCheck();"><i class="fa fa-trash-o" aria-hidden="true"></i> Alles löschen</button>
						</p>
						<p>
							<button  id="orderButton" onclick="orderCheck();" type="submit" class="btn btn-success" disabled><i class="fa-solid fa-share"></i> Bestellen</button>
						</p>
					</div>
					<div class="seperator">
					</div>
				</div>
			</form>
		</section>
HTML;

        $this->generatePageFooter();
    }
    
    protected function processReceivedData(): void
    {
		if (count($_POST)) {
			if (isset($_POST['address']) && isset($_POST['cart'])) {
				$address = $this->_database->real_escape_string($_POST['address']);
				$sqlAddress = "INSERT INTO ordering (address) VALUES ('$address')";

				$this->_database->query($sqlAddress);

				$orderingId = $this->_database->insert_id;
				foreach ($_POST['cart'] as $pizzaId) {
					$sqlOrdering = "INSERT INTO ordered_article (ordering_id, article_id, status) VALUES ($orderingId, $pizzaId, 0)";
					$this->_database->query($sqlOrdering);
				}

				session_start();
				$_SESSION['orderingId'] = $orderingId;

				header('Location: costumer.php');
            	exit();
			}
		}
        
    }

    public static function main(): void
    {
        try {
            $page = new index();
            $page->processReceivedData();
            $page->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

index::main();