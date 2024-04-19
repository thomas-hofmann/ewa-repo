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
        return [];
    }

    /**
	 * @return void
     */
    protected function generateView():void
    {
        $this->generatePageHeader('processReveivedData Demo');
        echo '<h2>processReceivedData</h2>';
        
        if(isset($_SESSION['check']) && $_SESSION['check']) {
            echo '<h2>Flughafen wurde erfolgreich der Datenbank zugefügt</h2>';
            echo '<hr>';
            $_SESSION['check'] = false;
        }
        
        echo <<< HTML
            <h3>Neuen Flughafen erstellen</h3>
            <form action="process-received-data.php" method="get" accepted-charset="utf-8">
                <input type="text" name="newAirbaseName" value="" placeholder="Name" required>
                <input type="text" name="newAirbaseLand" value="" placeholder="Land" required>
                <input type="submit" value="Abschicken">
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
        if(isset($_GET['newAirbaseName']) && isset($_GET['newAirbaseLand'])) {

            $name = $this->_database->real_escape_string($_GET['newAirbaseName']);
            $land = $this->_database->real_escape_string($_GET['newAirbaseLand']);

            $SQLabfrage = "INSERT INTO zielflughafen SET " .
                        "Zielflughafen = \"$name\", Land = \"$land\"";

            $this->_database->query($SQLabfrage);

            $_SESSION['check'] = true;

            // PRG PATTERN
            header('Location: process-received-data.php');
            exit();
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