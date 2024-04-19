<?php declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';

class Add extends Page
{
    protected function __construct()
    {
        parent::__construct();

        // to do: instantiate members representing substructures/blocks
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    protected function getViewData():array
    {
        $SQLabfrage = "SELECT * FROM zielflughafen";
        $Recordset = $this->database->query($SQLabfrage);
        if (!$Recordset) {
            throw new Exception("Kein Flughafen in der Datenbank");
        }
        $Flughafen = array();

        // Benoetigte Eintraege für HTML-Ausgabe auslesen
        $Record = $Recordset->fetch_assoc();
        while ($Record) {
            $MyZielflughafen = $Record["Zielflughafen"];
            $MyLand = $Record["Land"];
            $Flughafen[$MyZielflughafen] = $MyLand;
            $Record = $Recordset->fetch_assoc();
        }
        $Recordset->free();

        return $Flughafen;
    }

    private function insert_tablerow(string $indent, string $entry1 = "", string $entry2 = "", string $entry3 = ""):void
    {
        echo $indent . "<tr>\n";
        echo $indent . "\t<td>$entry1</td>\n";
        echo $indent . "\t<td>$entry2</td>\n";
        echo $indent . "\t<td>$entry3</td>\n";
        echo $indent . "</tr>\n";
    }

    protected function generateView()
    {
        $Flughafen = $this->getViewData();

        $this->generatePageHeader('Hinzufügen');
        echo <<<HERE
		<h1>Tabelle der Flughäfen:</h1>
		<form action="Add.php" method="post">
		<table>
			<tr>
				<th>Zielflughafen</th>
				<th>Land</th>
				<th>Zielflughafen (Land)</th>
			</tr>

HERE;

        foreach ($Flughafen as $Zielflughafen => $Land) {
            $Zielflughafen = htmlspecialchars($Zielflughafen);
            $Land = htmlspecialchars($Land);
            $this->insert_tablerow("\t\t\t", $Zielflughafen, $Land, $Zielflughafen . " (" . $Land . ")");
        }
        echo <<<HERE
			<tr>
				<td><input type="text" name="Zielflughafen" size="25" maxlength="50"/></td>
				<td><input type="text" name="Land" size="25" maxlength="50"/></td>
				<td><input type="submit" value="Hinzufügen"/></td>
			</tr>
		</table>
		</form>

HERE;
        $this->generatePageFooter();
    }

    protected function processReceivedData():void
    {
        parent::processReceivedData();

        // Aufruf prüfen:
        if (isset($_POST["Zielflughafen"]) && isset($_POST["Land"])) {
            // Aufruf durch Formular
            $InZielflughafen = $_POST["Zielflughafen"];
            $InLand = $_POST["Land"];
            if (strlen($InZielflughafen) <= 0 || strlen($InLand) <= 0) {
                throw new Exception("Bitte geben Sie in beiden Feldern etwas an!");
            } else {
                $sqlZielflughafen = $this->database->real_escape_string($InZielflughafen);
                $sqlLand = $this->database->real_escape_string($InLand);

                // Doppeleintrag verhindern:
                $SQLabfrage = "SELECT * FROM zielflughafen WHERE " .
                    "Zielflughafen = \"$sqlZielflughafen\" AND Land = \"$sqlLand\"";
                $Recordset = $this->database->query($SQLabfrage);

                if ($Recordset->num_rows > 0) {
                    $Recordset->free();
                    throw new Exception("Dieser Flughafen ist bereits eingetragen.");
                } else { // also neu eintragen!
                    $SQLabfrage = "INSERT INTO zielflughafen SET " .
                        "Zielflughafen = \"$sqlZielflughafen\", Land = \"$sqlLand\"";
                    $this->database->query($SQLabfrage);
                }
            }
        }
    }

    public static function main():void
    {
        try {
            $page = new Add();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Add::main();
