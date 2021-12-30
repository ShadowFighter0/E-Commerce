<?php

    require_once "WebBuilders/WebBuilder.php";
        
    echo ViewPage();

    function ViewPage()
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
        $html = "";

        //CreateNavBar
        $html .= $webBuilder->CreateNavBar();

        //Get the selected thing
        if(isset($_GET["is"]) && isset($_GET["id"]))
        {
            $sqliConnection = $webBuilder->sql->OpenSqli();

            $data = GetFilmData($sqliConnection);
            $genres = GetGenreData($sqliConnection);

            $webBuilder->sql->CloseConnection(); 
            
            if($_GET["is"] == "film")
            {
               $html .= CreateFilmView($data, $genres, $webBuilder);
            }
            else
            {
               //$html .= CreateTvShowView();
            }
        }
        else
        {
            $html .= "<h2> Something went wrong. Try going to the main page </h2>";
        }
        return $html;
    }

    function CreateFilmView($data, $genres, $webBuilder)
    {
        $html = "<div id = Viewer>";
            $html .= "<div id= Left>";
                $html .= "<img src =\"" . $webBuilder->GetImgBasePath() . $data["IMG_Poster"] ."\"\>";
            $html .= "</div>";

            $html .= "<div id=Right>";
                $html .= "<h2>" . $data["Title"] . "</h2>";

                $html .= "<div class = HorizontalLine></div>";
                $html .= "<p class = BottomText>" . $data["Release_Date"] . "</p>";
                $html .= "<p class = BottomText>" . $data["Duration"] . "</p>";



                $html .= "<button> Add To Shoping List</button>";
            $html .= "</div>";

        $html .= "</div>";

        return $html;
    }

    function GetGenreData($sqliConnection)
    {
        if($_GET["is"] == "film")
        {   
            $queryGenre = "SELECT * FROM filmgenre WHERE Product_Id = " . $_GET["id"]."";
        }
        else if ($_GET["is"] == "tvshow")
        {
            $queryGenre = "SELECT * FROM tvshowgenre WHERE Product_Id = " . $_GET["id"]."";
        }

        $filmGenre = $sqliConnection->query($queryGenre);

        $filmGenres = array();

        //Get Genres rows
        for($i = 0; $i < $filmGenre->num_rows; $i++)
        {
            $filmGenre->data_seek($i);
            $rowGenre = $filmGenre->fetch_array(MYSQLI_ASSOC);
            $filmGenres[$i] = $rowGenre["genre"];
        }

        return $filmGenres;
    }

    function GetFilmData($sqliConnection)
    {
        $queryData = "SELECT * FROM " . $_GET["is"] . " WHERE Product_Id = " . $_GET["id"]."";

        $filmData = $sqliConnection->query($queryData);

        //Get filmData
        $filmData->data_seek(0);
        $rowFilmData = $filmData->fetch_array(MYSQLI_ASSOC);

        return $rowFilmData;
    }


?>