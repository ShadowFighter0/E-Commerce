<?php


if(isset($_COOKIE["login"]) and isset($_COOKIE["isAdmin"]))
{
    require_once "WebBuilders" . DIRECTORY_SEPARATOR . "WebBuilder.php";
    
    $webBuilder = new WebBuilder;

    $connection = $webBuilder->sql->OpenSqli();

    $connection->query("DELETE from " . $_GET["type"] . " where Product_Id = " . $_GET["id"]);

    $webBuilder->sql->CloseConnection();
    header("Location: index.php");
}


?>