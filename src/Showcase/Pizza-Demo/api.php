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
        $jsonData = json_encode($orders);

        header('Content-Type: application/json');
        echo $jsonData;
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