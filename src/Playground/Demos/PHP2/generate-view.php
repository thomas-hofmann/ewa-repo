<?php declare(strict_types=1);

require_once './Page.php';

class Lecture extends Page
{
    /**
     * @throws Exception
     */
    protected function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    /**
	 * @return array
     */
    protected function getViewData():array
    {
        $sql = "SELECT Zielflughafen, Land FROM zielflughafen GROUP BY Zielflughafen";

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

    /**
	 * @return void
     */
    protected function generateView():void
    {
        $data = $this->getViewData();
        $this->generatePageHeader('generateView Demo');

        echo '<h2>generateView</h2>';
        
        foreach($data as $index => $item) {
            echo '<p>';
            echo $index + 1 . ' - <b>Zielflughafen:</b> ' . $item['Zielflughafen'] . ', <b>Land:</b> ' . $item['Land'];
            echo '</p>';
        }

        $this->generatePageFooter();
    }

    /**
	 * @return void
     */
    protected function processReceivedData():void
    {
        parent::processReceivedData();
    }

    /**
	 * @return void
     */
    public static function main():void
    {
        try {
            $page = new Lecture();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Lecture::main();