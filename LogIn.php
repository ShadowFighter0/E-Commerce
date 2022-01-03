<?php

echo CreateLogIn();



function CreateLogIn()
{
    $html = "";

    $html .= "<html>";
    $html .= "<head>";

        $html .= "<link rel=\"stylesheet\" href=\"CSS" . DIRECTORY_SEPARATOR ."SignUpLogIn.css\"/>";
    
    $html .= "</head>";


    $html .= "<body>";

        $html .= CreateBody();

    $html .= "</body>";
    $html .= "</html>";

    return $html;
}

function CreateBody()
{
    $html = "<div id = Container>";

        $html .= "<p>Log In</p>";

        $html .= "<div class = Field>";
            $html .= "<br><span> Email </span>";
            $html .= "<form method='post' action = 'ConfirmLogInUser.php'>";
            $html .= "<input class = Input type = 'email' name = 'Email' placeholder = \"Enter Email...\" required>";
        $html .= "</div>";

        $html .= "<div class = Field>";
            $html .= "<br><span> Password </span>";
            $html .= "<input class = Input type = 'password' name ='Password' placeholder = \"Enter Password...\" required>";
        $html .= "</div>";

        $html .= "<button type=\"submit\">Submit</button>";
        $html .= "</form>";

    $html .= "</div>";

    return $html;
}

