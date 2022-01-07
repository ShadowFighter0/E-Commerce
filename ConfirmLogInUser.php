<?php

    require_once "WebBuilders" . DIRECTORY_SEPARATOR . "WebBuilder.php";

    echo CreateConfirmLogIn();

    function CreateConfirmLogIn()
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
        if (isset($_POST["Email"])
        and isset($_POST["Password"]))
        {
            $webBuilder = new WebBuilder();

            $sqliConnection = $webBuilder->sql->OpenSqli();

            $jquery = $sqliConnection->prepare("SELECT * FROM users WHERE Email = ?");
            $jquery->bind_param("s", $_POST["Email"]);
            $jquery->execute();
            $result = $jquery->get_result();

            $webBuilder->sql->CloseConnection();

            $result->data_seek(0);
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if ($result->num_rows > 0)
            {
                $password = $_POST["Password"];

                if ($webBuilder->DeHashPassword($password, $row["passwordHashed"]))
                {
                    setcookie("login", "1", time() + 30 * 60);
                    setcookie("userId", $row["User_Id"], time() + 30 * 60);

                    if($row["isAdmin"])
                    {
                        setcookie("isAdmin", "1", time() + 30 * 60);
                    }

                    //Redirect to index Signed in
                    header("Location: index.php");
                }
                else
                {
                    return "<p>The email or password is incorrect. Please go <a href =\"LogIn.php \"> here </a> and try again.</p>";
                }
            }
            else
            {
                return "<p>The email or password is incorrect. Please go <a href =\"LogIn.php \"> here </a> and try again.</p>";
            }
        }
        else
        {
            return "<p>Something went wrong. Please go <a href= \"LogIn.php\"> here </a></p>";
        }
    }
?>