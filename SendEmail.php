<?php

    require_once "WebBuilders" . DIRECTORY_SEPARATOR . "WebBuilder.php";

    echo CreateSendEmail();

    function CreateSendEmail()
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

        if (isset($_POST["Name"]) 
        and isset($_POST["Email"]) 
        and isset($_POST["Password"]) 
        and isset($_POST["ConfirmPassword"]))
        {
            if($_POST["Password"] == $_POST["ConfirmPassword"])
            {
                $email = $_POST["Email"];

                $webBuilder = new WebBuilder();
        
                //DEBUG

                $sqliConnection = $webBuilder->sql->OpenSqli();

                $sqliConnection->query("Delete From users");

                $webBuilder->sql->CloseConnection();

                //CLOSEDEBUG

                
                $sqliConnection = $webBuilder->sql->OpenSqli();
        
                $jquery = $sqliConnection->prepare("SELECT * FROM users WHERE email = ?");
                $jquery->bind_param("s", $email);
                $jquery->execute();
                
                $results = $jquery->get_result();
                
                $webBuilder->sql->CloseConnection();
            
                if ($results->num_rows == 0)
                {
                    $pass = $_POST["Password"];
        
                    $passHashed = $webBuilder->HashPassword($pass);
        
                    $sqliConnection = $webBuilder->sql->OpenSqli();

                    $results = $sqliConnection->query("SELECT * FROM users");


                    $userId = $results->num_rows;
                    $name = mysqli_real_escape_string($sqliConnection, $_POST["Name"]);
                    $email = mysqli_real_escape_string($sqliConnection, $email);
                    $passHashed = mysqli_real_escape_string($sqliConnection, $passHashed);
                    $false = (int)false;

                    $jquery = $sqliConnection->prepare("INSERT INTO users VALUES ($userId,'$name','$email','$passHashed',$false)");
                    $jquery->execute();
        
                    $webBuilder->sql->CloseConnection();
                    
                    //TODO Send Email
                    echo "<p> User Created </p><br><br><p> Check your email to verify your email.</p>";
                }
                else
                {
                    echo "<p> This email has already been registered. Please Log In <a href = \"LogIn.php\">here</a> or use a different email.";
                }
            }
            else
            {
                echo "<p> Password does not match. Please go <a href =\"SignUp.php\">here</a> and try again.</p>";
            }
        }
        else
        {
            echo "<p> Something went wrong. Please go <a href =\"SignUp.php\">here</a> and try again.</p>";
        }
    }
?>