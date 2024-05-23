<?php	

require_once './page.php';

class Driver extends Page
{


	protected function getViewData(): array {
		session_start();
		if (isset($_SESSION['orderingId'])) {
			$orderingId = $_SESSION['orderingId'];
			$sql = "SELECT ordered_article.*, article.*, ordering.*
			FROM ordered_article
			INNER JOIN article ON ordered_article.article_id = article.article_id
			INNER JOIN ordering ON ordered_article.ordering_id = ordering.ordering_id
			WHERE ordering.ordering_id NOT IN (
				SELECT oa.ordering_id
				FROM ordered_article oa
				WHERE oa.status <= 1
			)
			AND ordering.ordering_id = $orderingId
			ORDER BY ordered_article.ordering_id, ordered_article.ordered_article_id";

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
		} else {
			return [];
		}
    }
       
    protected function generateView(): void {
        $orders = $this->getViewData();
        $this->generatePageHeader('Pizza - Fahrer');

		echo <<<HTML
		<section class="container container__main order">
			<div class="heading">
				<h2>Fahrer</h2>
			</div>
			
			<div class="seperator">
			</div>
		HTML;

		$orderingIdTmp= '';
		$ordersCleaned = [];
		$cnt = -1;
		$cntPizzas = 0;
		foreach ($orders as $item) {
			if ($orderingIdTmp !== $item['ordering_id']) {
				$cnt++;
				$ordersCleaned[$cnt]['address'] = $item['address'];
				$ordersCleaned[$cnt]['ordering_id'] = $item['ordering_id'];
				$ordersCleaned[$cnt]['status'] = $item['status'];
			}
			$orderingIdTmp = $item['ordering_id'];
			$ordersCleaned[$cnt]['articles'][$cntPizzas]['picture'] = $item['picture'];
			$ordersCleaned[$cnt]['articles'][$cntPizzas]['name'] = $item['name'];
			$ordersCleaned[$cnt]['articles'][$cntPizzas]['price'] = $item['price'];
			$cntPizzas++;
		}
		foreach ($ordersCleaned as $item) {
			$orderId = $item['ordering_id'];
			$address = htmlspecialchars($item['address']);
			$pizzas = $item['articles'];
			echo <<< HTML
				<h3>Bestellnummer: #$orderId</h3>
			HTML;
			$price = 0;
			echo '<div class="d-flex flex-wrap justify-content-center pr-3 pl-3">';
			foreach ($pizzas as $pizza) {
				echo '<div class="pl-2 pr-2">';
				echo '<img style="max-width:125px;" src="' . $pizza['picture'] . '" alt="' . $pizza['name'] . '">';
				echo '<p>' . $pizza['name'] . '</p>';
				echo '</div>';
				$price = $price + $pizza['price'];
			}
			echo '</div>';
			echo '<p class="font-weight-bold">Adresse: ' . $address . '</p>';
			echo '<p class="font-weight-bold">Gesamtpreis: ' . $price . '€</p>';
			$onTheWayClass = '';
			$onTheWayChecked = '';

			if($item['status'] == 3){
				$onTheWayClass = 'active';
				$onTheWayChecked = 'checked';
			}
			
			echo <<<HTML
				<form action="driver.php" id="orderForm-$orderId" method="post">
					<div class="btn-group btn-group-toggle" data-toggle="buttons">
						<label class="btn btn-dark $onTheWayClass">
							<input type="radio" value="3" onclick="document.getElementById('orderForm-$orderId').submit()" name="$orderId" $onTheWayChecked>
							Unterwegs
						</label>
						<label class="btn btn-dark">
							<input type="radio" value="4" onclick="document.getElementById('orderForm-$orderId').submit()" name="$orderId">
							Ausgeliefert
						</label>
					</div>
				</form>
			HTML;

			echo '<hr>';
		}
		if(!count($orders)){
			echo '<p class="pb-2 text-danger">Hier gibt es nichts zum ausliefern.</p>';
			echo '<div class="seperator"></div>';
		}
			echo<<<HTML
				</section>
			HTML;

		$this->generatePageFooter();
    }
    
    protected function processReceivedData(): void 
    {
        if (count($_POST)) {
			if (isset($_POST[array_key_first($_POST)])) {
				$status = $this->_database->real_escape_string(($_POST[array_key_first($_POST)]));
				$orderingId = array_key_first($_POST);

				if ($_POST[array_key_first($_POST)] == 4) {
					$sql = "DELETE FROM ordered_article WHERE ordering_id = $orderingId";
					$this->_database->query($sql);

					$sql = "DELETE FROM ordering WHERE ordering_id = $orderingId";
					$this->_database->query($sql);

					header('Location: driver.php');
					exit();
				}
				
				$sql = "UPDATE ordered_article SET status = $status WHERE ordering_id = $orderingId";
				$this->_database->query($sql);

				header('Location: driver.php');
				exit();
			}
		}
        
    }

    public static function main(): void
    {
        try {
            $page = new Driver();
            $page->processReceivedData();
            $page->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Driver::main();