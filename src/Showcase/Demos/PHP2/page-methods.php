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
        echo '<p> 3. getviewData()</p>';
        return [];
    }

    /**
	 * @return void
     */
    protected function generateView():void
    {
        echo '<p> 2. generateView()</p>';
        $this->getViewData();
        $this->generatePageHeader('Page Methods Demo');
        echo '<section style="background: #FFCCCB; min-height: 200px;"><h2>Inhalt<h2></section>';
        $this->generatePageFooter();
    }

    /**
	 * @return void
     */
    protected function processReceivedData():void
    {
        header("Content-type: text/html; charset=UTF-8");
        echo '<p>1. processReceivedData()</p>';
        
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