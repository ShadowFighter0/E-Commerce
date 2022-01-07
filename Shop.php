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

        if(isset($_POST["search"]))
        {
            $html .= CreateSearchPage($webBuilder);
        }
        else
        {
            $html .= CreateNormalShowPage($webBuilder);
        }

        return $html;
    }

    function CreateSearchPage($webBuilder)
    {
        $html = "";
        $html .= "<p> Films </p>";
        $html .= "<div class = line></div>";

        $sqliConnection = $webBuilder->sql->OpenSqli();

        $search = $_POST["search"];

        $search = mysqli_real_escape_string($sqliConnection, $search);

        $results = $sqliConnection->query("SELECT * FROM film WHERE title Like '%$search%'");

        if ($results->num_rows > 0)
        {
            $html .= "<div class = folder>";
            for($i = 0; $i < $results->num_rows; $i++)
            {
                $results->data_seek($i);
                $row = $results->fetch_array(MYSQLI_ASSOC);

                $html .= $webBuilder->CreateViewFilm($row);
            }
            $html .= "</div>";
        }

        $html .= "<div class = separator></div>";
        $html .= "<p> Tv Show </p>";
        $html .= "<div class = line></div>";

        $search = mysqli_real_escape_string($sqliConnection, $search);

        $results = $sqliConnection->query("SELECT * FROM tvshow WHERE title LIKE '%$search%'");

        if ($results->num_rows > 0)
        {
            $html .= "<div class = folder>";
            for($i = 0; $i < $results->num_rows; $i++)
            {
                $results->data_seek($i);
                $row = $results->fetch_array(MYSQLI_ASSOC);

                $html .= $webBuilder->CreateViewTvShow($row);
            }
            $html .= "</div>";
        }

        $webBuilder->sql->CloseConnection();

        return $html;
    }

    function CreateNormalShowPage($webBuilder)
    {
        $html="<div id = Filters>";

        //Price

        $html .= "<div id=\"Search\">";
            $html .= "<p> Minimun Price </p>";

            $html .= "<form method='post' action ='Shop.php?show=".$_GET["show"] . "'>";
            $html .= "<input type = 'text' name='minPrice' placeholder = \"Min Price...\">";
            $html .= "<button type=\"submit\">Submit</button>";
            $html .= "</form>";

            $html .= "<div class = separator></div>";
            $html .= "<div class = line></div>";

            $html .= "<p> Maximum Price </p>";
            $html .= "<form method='post' action ='Shop.php?show=".$_GET["show"] . "'>";
            $html .= "<input type = 'text' name='maxPrice' placeholder = \"Max Price...\">";
            $html .= "<button type=\"submit\">Submit</button>";
            $html .= "</form>";
        $html .= "</div>";
        
        $html .= "<div class = separator></div>";
        $html .= "<div class = line></div>";

        //Score
        $html .= "<div id=\"Score\">";
        $html .= "<p> Minimun Score </p>";
            $html .= "<form method='post' action ='Shop.php?show=".$_GET["show"] . "'>";
            $html .= "<input type = 'text' name='score' placeholder = \"Min Score...\">";
            $html .= "<button type=\"submit\">Submit</button>";
            $html .= "</form>";
        $html .= "</div>";

        $html .= "<div class = separator></div>";
        $html .= "<div class = line></div>";
        //Duration
       
        $html .= "<div id=\"Duration\">";
            $html .= "<p> Minimun Duration </p>";
            $html .= "<form method='post' action ='Shop.php?show=".$_GET["show"] . "'>";
            $html .= "<input type = 'text' name='duration' placeholder = \"Min duration...\">";
            $html .= "<button type=\"submit\">Submit</button>";
            $html .= "</form>";
        $html .= "</div>";


        $html.="</div>";

        $html .= "<div id=Content>";

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

            $addedWhere = false;

            //APPLY FILTERS
            if (isset($_POST["minPrice"]))
            {
                if(!$addedWhere)
                {
                    $query .= " Where ";
                    $addedWhere = true;
                }

                $query .= "Price > " . $_POST["minPrice"];
            }
            if(isset($_POST["maxPrice"]))
            {
                if(!$addedWhere)
                {
                    $query .= " Where ";
                    $addedWhere = true;
                }
                else
                {
                    $query .= " and ";
                }
                
                $query .= "Price < " . $_POST["maxPrice"];
            }
            if(isset($_POST["score"]))
            {
                if(!$addedWhere)
                {
                    $query .= " Where ";
                    $addedWhere = true;
                }
                else
                {
                    $query .= " and ";
                }
                
                $query .= "score > " . $_POST["score"];
            }
            if(isset($_POST["duration"]))
            {
                if(!$addedWhere)
                {
                    $query .= " Where ";
                    $addedWhere = true;
                }
                else
                {
                    $query .= " and ";
                }
                
                $query .= "duration > " . $_POST["duration"];
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

        $html .= "</div>";

        return $html;
    }
?>