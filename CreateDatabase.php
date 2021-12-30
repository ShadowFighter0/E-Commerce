<?php

    require_once "WebBuilders" . DIRECTORY_SEPARATOR . "mysqli.php";

    //Define URL for databases
    define("MOVIES_DB_URL", "https://api.themoviedb.org/3/movie/popular?api_key=e4969e3fb066dfee11facfc052865079");
    define("SHOWS_DB_URL", "https://api.themoviedb.org/3/tv/popular?api_key=e4969e3fb066dfee11facfc052865079");
    define("MOVIES_GENRE_DB_URL","https://api.themoviedb.org/3/genre/movie/list?api_key=e4969e3fb066dfee11facfc052865079");
    define("SHOWS_GENRE_DB_URL","https://api.themoviedb.org/3/genre/tv/list?api_key=e4969e3fb066dfee11facfc052865079");

    echo "<p> Creating DataBase </p>";
    
    CreateProducts();    
    
    function CreateProducts()
    {
        //Create mysqli object
        $mysqli = new SQL();

        //Open SQL
        $sql = $mysqli->OpenSqli();

        //Delete all existing products
        $sql->query("DELETE FROM film");
        $sql->query("DELETE FROM filmgenre");
        $sql->query("DELETE FROM tvshow");
        $sql->query("DELETE FROM tvshowgenre");

        InsertFilms($sql);
        InsertTvShows($sql);

        $mysqli->CloseConnection();
    }

    function InsertFilms($sql)
    {
        //Get first page movies JSON
        $content = file_get_contents(MOVIES_DB_URL);
        $jsonMovies = json_decode($content, true);
        
        //Get the results of the JSON
        $jsonMovies = $jsonMovies["results"];
        
        //For each movie
        for($i = 0; $i < count($jsonMovies); $i++)
        {
            //Get the id
            $id = $jsonMovies[$i]["id"];
            
            //Ask for the detailed version of the film
            $content = file_get_contents("https://api.themoviedb.org/3/movie/$id?api_key=e4969e3fb066dfee11facfc052865079");
            $jsonMovie = json_decode($content, true);

            //Insert the detailed film to the database
            InsertFilmToTable($jsonMovie, $sql);
        }
    }

    function InsertFilmToTable($filmInfo, $sql)
    {        
        //Get the number of rows in film
        $filmId = mysqli_num_rows($sql->query("SELECT * FROM film"));

        //We want to include the selected film in:

        //Film
        $filmTitle = mysqli_real_escape_string($sql,$filmInfo["title"]);
        $filmOverview = mysqli_real_escape_string($sql,$filmInfo["overview"]);

        $amount = rand(1,100);
        $price = rand(7, 30);

        $query = "INSERT INTO film (Product_Id, Title, overview, Release_Date, Budget, Revenue, Duration, Score, Vote_Count, Price , Amount, IMG_Background, IMG_Poster)
                Values ($filmId , '". $filmTitle . "' , '". $filmOverview . "' , '" . $filmInfo["release_date"] . "' , '" . 
                $filmInfo["budget"] . "' , '" . $filmInfo["revenue"] . "' , '" . $filmInfo["runtime"] . "' , '" . $filmInfo["vote_average"] . "' , '" .
                $filmInfo["vote_count"] . "' , '$price' , '$amount' , '" . $filmInfo["backdrop_path"] . "' , '" . $filmInfo["poster_path"] . "');";

        $sql->query($query);

        //And in Genre (one per Genre)
        
        $genres = $filmInfo["genres"];
        foreach($genres as $key => $value)
        {
            $query = "INSERT INTO filmgenre (Product_Id, genre)
            VALUES ($filmId, '" . $value["name"] . "');";
            
            $sql->query($query);
        }
    }

    function InsertTvShows($sql)
    {
        //Get first page movies JSON
        $content = file_get_contents(SHOWS_DB_URL);
        $jsonTvShows = json_decode($content, true);
        
        //Get the results of the JSON
        $jsonTvShows = $jsonTvShows["results"];
        
        //For each movie
        for($i = 0; $i < count($jsonTvShows); $i++)
        {
            //Get the id
            $id = $jsonTvShows[$i]["id"];
            //Ask for the detailed version of the film
            $content = file_get_contents("https://api.themoviedb.org/3/tv/$id?api_key=e4969e3fb066dfee11facfc052865079");
            $jsonTvShow = json_decode($content, true);

            //Insert the detailed show to the database
            InsertTvShowToTable($jsonTvShow, $sql);
        }
    }

    function InsertTvShowToTable($tvShowInfo, $sql)
    {        
        //Get the number of rows in film
        $tvShowId = mysqli_num_rows($sql->query("SELECT * FROM tvshow"));

        //We want to include the selected show in:

        //show
        $tvShowTitle = mysqli_real_escape_string($sql,$tvShowInfo["name"]);
        $tvShowOverview = mysqli_real_escape_string($sql,$tvShowInfo["overview"]);

        $amount = rand(1,100);
        $price = rand(7, 30);

        $query = "INSERT INTO tvshow(Product_Id, Title, overview, first_air_date, last_air_date, number_of_episodes, number_of_seasons, score, Vote_Count, Price, Amount, IMG_Background, IMG_Poster)
                Values ($tvShowId , '". $tvShowTitle . "' , '". $tvShowOverview . "' , '" . $tvShowInfo["first_air_date"] . "' , '" . 
                $tvShowInfo["last_air_date"] . "' , '" . $tvShowInfo["number_of_episodes"] . "' , '" . $tvShowInfo["number_of_seasons"] . "' , '" . $tvShowInfo["vote_average"] . "' , '" .
                $tvShowInfo["vote_count"] . "' , $price, $amount,  '" . $tvShowInfo["backdrop_path"] . "' , '" . $tvShowInfo["poster_path"] . "');";

        $sql->query($query);

        //And in Genre (one per Genre)
        
        $genres = $tvShowInfo["genres"];
        foreach($genres as $key => $value)
        {
            $query = "INSERT INTO tvshowgenre (Product_Id, genre)
            VALUES ($tvShowId, '" . $value["name"] . "');";
            
            $sql->query($query);
        }
    }


?>