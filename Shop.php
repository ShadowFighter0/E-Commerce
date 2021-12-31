<?php

    require_once "WebBuilders" . DIRECTORY_SEPARATOR . "WebBuilder.php";

    echo ShopPage();

    function ShopPage()
    {
        $html = "";

        //Create WebBuilder
        $webBuilder = new WebBuilder();

        //Start HTML
        $html .= "<html>";
        $html .= "<head>";

        //Write Head
        $html .= $webBuilder->WriteHeaderLinksForShop();
        
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

        $html .= CreateInitialText();

        //Start Films Section
        $html .= "<p> Films </p>";
        $html .= "<div class = line></div>";

        //Get the 5 first MOVIES
        $sqlConnection = $webBuilder->sql->OpenSqli();
        $query = "SELECT * FROM film WHERE Product_Id < " . NUM_BOXES ."";
        $result = $sqlConnection->query($query);

        $webBuilder->sql->CloseConnection();
        $html .= "<div class = folder>";
        for($i = 0; $i < $result->num_rows; $i++)
        {
            $result->data_seek($i);
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $html .= $webBuilder->CreateViewFilm($row, "film");
        }
        $html .= "</div>";

        //Separate
        
        $html .= "<div class = separator></div>";


        //TVSHOWS
        $html .= "<p> TvShows </p>";
        $html .= "<div class = line></div>";

        $sqlConnection = $webBuilder->sql->OpenSqli();
        $query = "SELECT * FROM tvshow WHERE Product_Id < " . NUM_BOXES ."";

        $result = $sqlConnection->query($query);
        $webBuilder->sql->CloseConnection();

        $html .= "<div class = folder>";

        for($i = 0; $i < $result->num_rows; $i++)
        {
            $result->data_seek($i);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $html .= $webBuilder->CreateViewFilm($row,"tvshow");
        }

        $html .= "</div>";

        return $html;
    }


?>