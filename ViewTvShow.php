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
        $html .= $webBuilder->WriteHeaderLinksForViewTvShow();
        
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
        if(isset($_GET["id"]))
        {
            $sqliConnection = $webBuilder->sql->OpenSqli();

            $data = GetShowData($sqliConnection);
            $genres = GetGenreData($sqliConnection);

            $webBuilder->sql->CloseConnection();

            $html .= CreateFilmView($data, $genres, $webBuilder);
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
                $html .= "<div id=Title>";
                    $html .= "<h2>" . $data["Title"] . "</h2>";
                    $html .= "<h2 id=ScoreNumber>" . $data["Score"] . "</h2>";
                    $html .= "<h3 id=ScoreText> Score (".$data["vote_count"] .") </h3>";
                $html .= "</div>";

            $html .= "<div class = HorizontalLine></div>";

            $html .= "<div id=SubText>";
                $html .= "<span>First Air: " . $data["first_air_date"] . "</span>";
                $html .= "<span>Last Air: "  . $data["last_air_date"]  . "</span>";
                
                $html .= "<br><br>";

                $html .= "<span> Genres:</span>";

                foreach($genres as $key => $value)
                {
                    $html .= "<span>" . $value . "</span>";
                }
                
            $html .= "</div>";

            $html .= "<div class = HorizontalLine></div>";

            $html .= "<div id = Overview>";
                $html .= "<h2>Overview:</h2>";
                
                if (strlen($data["overview"]) > 0)
                {
                    $html .= "<p>" . $data["overview"] ."</p>";
                }
                else
                {
                    $html .= "<p> There is no overview available</p>";
                }

            $html .= "</div>";

            $html .= "<div class = HorizontalLine></div>";

            $html .= "<div id = BottonInfo>";
                $html .= "<span> Number of Episodes: " . $data["number_of_episodes"] . " <br><br></span>";
                $html .= "<span> Number of Seasons:  " .  $data["number_of_seasons"] . " </span>";
            $html .= "</div>"; 

            $html .= "<div class = HorizontalLine></div>";

            $html .= "<div id=ShopButton>";
            $html .= "<button> Add To Shoping List</button>";
            $html .= "<span id=PriceUp> Price: <br></span>";
            $html .= "<span id=PriceDown>" . $data["Price"] . "$</span>";
            $html .= "</div>";

        $html .= "</div>";

        return $html;
    }

    function GetGenreData($sqliConnection)
    {
        $queryGenre = "SELECT * FROM tvshowgenre WHERE Product_Id = " . $_GET["id"]."";
    
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

    function GetShowData($sqliConnection)
    {
        $queryData = "SELECT * FROM tvshow WHERE Product_Id = " . $_GET["id"]."";

        $filmData = $sqliConnection->query($queryData);

        //Get filmData
        $filmData->data_seek(0);
        $rowFilmData = $filmData->fetch_array(MYSQLI_ASSOC);

        return $rowFilmData;
    }


?>