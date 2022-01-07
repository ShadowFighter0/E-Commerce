<?php

    require_once "WebBuilders" . DIRECTORY_SEPARATOR . "WebBuilder.php";


    if(isset($_COOKIE["login"]) and isset($_COOKIE["isAdmin"]))
    {
        $webBuilder = new WebBuilder();

        $connection = $webBuilder->sql->OpenSqli();

        //Delete from users
        $connection->query("DELETE FROM users WHERE User_Id = " . $_GET["userId"]);

        //Give back the items in the shoppingList
        $shopingList = $connection->query("SELECT * FROM shopinglist WHERE User_Id = " . $_GET["userId"]);

        for($i = 0 ; $i < $shopingList->num_rows; $i++)
        {
            $shopingList->data_seek($i);
            $shopingItem = $shopingList->fetch_array(MYSQLI_ASSOC);

            //Get the item
            $item = $connection->query("SELECT * FROM ". $shopingItem["Type"]. " WHERE Product_Id = " . $shopingItem["Product_Id"]);
            $item = $item->fetch_array(MYSQLI_ASSOC);

            //Update the item
            $itemAmount = $item["Amount"] + $shopingItem["Amount"];

            $jquery = $connection->prepare("UPDATE " . $shopingItem["Type"]. " SET Amount = ? WHERE Product_Id = ?");
            $jquery->bind_param("ii", $itemAmount, $shopingItem["Product_Id"]);
            $jquery->execute();

        }
        //Remove all
        $jquery = $connection->prepare("DELETE FROM shopinglist WHERE ShopingItem_Id = ?");
        $jquery->bind_param("i",$_GET["shopId"]);
        $jquery->execute();

        //Delete from shopingList
        $connection->query("DELETE FROM shopingList WHERE User_Id = " . $_GET["userId"]);

        //Delete from orders
        $connection->query("DELETE FROM orders WHERE User_Id = " . $_GET["userId"]);

        $webBuilder->sql->CloseConnection();

        //Bye Bye
        if($_COOKIE["userId"] == $_GET["userId"])
        {
            header("Location:LogOut.php");
        }
        else
        {
            header("Location:MyAccount.php");
        }
        
    }
?>