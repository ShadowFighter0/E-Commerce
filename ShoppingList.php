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
        $html .= $webBuilder->WriteHeaderLinksForIndex();
        
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
                $shopList = $shopList->fetch_array(MYSQLI_ASSOC);

                //Display
                var_dump($shopList);
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