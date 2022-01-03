<?php

echo CreateSignUp();

function CreateSignUp()
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

        $html .= "<p>Create New User</p>";

        $html .= "<div class = Field>";
            $html .= "<br><span> Name </span>";
            $html .= "<form method='post' action = 'SendEmail.php'>";
            $html .= "<input class = Input type = 'text' name ='Name' placeholder = \"Enter Name...\" required>";
        $html .= "</div>";

        $html .= "<div class = Field>";
            $html .= "<br><span> Email </span>";
            $html .= "<input class = Input type = 'email' name ='Email' placeholder = \"Enter Email...\" required>";
        $html .= "</div>";

        $html .= "<div class = Field>";
            $html .= "<br><span> Password </span>";
                $html .= "<input class = Input type = 'password' name ='Password' placeholder = \"Enter Password...\" required>";
        $html .= "</div>";

        $html .= "<div class = Field>";
            $html .= "<br><span> Confirm Password </span>";
            $html .= "<input class = Input type = 'password' name ='ConfirmPassword' placeholder = \"Confirm Password...\" required>";
        $html .= "</div>";

        $html .= "<button type=\"submit\">Submit</button>";

        $html .= "</form>";

    $html .= "</div>";

    return $html;
}

