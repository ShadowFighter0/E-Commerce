<?php

    require_once "WebBuilders" . DIRECTORY_SEPARATOR . "WebBuilder.php";
  
    echo CreateMyAccount();

    function CreateMyAccount()
    {
        $webBuilder = new WebBuilder();

        $html = "<html>";
        $html .= "<head>";
            $html .= $webBuilder->WriteHeaderLinksForAccount();
        $html .= "</head>";
        $html .= "<body>";
            $html .= CreateBody($webBuilder);
        $html .= "</body>";
        $html .= "</html>";
    
        return $html;
    }

    function CreateBody($webBuilder)
    {
        $html = $webBuilder->CreateNavBar();

        if(isset($_COOKIE["login"]))
        {
            $connection = $webBuilder->sql->OpenSqli();

            $userInfo = $connection->query("SELECT * From users where User_ID = " . $_COOKIE["userId"]);
            $userInfo = $userInfo->fetch_array(MYSQLI_ASSOC);

            $orderSQL = $connection->query("SELECT * From orders where User_ID = " . $_COOKIE["userId"]);           
    
            //Display user Information
            $html.= "<h2> User Information </h2>";
            $html.= "<div id=Info>";
                $html.= "<h2> Name </h2>";
                $html.= "<p>" . $userInfo["name"] . "</p>";
                $html.= "<div class = line></div>";
                
                $html.= "<h2> Email </h2>";
                $html.= "<p>" . $userInfo["email"] . "</p>";
                $html.= "<div class = line></div>";
            $html.= "</div>";

            //Display Last Orders
            $html.= "<h2> Last Orders </h2>";
            $html.= "<div id=LastOrders>";

            //If we have orders
            if($orderSQL->num_rows > 0)
            {
                for($i = 0; $i < $orderSQL->num_rows; $i++)
                {
                    $orderSQL->data_seek($i);
                    $row = $orderSQL->fetch_array(MYSQLI_ASSOC);
    
                    //Display Boxes     
                    $html.= "<div class=OrderContainer>";
                        $html.="<div id=TitleContainer>";
                            $html.= "<span id=Title>ORDER #" . $i ."</span>";
                            $html.= "<span id=Date>" . $row["Date"] . "</span>";
                        $html.="</div>";
                        $html.="<div id=DetailsContainer>";
                            $html.= "<p>" . $row["Details"] . "</p>";
                        $html.="</div>";
                        $html.="<div id=TotalPrice>";
                            $html.= "<span> Total: " . $row["TotalPrice"] . "</span>";
                        $html.="</div>";
                    $html.="</div>";
                } 
            }
            else
            {
                //Show empty message
                $html.= "<p> There are no orders to display yet. </p>";
            }
            
            $html.="</div>";
            
            //Create Options folder
            $html.="<h2>Options</h2>";

            //Each one a form and a button
            $html.= "<div id=Options>";
                $html.="<div id=Left>";
                    $html.= "<p> Log Out </p>";
                    $html.= "<form method= post action= LogOut.php>";
                    $html.= "<button> Log Out </button>";
                    $html.= "</form>";
                $html.="</div>";

                $html.="<div id=Right>";
                    $html.= "<p> Delete Account </p>";
                    $html.= "<form method= post action= DeleteUser.php?userId=".$_COOKIE["userId"].">";
                    $html.= "<button> Delete Account </button>";
                    $html.= "</form>";
                $html.="</div>";
            $html.="</div>";


            if ($userInfo["isAdmin"])
            {
                $connection = $webBuilder->sql->OpenSqli();

                $result = $connection->query("SELECT * FROM users");

                $html.= "<div id=LastOrders>";
                for($i = 0; $i < $result->num_rows; $i++)
                {
                    $result->data_seek($i);
                    $userInfo = $result->fetch_array(MYSQLI_ASSOC);
        
                    //Display Box     
                    $html.= "<h2> Users </h2>";
                    $html.= "<div class=OrderContainer>";
                        $html.="<div id=DataContainer>";
                            $html.= "<span id=Title>Name: ". $userInfo["name"] ."<br><br></span>";
                            $html.= "<span id=Date>Email: " . $userInfo["email"] . "</span><br><br>";
                        $html.="</div>";
                        $html.="<div id=AdminOptions>";
                            $html.= "<a href=DeleteUser.php?userId=" . $userInfo["User_Id"] .">Delete</a>";
                        $html.="</div>";
                    $html.="</div>";
                }
                
                $html.="</div>";
            }

            return $html;
        }
        else
        {
            echo "<p> You should not be here. Please click <a href = index.php> here </a>.";
        }
    }
?>