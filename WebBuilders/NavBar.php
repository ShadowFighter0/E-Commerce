<?php
    class NavBar
    {
        private $html = "";

        function CreateNavBar()
        {
            //Create div conainter 
            $this->html = "<div id = topnav>";

            //Open Navbar
            $this->html .= "<ul>";
            $this->html .= "<a class = Left href=\"index.php\">Home</a>";
            $this->html .= "<a class = Left href=\"Shop.php?show=Films\">Films</a>";
            $this->html .= "<a class = Left href=\"Shop.php?show=TvShows\">Tv Shows</a>";
            $this->html .= "". $this->CreateSearchBar() ."";
            $this->html .= "<a class = Right href=\"LogIn.php\">Log In</a>";
            $this->html .= "<a class = Right href=\"NewUser.php\">Sign Up</a>";
            $this->html .= "</ul>";
            $this->html .= "</div>";

            return $this->html;
        }

        function CreateSearchBar()
        {
            $searchbar = "<div id=\"search-container\">";
            $searchbar .= "<form method='post' action ='Shop.php'>";
            $searchbar .= "<input type = 'text' name='search' placeholder = \"Search...\">";
            $searchbar .= "<button type=\"submit\">Submit</button>";
            $searchbar .= "</form>";
            $searchbar .= "</div>";
            return $searchbar;
        }
    }
?>