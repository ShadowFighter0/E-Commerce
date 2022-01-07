<?php 


require_once "WebBuilders" . DIRECTORY_SEPARATOR . "WebBuilder.php";

    echo ShoppingPage();

    function ShoppingPage()
    {
        $html = "";
        //Create WebBuilder
        $webBuilder = new WebBuilder();

        //Start HTML
        $html .= "<html>";
        $html .= "<head>";

        //Write Head
        $html .= $webBuilder->WriteHeaderLinksForShoppingList();
        
        $html .= "</head>";

        //Open Body
        $html .= "<body>";


        $html .= CreateBody($webBuilder);        
        
        $html .= "</body>";
        $html .= "</html>";

        return $html;

    }

    function CreateBody($webBuilder)
    {
        $html = $webBuilder->CreateNavBar();

        if (isset($_COOKIE["login"]))
        {
            $sqliConnection = $webBuilder->sql->OpenSqli();

            $jquery = $sqliConnection->prepare("SELECT * FROM shopinglist WHERE User_Id = ?");
            $jquery->bind_param("s", $_COOKIE["userId"]);
            $jquery->execute();
            $shopList = $jquery->get_result();

            if ($shopList->num_rows > 0)
            {
                $totalPrice = 0;
                $totalAmount = 0;

                $html .= "<div id = folder>";
                
                for ($i = 0 ; $i < $shopList->num_rows; $i++)
                {
                    $shopList->data_seek($i);
                    $shopListArray = $shopList->fetch_array(MYSQLI_ASSOC);

                    $productResult = $sqliConnection->query("SELECT * FROM " . $shopListArray["Type"] ." WHERE Product_Id" . " = " . $shopListArray["Product_Id"] );
                    $productResult = $productResult->fetch_array(MYSQLI_ASSOC);

                    $html .= $webBuilder->CreateShopView($productResult, $shopListArray);
                    $totalAmount +=$shopListArray["Amount"];
                    $totalPrice += $productResult["Price"] * $shopListArray["Amount"];
                }
                $html .= "</div>";

                $html.="<div class=line></div>";
                //Make Order button
                $html .= "";
                $html .= "<p> Total Items: $totalAmount <br> Total Price: $totalPrice $ <br> </p>";
                $html .= "<div class=line></div>";
                $html .= "<form method='post' action ='MakeOrder.php'>";
                $html .= "<button id=MakeOrder type=\"submit\">Make Order</button>";
                $html .= "</form>";
            }
            else
            {
                $html.= "<p> The Shopping List is empty. Go to <a href=index.php> index </a> and add some items</p>";
            }

            $webBuilder->sql->CloseConnection();
        }
        else
        {
            $html.= "<p>You are not logged. Please click <a href=LogIn.php> here </a> to sign in</p>";
        }

        return $html;
    }
?>