<?php

require_once "WebBuilders" . DIRECTORY_SEPARATOR . "WebBuilder.php";
  
if(isset($_COOKIE["login"]  ))
{
    $webBuilder = new WebBuilder();

    $connection = $webBuilder->sql->OpenSqli();

    $connection->query("UPDATE users SET isAdmin = true WHERE User_Id = ". $_COOKIE["userId"]);
    
    $webBuilder->sql->CloseConnection();

    setcookie("isAdmin", "1", time() + 30 * 60);                    

    header("Location: MyAccount.php");
}


?>