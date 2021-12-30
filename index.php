<?php
    
    require_once "WebBuilders/WebBuilder.php";
    
    echo IndexPage();

    function IndexPage()
    {
        $html = "";
        //Create WebBuilder
        $webBuilder = new WebBuilder();

        //Start HTML
        $html .= "<html>";
        $html .= "<head>";

        //Write Head
        $html .= $webBuilder->WriteHeaderLinks();
        
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
        $query = "SELECT * FROM film WHERE Film_id < 5";
        $result = $sqlConnection->query($query);

        $webBuilder->sql->CloseConnection();

        $html .= "<div class = folder>";
        for($i = 0; $i < $result->num_rows; $i++)
        {
            $result->data_seek($i);
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $html .= $webBuilder->CreateViewFilm($row, "Film");
        }
        $html .= "</div>";



        //TVSHOWS
        $html .= "<p> TvShows </p>";
        $html .= "<div class = line></div>";

        $sqlConnection = $webBuilder->sql->OpenSqli();
        $query = "SELECT * FROM tvshow WHERE Show_id < 5";
        $result = $sqlConnection->query($query);
        $webBuilder->sql->CloseConnection();

        $html .= "<div class = folder>";

        for($i = 0; $i < $result->num_rows; $i++)
        {
            $result->data_seek($i);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $html .= $webBuilder->CreateViewTvShow($row, "TvShow");
        }

        $html .= "</div>";

        return $html;
    }

    function CreateInitialText()
    {
        $html = "<div id = InitialText>";
        $html .= "<p>Welcome!</p>";
        $html .= "<p>In this page you will find Films and TV Shows to buy</p>";
        $html .= "<p>You can also search for a specific Film or Tv Show.</p>";
        $html .= "</div>";

        return $html;
    }

?>