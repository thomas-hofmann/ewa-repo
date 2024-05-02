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
        $this->generatePageHeader('Ajax Request/Response', true);
        echo '<h1>Ajax: Output</h1>';
        echo '<hr>';
        echo '<h2>Diese Liste wird in Echtzeit aktualisiert</h2>';
        echo '<section id="output"></section>';
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