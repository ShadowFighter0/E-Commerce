<?php

    require_once "mysqli.php";
    require_once "NavBar.php";

    define ("NAVBAR_STYLE_PATH", "CSS". DIRECTORY_SEPARATOR . "NavBar.css");    
    define ("INDEX_STYLE_PATH", "CSS". DIRECTORY_SEPARATOR . "Index.css");   
    define ("MOVIE_STYLE_PATH", "CSS" . DIRECTORY_SEPARATOR . "Movie.css");
    define ("VIEWFILM_STYLE_PATH", "CSS" . DIRECTORY_SEPARATOR . "View.css"); 
    define ("SHOPINGLIST_STYLE_PATH", "CSS" . DIRECTORY_SEPARATOR . "ShoppingList.css");
    define ("ACCOUNT_STYLE_PATH", "CSS" . DIRECTORY_SEPARATOR . "MyAccount.css");

    define ("IMG_BASEPATH", "https://image.tmdb.org/t/p/w500/");

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

    function WriteHeaderLinksForView()
    {
        $html = "<link rel=\"stylesheet\" href=" . VIEWFILM_STYLE_PATH . ">";        
        $html .= "<link rel=\"stylesheet\" href=" . NAVBAR_STYLE_PATH . ">";

        return $html;
    }

    function WriteHeaderLinksForShoppingList()
    {
        $html = "<link rel=\"stylesheet\" href=" . SHOPINGLIST_STYLE_PATH . ">";        
        $html .= "<link rel=\"stylesheet\" href=" . NAVBAR_STYLE_PATH . ">";

        return $html;
    }

    function WriteHeaderLinksForAccount()
    {
        $html = "<link rel=\"stylesheet\" href=" . ACCOUNT_STYLE_PATH . ">";        
        $html.= "<link rel=\"stylesheet\" href=" . NAVBAR_STYLE_PATH . ">";

        return $html;
    }

    function CreateNavBar()
    {
        $this->AddTimeToSession();
        return $this->navBar->CreateNavBar();
    }

    function AddTimeToSession()
    {
        if (isset($_COOKIE["login"]) and $_COOKIE["login"] == 1 and isset($_COOKIE["email"]) and $_COOKIE["email"] != "")
        {
            $userID = $_COOKIE["userId"];
            
            setcookie("login", "1", time() + 30 * 60);
            setcookie("userId", $userID, time() + 30 * 60);

            if(isset($_COOKIE["isAdmin"]))
            {
                setcookie("isAdmin", "1", time() + 30 * 60);       
            }
        }
    }

    function CreateViewFilm($movieInfo)
    {
        $html = "<div class= movie> <a href= \"View.php?show=film&id=" . $movieInfo["Product_Id"] ."\">";
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
        $html = "<div class= movie> <a href= \"View.php?show=tvshow&id=" . $showInfo["Product_Id"] ."\">";
            $html .= "<img src = \"" . IMG_BASEPATH . $showInfo["IMG_Poster"] . "\">";
            $html .= "<div class = movie-info>";
                $html .= "<h3>". $showInfo["Title"] . "</h3>";
                $html .= "<p>" . $showInfo["Score"] . "</p>";
            $html .= "</div>";
        $html .= "</a></div>";
        
        return $html;
    }

    function CreateShopView($productResult, $shopList)
    {
        $html = "<div class= shopMovie><a href=View.php?show=" . $shopList["Type"] . "&id=" . $productResult["Product_Id"] .">";

        $html .= "<img src = \"" . IMG_BASEPATH . $productResult["IMG_Background"] . "\">";

        $html .= "<div class = movie-info>";
            $html .= "<h3 id=Title>". $productResult["Title"] . "</h3>";
            $html .= "<p id =Price> Price per item: " . $productResult["Price"] . "$</p>";
            $html .= "<p id =Amount> Amount: ". $shopList["Amount"] . "</h3>";
        $html .= "</a></div>";
        $html .= "<div class = shop-links>";
            $html .= "<a id = Left  href= DeleteFromShopingCart.php?shopId=" . $shopList["ShopingItem_Id"] ."&amount=1>Remove One</a>";
            $html .= "<a id = Right href= DeleteFromShopingCart.php?shopId=" . $shopList["ShopingItem_Id"] ."&amount=" . $shopList["Amount"] .">Remove All</a>";
        $html .= "</div>";
        
        $html .= "</div>";
    
        return $html;
    }

    function GetImgBasePath()
    {
        return IMG_BASEPATH;
    }

    function HashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    function DeHashPassword($passwordIntroducedByuser, $passwordHashedFromDb)
    {
        return password_verify($passwordIntroducedByuser, $passwordHashedFromDb);
    }
}
?>