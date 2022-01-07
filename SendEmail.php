<?php

use PHPMailer\PHPMailer\PHPMailer;

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
        //If we are logged
        if (isset($_POST["Name"]) and $_POST["Name"] != ""
        and isset($_POST["Email"]) and $_POST["Email"] != "" 
        and isset($_POST["Password"]) and $_POST["Password"] != ""
        and isset($_POST["ConfirmPassword"]) and $_POST["ConfirmPassword"] != "" ) 
        {
            //And Passwords match
            if($_POST["Password"] == $_POST["ConfirmPassword"])
            {
               
                $webBuilder = new WebBuilder();

                $email = $_POST["Email"];
                
                $sqliConnection = $webBuilder->sql->OpenSqli();
        
                $jquery = $sqliConnection->prepare("SELECT * FROM users WHERE email = ?");
                $jquery->bind_param("s", $email);
                $jquery->execute();
                
                $results = $jquery->get_result();
            
                if ($results->num_rows == 0)
                {
                    $pass = $_POST["Password"];
        
                    $passHashed = $webBuilder->HashPassword($pass);

                    $emailKey = GenerateRandomCode();
                    $name = mysqli_real_escape_string($sqliConnection, $_POST["Name"]);
                    $email = mysqli_real_escape_string($sqliConnection, $email);
                    
                    $sqliConnection = $webBuilder->sql->OpenSqli();

                    $results = $sqliConnection->query("SELECT * FROM users");
                    $userId = $results->num_rows;
                    $passHashed = mysqli_real_escape_string($sqliConnection, $passHashed);
                    $false = (int)false;
                    
                    $jquery = $sqliConnection->prepare("INSERT INTO users VALUES ($userId,'$name','$email','$passHashed',$false, '$emailKey', false)");
                    $jquery->execute();
        
                    $webBuilder->sql->CloseConnection();

                    setcookie("login", "1", time() + 30 * 60);
                    setcookie("userId", $userId, time() + 30 * 60);
                    
                    echo "<p> User Created</p> <br> <p> Click <a href = index.php> here </a> to go back to the main menu</p>";
                }
                else
                {
                    $webBuilder->sql->CloseConnection();
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


    function GenerateRandomCode()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $result = '';
        for($i=0; $i < 50; $i++)
        {
            $result .= $characters[mt_rand(0, 61)];
        }

        return $result;
    }
?>