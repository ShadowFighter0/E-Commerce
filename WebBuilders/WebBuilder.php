<?php

    require_once "mysqli.php";
    require_once "WebBuilders" . DIRECTORY_SEPARATOR . "NavBar.php";

    define ("NAVBAR_STYLE_PATH", "CSS/NavBar.css");    
    define ("INDEX_STYLE_PATH", "CSS/Index.css");   

class WebBuilder{

    private $navBar;

    function __construct()
    {
        $this->navBar = new NavBar();
    }

    function WriteHeaderLinks()
    {
        $html  = "";
        $html .= "<link rel=\"stylesheet\" href=" . NAVBAR_STYLE_PATH . ">";
        $html .= "<link rel=\"stylesheet\" href=" . INDEX_STYLE_PATH . ">";

        return $html;
    }

    function CreateNavBar()
    {
        return $this->navBar->CreateNavBar();
    }
}


?>