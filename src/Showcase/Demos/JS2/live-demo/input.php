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
        $this->generatePageHeader('Ajax Request');

        echo <<< HTML
            <h1>Ajax: Input</h1>
            <hr>
            <h2>Neuen Flughafen in Deutschland erstellen</h2>
            <form action="input.php" method="get" accepted-charset="utf-8">
                <input type="text" name="newAirbaseName" value="" placeholder="Name" required>
                <input type="hidden" name="newAirbaseLand" value="Deutschland">
                <input type="submit" value="Abschicken">
            </form>
            <p style="color:red;"><small>Name muss unique sein.</small></p>
        HTML;

        $this->generatePageFooter();
    }

    /**
	 * @return void
     */
    protected function processReceivedData():void
    {
        if(isset($_GET['newAirbaseName']) && isset($_GET['newAirbaseLand'])) {
            $name = $this->_database->real_escape_string($_GET['newAirbaseName']);
            $land = $this->_database->real_escape_string($_GET['newAirbaseLand']);

            $SQLabfrage = "INSERT INTO zielflughafen SET " . "Zielflughafen = \"$name\", Land = \"$land\"";

            $this->_database->query($SQLabfrage);

            // PRG PATTERN
            header('Location: input.php');
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