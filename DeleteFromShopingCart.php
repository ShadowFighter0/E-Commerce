<?php

require_once "Webbuilders" . DIRECTORY_SEPARATOR . "WebBuilder.php";

if (isset($_COOKIE["login"]))
{
    $webBuilder = new WebBuilder();
    
    if (isset($_GET["shopId"]) and isset($_GET["amount"]))
    {
        $sqliconnection = $webBuilder->sql->OpenSqli();

        //Get the ShopItem
        $jquery = $sqliconnection->prepare("SELECT * FROM shopinglist WHERE ShopingItem_Id = ?");
        $jquery->bind_param("i",$_GET["shopId"]);
        $jquery->execute();
        $resultShop = $jquery->get_result();

        if ($resultShop->num_rows > 0)
        {
            $resultShop = $resultShop->fetch_array(MYSQLI_ASSOC);

            //Get the type row
            $jquery = $sqliconnection->prepare("SELECT * FROM " . $resultShop["Type"] . " WHERE Product_Id = ?");
            $jquery->bind_param("i",$resultShop["Product_Id"]);
            $jquery->execute();
            $typeResult = $jquery->get_result();

            $typeResult = $typeResult->fetch_array(MYSQLI_ASSOC);

            $itemAmount = $typeResult["Amount"] + $_GET["amount"];

            //Update the amount
            $jquery = $sqliconnection->prepare("UPDATE " . $resultShop["Type"]. " SET Amount = ? WHERE Product_Id = ?");
            $jquery->bind_param("ii", $itemAmount, $resultShop["Product_Id"]);
            $jquery->execute();

            //Delete or Remove from the shop
            $newAmount = $resultShop ["Amount"] - $_GET["amount"];
            if($newAmount > 0)
            {
                //Remove 1 from the shoping list
                $jquery = $sqliconnection->prepare("UPDATE shopinglist SET Amount = ? WHERE ShopingItem_Id = ?");
                $jquery->bind_param("ii", $newAmount, $_GET["shopId"]);
                $jquery->execute();        
            }
            else
            {
                //Remove all
                $jquery = $sqliconnection->prepare("DELETE FROM shopinglist WHERE ShopingItem_Id = ?");
                $jquery->bind_param("i",$_GET["shopId"]);
                $jquery->execute();
            }
        }

        $webBuilder->sql->CloseConnection();
        header("Location: ShoppingList.php");
    }
}
else
{
    header("Location: index.php");
}


?>