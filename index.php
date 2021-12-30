<?php
    
    require_once "WebBuilders/WebBuilder.php";
    
    echo IndexPage();

    function IndexPage()
    {
        $html = "";
        //Create WebBuilder
        $webBuilder = new WebBuilder();

        //Start HTML
        $html .= "<html>";
        $html .= "<head>";

        //Write Head
        $html .= $webBuilder->WriteHeaderLinks();
        
        $html .= "</head>";

        //Open Body
        $html .= "<body>";

        $html .= CreateBody($webBuilder);        
        
        $html .= "</body>";
        $html .= "</html>";

        return $html;
    }

    function CreateBody($webBuilder)
    {
        $html = $webBuilder->CreateNavBar();

        $html .= CreateInitialText();

        return $html;
    }

    function CreateInitialText()
    {
        $html = "<div id = InitialText>";
        $html .= "<p>Welcome!</p>";
        $html .= "<p>In this page you will find Films and TV Shows to buy. You can also search for a specific Film or Tv Show.</p>";
        $html .= "</div>";

        return $html;
    }

?>