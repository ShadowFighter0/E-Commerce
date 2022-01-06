<?php 

    require_once "WebBuilders/WebBuilder.php";

    echo AddToCartPage();

    function AddToCartPage()
    {
        $html = "";

        //Start HTML
        $html .= "<html>";
        $html .= "<head>";

        //Write Head
            $html .= "<link rel=\"stylesheet\" href=\"CSS" . DIRECTORY_SEPARATOR ."Confirm.css\"/>";
        
        $html .= "</head>";

        //Open Body
        $html .= "<body>";

         $html .= CreateBody();        
        
        $html .= "</body>";
        $html .= "</html>";

        return $html;
    }

    function CreateBody()
    {
        if (isset($_COOKIE["login"]))
        {
            if (isset($_GET["id"]) and isset($_GET["type"]))
            {
                $webBuilder = new WebBuilder();

                $sqliConnection = $webBuilder->sql->OpenSqli();

                $result = $sqliConnection->query("SELECT * FROM " . $_GET["type"] . " WHERE Product_Id = " . $_GET["id"]);
                $result = $result->fetch_array(MYSQLI_ASSOC);

                if($result["Amount"] > 1)
                {
                    $jquery = $sqliConnection->prepare("SELECT * FROM users WHERE email = ?");
                    $jquery->bind_param("s", $_COOKIE["email"]);
                    $jquery->execute();
                    $userResult = $jquery->get_result();
    
                    $row = $userResult->fetch_array(MYSQLI_ASSOC);
    
                    $jquery = $sqliConnection->prepare("SELECT * FROM shopinglist WHERE User_Id = ? and Type = ? and Product_Id = ?");
                    $jquery->bind_param("isi", $row["User_Id"], $_GET["type"] ,$_GET["id"]);
                    $jquery->execute();
                    $shopResult = $jquery->get_result();
                    
                    if($shopResult->num_rows > 0)
                    {
                        $shopResult = $shopResult->fetch_array(MYSQLI_ASSOC);
                        //Add one to the thing
                        $newAmount = $shopResult["Amount"] + 1;
                        $sqliConnection->query("UPDATE shopinglist SET Amount = $newAmount WHERE ShopingItem_Id = " . $shopResult["ShopingItem_Id"]);
                    }
                    else
                    {
                        //Add one new
                        $sqliConnection->query("INSERT INTO shopinglist (User_Id, Product_Id, Type,	Amount)
                        VALUES (". $row["User_Id"] ."," . $_GET["id"].",'" . $_GET["type"]. "'," . 1 . ")");
                    }

                    $newAmount = $result["Amount"] - 1;
                    //Remove one of the amount
                    $jquery = $sqliConnection->prepare("UPDATE " . $_GET["type"]. " SET Amount = ? WHERE Product_Id = ?");
                    $jquery->bind_param("ii", $newAmount, $_GET["id"]);
                    $jquery->execute();

                    
                    $webBuilder->sql->CloseConnection();
                    header("Location: ShoppingList.php");
                }
                else
                {
                    echo "<p> Sorry, we ran out of stock. Click <a href = Index.php>here</a> to go back to the main page<p>";
                }
            }
            else
            {
                return "<p> Something went wrong</p>"; 
            }
        }
        else
        {
            return "<p> You need to be registered to use this function. <br> Click <a href = SignUp.php>here</a> to register or <a href =LogIn.php>here</a> to log in.</p>";
        }
    }       
?>