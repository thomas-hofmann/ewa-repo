<?php	

require_once './page.php';

class Costumer extends Page
{

    protected function getViewData(): array {
        session_start();

        if (isset($_SESSION['orderingId'])) {
            $orderingId = $_SESSION['orderingId'];
            $sql = "SELECT ordered_article.*, article.*
                    FROM ordered_article
                    INNER JOIN article ON ordered_article.article_id = article.article_id
                    WHERE ordering_id = $orderingId";

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
        $this->generatePageHeader('Pizza - Kunde');
        echo <<<HTML
            <section class="container container__main order">
                <header class="heading">
                    <h2>Kunde</h2>
                </header>
                
                <div class="seperator"></div>
HTML;
        $totalPrice = 0;
        if (isset($orders[0]['ordering_id'])) {
            echo '<h3>Bestellnummer: #' . $orders[0]['ordering_id'] . '</h3>';
        }
        echo '<div id="order-wrapper" class="d-flex flex-wrap justify-content-center pr-3 pl-3">';
        foreach ($orders as $item) {
            echo '<div class="pl-2 pr-2 order-wrapper-item">';
            $totalPrice = $totalPrice + $item['price'];
            echo '<div class="text-center"><img style="max-width:125px;" src="' . $item['picture'] . '" alt="' . $item['name'] . '"></div>';
            echo '<p>' . $item['name'] . ' + ' . $item['price'] . '€</p>';

            if($item['status'] == 0){
            echo '<p class="order-status-field rounded"><span class="text-info font-weight-bold" id="' . $item['ordered_article_id'] . '">Bestellt</span></p>'; 
            }
            if($item['status'] == 1){
            echo '<p class="order-status-field rounded"><span class="text-warning font-weight-bold" id="' . $item['ordered_article_id'] . '">Im Ofen</span></p>'; 
            }
            if($item['status'] == 2){
            echo '<p class="order-status-field rounded"><span class="text-success font-weight-bold" id="' . $item['ordered_article_id'] . '">Fertig</span></p>'; 
            }
            if($item['status'] == 3){
            echo '<div class="text-center"><p class="order-status-field rounded"><span class="text-primary font-weight-bold" id="' . $item['ordered_article_id'] . '">Unterwegs</span></p></div>'; 
            }
            echo '</div>';
        }
        echo '</div>';

        if(!count($orders)){
            echo '<p class="pb-2 text-danger">Du hast noch keine Bestellung getätigt.</p>';
            echo '<div class="seperator"></div>';
        } else {
            echo '<div class="seperator"></div><div id="order-price-total" ><h4>Gesamtpreis: ' . $totalPrice . '€</h4></div>';
            echo '<div class="seperator"></div>';
        }
        echo <<<HTML
              
        </section>
HTML;
        $this->generatePageFooter();
    }
    
    protected function processReceivedData(): void 
    {
    
    }

    public static function main(): void
    {
        try {
            $page = new Costumer();
            $page->processReceivedData();
            $page->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Costumer::main();