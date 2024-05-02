<?php declare(strict_types=1);

abstract class Page
{
    protected MySQLi $_database;
    protected $pageMethodsDemo = false;

    protected function __construct()
    {
        error_reporting(E_ALL);

        $host = "localhost";
        /********************************************/
        // This code switches from the the local installation (XAMPP) to the docker installation 
        if (gethostbyname('mariadb') != "mariadb") { // mariadb is known?
            $host = "mariadb";
        }
        /********************************************/

        $this->_database = new MySQLi($host, "public", "public", "reisebuero");

        if (mysqli_connect_errno()) {
            throw new Exception("Connect failed: " . mysqli_connect_error());
        }

        // set charset to UTF8!!
        if (!$this->_database->set_charset("utf8")) {
            throw new Exception($this->_database->error);
        }
    }

    public function __destruct()
    {
    }

    /**
     * @param string $title $title is the text to be used as title of the page
     * @param string $jsFile path to a java script file to be included, default is "" i.e. no java script file
     * @param bool $autoreload  true: auto reload the page every 5 s, false: not auto reload
     * @return void
     */
    protected function generatePageHeader(string $title = "", string $jsFile = "", bool $autoreload = false):void
    {
        $title = htmlspecialchars($title);

        // Falls es sich um page-methods.php handelt
        if ($title == 'Page Methods Demo') {
            $this->pageMethodsDemo = true;
        }

        // Achtung: Zu Demozwecken wollen wir den header bei der "page-methods.php" früher setzen
        if (!$this->pageMethodsDemo) {
            header("Content-type: text/html; charset=UTF-8");
        }

        $extraHeading = '';
        $extraStyle = '';
        // Achtung: Außerdem wollen wir für die Demo "page-methods.php" einige style Anpassungen machen
        // Sie sollten verstehen was hier passiert und ggf. anpassen bevor Sie den Code copy & pasten
        if ($this->pageMethodsDemo) {
            $extraHeading = '<p> 4. generatePageHeader()</p>';
            $extraStyle = 'style="background:lightBlue"';
        }

        echo <<< HTML
            <!-- HEADER -->
            <!DOCTYPE html>
            <html lang="de">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>$title</title>
            </head>
            <body>
                <header $extraStyle>
                    $extraHeading
                    <h1>PHP: Teil 2 Demos</h1>
                    <nav>
                        <a href="/">Home</a>
                        <a href="/playground">Playground</a>
                    </nav>
                    <hr>
                </header>
                <!-- MAINCONTENT -->
        HTML;
    }

    /**
	 * @return void
     */
    protected function generatePageFooter():void
    {
        $extraHeading = '';
        $extraStyle = '';
        // Achtung: Außerdem wollen wir für die Demo "page-methods.php" einige style Anpassungen machen
        // Sie sollten verstehen was hier passiert und ggf. anpassen bevor Sie den Code copy & pasten
        if ($this->pageMethodsDemo) {
            $extraHeading = '<p> 5. generatePageFooter()</p>';
            $extraStyle = 'style="background:lightGreen;"';
        }

        echo <<< HTML
            <!-- FOOTER -->
            <footer $extraStyle>
                <hr>
                $extraHeading
                <p>&#169 Thomas Hofmann</p>
            </footer>
            </body>
            </html>
        HTML;
    }

    /**
	 * @return void
     */
    protected function processReceivedData():void
    {

    }
}