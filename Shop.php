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

        if(isset($_GET["show"]))
        {
            $is = $_GET["show"];
            
            if ($is == "Films")
            {
                $html .= "<p> Films </p>";
            }
            else
            {
                $html .= "<p> TvShows </p>";
            }

            $html .= "<div class = line></div>";

            if ($is == "Films")
            {
                $query = "SELECT * FROM film";
            }
            else
            {
                $query = "SELECT * FROM tvshow";
            }

            $sqliConnection = $webBuilder->sql->OpenSqli();

            $result = $sqliConnection->query($query);
            $webBuilder->sql->CloseConnection();

            $html .= "<div class = folder>";

            for($i = 0; $i < $result->num_rows; $i++)
            {
                $result->data_seek($i);
                $row = $result->fetch_array(MYSQLI_ASSOC);

                if ($is == "Films")
                {
                    $html .= $webBuilder->CreateViewFilm($row);
                }
                else
                {
                    $html .= $webBuilder->CreateViewTvShow($row);
                }
            }

            $html .= "</div>";
        }

        return $html;
    }


?>