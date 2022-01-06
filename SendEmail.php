<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once "WebBuilders" . DIRECTORY_SEPARATOR . "WebBuilder.php";

    require_once "PHPMAILER" . DIRECTORY_SEPARATOR . "Exception.php";
    require_once "PHPMAILER" . DIRECTORY_SEPARATOR . "SMTP.php";
    require_once "PHPMAILER" . DIRECTORY_SEPARATOR . "PHPMAILER.php";

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


                    $to      = $email;
                    $subject = 'Confirmation Email';
                    $message = "Please click <a href = localhost/activate.php?$emailKey> here <a> to activate your key. If that didnt work try copying and pasting this adresslocalhost/activate.php?$emailKey.";
                    $headers = 'From: apidprieto21@gmail.com'       . "\r\n" .
                    'Reply-To: apidprieto21@gmail.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                    if (mail($to, $subject, $message, $headers))
                    {
                        $sqliConnection = $webBuilder->sql->OpenSqli();

                        $results = $sqliConnection->query("SELECT * FROM users");
                        $userId = $results->num_rows;
                        $passHashed = mysqli_real_escape_string($sqliConnection, $passHashed);
                        $false = (int)false;
                        
                        $jquery = $sqliConnection->prepare("INSERT INTO users VALUES ($userId,'$name','$email','$passHashed',$false, '$emailKey')");
                        $jquery->execute();
            
                        $webBuilder->sql->CloseConnection();
                        
                       
                        echo "<p> User Created </p><br><br><p> Check your email to verify your email.</p>";
                    }
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