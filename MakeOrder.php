<?php

    require_once "WebBuilders" . DIRECTORY_SEPARATOR . "WebBuilder.php";

    $webBuilder = new WebBuilder;

    $connection = $webBuilder->sql->OpenSqli();

    $result = $connection->query("SELECT * FROM shopinglist Where User_Id = " . $_COOKIE["userId"]);

    $description = "";
    $price = 0;

    for ($i = 0 ; $i < $result->num_rows; $i++)
    {
        $result->data_seek($i);
        $shopListArray = $result->fetch_array(MYSQLI_ASSOC);


        $item = $connection->query("SELECT * FROM " . $shopListArray["Type"] . " Where Product_Id = " . $shopListArray["Product_Id"]);

        $item = $item->fetch_array(MYSQLI_ASSOC);
        $description .= $item["Title"] . " x" . $shopListArray["Amount"] . "\n";
        $price += $item["Price"] * $shopListArray["Amount"];
    }

    $date = getdate();
    $date = $date["mday"] . "/" . $date["mon"] . "/" . $date["year"];

    //Create order
    $connection->query("INSERT INTO orders (User_Id, Details, TotalPrice, Date) VALUES (". $_COOKIE["userId"].", '$description', $price, '$date')");

    //Clean the shoping List
    $connection->query("DELETE FROM shopinglist Where User_Id = " . $_COOKIE["userId"]);

    header("Location:MyAccount.php");
?>