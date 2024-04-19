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
        $this->generatePageHeader('Meine Seite');

        echo '<h1>Live Coding</h1>';
        echo '<hr>';

        if(isset($_SESSION['airbases'])) {
            $sessionData = $_SESSION['airbases'];
            echo ' <h2>Session</h2>';
            foreach($sessionData as $item) {
                echo <<< HTML
                    <p>$item</p>
                HTML;
            }

            echo '<pre>';
            var_dump($_SESSION);
            echo '</pre>';
            echo '<hr>';
        }

        echo <<< HTML
            <h2>Select</h2>
            <form action="live-coding-php2.php" method="post" accepted-charset="utf-8">
                <select name="airbases[]" size="5" multiple>
        HTML;
        
        foreach($data as $index => $item) {
            $land = $item['Land'];
            $zielFlughafen = $item['Zielflughafen'];
            echo <<< HTML
                <option value="$land-$zielFlughafen">$zielFlughafen, $land</option>
            HTML;
        }

        echo <<< HTML
                </select>
                <p>
                    <input type="submit" value="Abschicken">
                </p>
            </form>
        HTML;

        $this->generatePageFooter();
    }

    /**
	 * @return void
     */
    protected function processReceivedData():void
    {
        session_start();
        if(isset($_POST['airbases'])) {
            $_SESSION['airbases'] = $_POST['airbases'];
            header('Location: live-coding-php2.php');
        }
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