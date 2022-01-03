<?php

    require_once "WebBuilders" . DIRECTORY_SEPARATOR . "WebBuilder.php";
  
    echo CreateMyAccount();

    function CreateMyAccount()
    {
        $html = "<html>";
        $html .= "<head>";
            $html .= "<link rel=\"stylesheet\" href=\"CSS" . DIRECTORY_SEPARATOR ."Confirm.css\"/>";
        $html .= "</head>";
        $html .= "<body>";
            $html .= CreateBody();
        $html .= "</body>";
        $html .= "</html>";
    
        return $html;
    }

    function CreateBody()
    {
        
    }
?>