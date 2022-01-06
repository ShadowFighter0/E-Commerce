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

            $jquery = $sqliConnection->prepare("SELECT * FROM users WHERE email = ?");
            $jquery->bind_param("s", $_COOKIE["email"]);
            $jquery->execute();
            $userResult = $jquery->get_result();

            $userResult = $userResult->fetch_array(MYSQLI_ASSOC);

            $jquery = $sqliConnection->prepare("SELECT * FROM shopinglist WHERE User_Id = ?");
            $jquery->bind_param("s", $userResult["User_Id"]);
            $jquery->execute();
            $shopList = $jquery->get_result();

            if ($shopList->num_rows > 0)
            {
                $html .= "<div id = folder>";
                
                for ($i = 0 ; $i < $shopList->num_rows; $i++)
                {
                    $shopList->data_seek($i);
                    $shopListArray = $shopList->fetch_array(MYSQLI_ASSOC);

                    $productResult = $sqliConnection->query("SELECT * FROM " . $shopListArray["Type"] ." WHERE Product_Id" . " = " . $shopListArray["Product_Id"] );
                    $productResult = $productResult->fetch_array(MYSQLI_ASSOC);

                    $html .= $webBuilder->CreateShopView($productResult, $shopListArray);
                }
                $html .= "</div>";
            }
            else
            {
                $html.= "<p> The Shopping List is empty. Go to <a href=index.php> index </a> and add some items</p>";
            }

            $webBuilder->sql->CloseConnection();
        }

        return $html;
    }
?>