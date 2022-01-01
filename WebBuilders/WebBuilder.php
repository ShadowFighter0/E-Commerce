<?php

    require_once "WebBuilders" . DIRECTORY_SEPARATOR . "mysqli.php";
    require_once "WebBuilders" . DIRECTORY_SEPARATOR . "NavBar.php";

    define ("NAVBAR_STYLE_PATH", "CSS". DIRECTORY_SEPARATOR . "NavBar.css");    
    define ("INDEX_STYLE_PATH", "CSS". DIRECTORY_SEPARATOR . "Index.css");   
    define ("MOVIE_STYLE_PATH", "CSS" . DIRECTORY_SEPARATOR . "Movie.css");
    define ("VIEWFILM_STYLE_PATH", "CSS" . DIRECTORY_SEPARATOR . "ViewFilm.css");      
    define ("VIEWTVSHOW_STYLE_PATH", "CSS" . DIRECTORY_SEPARATOR . "ViewTvShow.css");      

    define("IMG_BASEPATH", "https://image.tmdb.org/t/p/w500/");

class WebBuilder{

    private $navBar;
    public $sql;

    function __construct()
    {
        $this->navBar = new NavBar();
        $this->sql = new SQL();
    }

    function WriteHeaderLinksForIndex()
    {
        $html  = "";
        $html .= "<link rel=\"stylesheet\" href=" . NAVBAR_STYLE_PATH . ">";
        $html .= "<link rel=\"stylesheet\" href=" . INDEX_STYLE_PATH . ">";
        $html .= "<link rel=\"stylesheet\" href=" . MOVIE_STYLE_PATH . ">";
        
        return $html;
    }

    function WriteHeaderLinksForViewFilm()
    {
        $html = "<link rel=\"stylesheet\" href=" . VIEWFILM_STYLE_PATH . ">";        
        $html .= "<link rel=\"stylesheet\" href=" . NAVBAR_STYLE_PATH . ">";

        return $html;
    }

    function WriteHeaderLinksForViewTvShow()
    {
        $html = "<link rel=\"stylesheet\" href=" . VIEWTVSHOW_STYLE_PATH . ">";        
        $html .= "<link rel=\"stylesheet\" href=" . NAVBAR_STYLE_PATH . ">";

        return $html;
    }

    function CreateNavBar()
    {
        return $this->navBar->CreateNavBar();
    }

    function CreateViewFilm($movieInfo)
    {
        $html = "<div class= movie> <a href= \"ViewFilm.php?id=" . $movieInfo["Product_Id"] ."\">";
            $html .= "<img src = \"" . IMG_BASEPATH . $movieInfo["IMG_Poster"] . "\">";
            $html .= "<div class = movie-info>";
                $html .= "<h3>". $movieInfo["Title"] . "</h3>";
                $html .= "<p>" . $movieInfo["Score"] . "</p>";
            $html .= "</div>";
        $html .= "</a></div>";
        

        return $html;
    }

    function CreateViewTvShow($showInfo)
    {
        $html = "<div class= movie> <a href= \"ViewTvShow.php?id=" . $showInfo["Product_Id"] ."\">";
            $html .= "<img src = \"" . IMG_BASEPATH . $showInfo["IMG_Poster"] . "\">";
            $html .= "<div class = movie-info>";
                $html .= "<h3>". $showInfo["Title"] . "</h3>";
                $html .= "<p>" . $showInfo["Score"] . "</p>";
            $html .= "</div>";
        $html .= "</a></div>";
        

        return $html;
    }

    function GetImgBasePath()
    {
        return IMG_BASEPATH;
    }
}


?>