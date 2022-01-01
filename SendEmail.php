<?php

    require_once "WebBuilders" . DIRECTORY_SEPARATOR . "WebBuilder.php";

    if (isset($_POST["Name"]) 
    and isset($_POST["Email"]) 
    and isset($_POST["Password"]) 
    and isset($_POST["ConfirmPassword"]))
    {
        $email = $_POST["Email"];

        $webBuilder = new WebBuilder();
        $query = "SELECT * FROM users WHERE email = '$email'";
    
        $sqliConnection = $webBuilder->sql->OpenSqli();
        $results = $sqliConnection->query($query);
        $webBuilder->sql->CloseConnection();
    
        if ($results->num_rows > 0)
        {
            $string = "<p> User Created </p>";

            //TODO Insert user in table

            $sqliConnection = $webBuilder->sql->OpenSqli();
            $query = ""
            $results = $sqliConnection->query($query);
            $webBuilder->sql->CloseConnection();

            $string .= "<br><br><p> Check your email to verify your email </p>";
            
            //TODO Send Email
            echo $string;
        }
        else
        {
            echo "<p> This email has been already registered. Please Log In <a href = \"LogIn.php\">here</a>.";
        }
    }
    else
    {
        echo "<p> Something went wrong. Please go <a href =\"SignUp.php\">here</a> </p>";
    }
?>