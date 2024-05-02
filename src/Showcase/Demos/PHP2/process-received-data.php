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
        echo '<h2>processReceivedData()</h2>';
        
        echo <<< HTML
            <h3>Neuen Kunden erstellen</h3>
            <form action="process-received-data.php" method="post" accepted-charset="utf-8">
                <input type="text" name="firstname" value="" placeholder="Vorname">
                <input type="text" name="lastname" value="" placeholder="Nachname">
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
        if(isset($_POST['firstname']) && isset($_POST['lastname'])) {

            $firstname = $this->_database->real_escape_string($_POST['firstname']);
            $lastname = $this->_database->real_escape_string($_POST['lastname']);

            $SQLabfrage = "INSERT INTO kunde SET " .
                        "Vorname = \"$firstname\", Name = \"$lastname\"";

            $this->_database->query($SQLabfrage);

            // PRG PATTERN
            // Seite wird neu OHNE Formulardaten geladen
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