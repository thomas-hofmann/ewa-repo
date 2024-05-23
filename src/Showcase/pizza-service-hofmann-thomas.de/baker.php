<?php	

require_once './page.php';

class Baker extends Page
{
	protected function getViewData(): array {
		session_start();
		if (isset($_SESSION['orderingId'])) {
			$orderingId = $_SESSION['orderingId'];
			$sql = "SELECT ordered_article.*, article.*
			FROM ordered_article
			INNER JOIN article ON ordered_article.article_id = article.article_id
			WHERE ordered_article.status < 2
			AND ordering_id = $orderingId
			ORDER BY ordered_article.ordering_id, ordered_article.ordered_article_id
			";

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
        $this->generatePageHeader('Pizza - Bäcker');

        echo <<<HTML
		<section class="container container__main order">
			<header class="heading">
				<h2>Bäcker</h2>
			</header>
			
			<div class="seperator">
			</div>
		HTML;
		$orderingIdTmp= '';
		foreach ($orders as $item) {
			$ordered_article_id = $item['ordered_article_id'];
			if ($orderingIdTmp !== $item['ordering_id']) {
				echo '<h3 class="mt-3">Bestellnummer: #'. $item['ordering_id'] .'</h3>';
			}
			$orderingIdTmp = $item['ordering_id'];
			echo '<form action="baker.php" id="orderForm-' . $ordered_article_id . '" method="post">';
			echo '<img style="max-width:125px;" src="' . $item['picture'] . '" alt="' . $item['name'] . '">';
			echo '<p>' . $item['name'] . '</p>';

			$orderedClass = '';
			$orderedChecked = '';
			if($item['status'] == 0){
				$orderedClass = 'active';
				$orderedChecked = 'checked';
			}

			$ovenClass = '';
			$ovenChecked = '';
			if($item['status'] == 1){
				$ovenClass = 'active';
				$ovenChecked = 'checked';
			}
			
			echo <<<HTML
				<div class="btn-group btn-group-toggle" data-toggle="buttons">
					<label class="btn btn-dark $orderedClass">
						<input type="radio" value="0" onclick="document.getElementById('orderForm-$ordered_article_id').submit()" name="$ordered_article_id" $orderedChecked>
						Bestellt
					</label>
					<label class="btn btn-dark $ovenClass">
						<input type="radio" value="1" onclick="document.getElementById('orderForm-$ordered_article_id').submit()" name="$ordered_article_id" $ovenChecked>
						Im Ofen
					</label>
					<label class="btn btn-dark">
						<input type="radio" value="2" onclick="document.getElementById('orderForm-$ordered_article_id').submit()" name="$ordered_article_id">
						Fertig
					</label>
				</div>
				</form>
			HTML;
		}


		if(!count($orders)){
			echo '<p class="pb-2 text-danger">Hier gibt es nichts zum backen.</p>';
			echo '<div class="seperator"></div>';
		} else {
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
				$ordered_article_id = array_key_first($_POST);
				$sql = "UPDATE ordered_article SET status = $status WHERE ordered_article_id = $ordered_article_id";
				$this->_database->query($sql);

				header('Location: baker.php');
				exit();
			}
		}
    }

    public static function main(): void 
    {
        try {
            $page = new Baker();
            $page->processReceivedData();
            $page->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Baker::main();