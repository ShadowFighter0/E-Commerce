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

            if (isset($_COOKIE["login"]))
            {

                echo $_COOKIE["login"];
                if ($_COOKIE["login"] == 1)
                {
                    $this->CreateSignedNavBar();
                }
                else
                {
                    $this->CreateNotSignedNavBar();
                }
            }
            else
            {
                $this->CreateNotSignedNavBar();
            }

            $this->html .= "</ul>";
            $this->html .= "</div>";
            

            return $this->html;
        }

        function CreateSignedNavBar()
        {
            $this->html .= "<a class = Right href = \"MyAccount.php\" > My Account </a>";
            $this->html .= "<a class = Right href = \"ShoppingList.php\"> Shopping List </a>";
        }
        
        function CreateNotSignedNavBar()
        {
            $this->html .= "<a class = Right href = \"LogIn.php\">Log In</a>";
            $this->html .= "<a class = Right href = \"SignUp.php\">Sign Up</a>";
        }

        function CreateSearchBar()
        {
            $searchbar  = "<div id=\"search-container\">";
            $searchbar .= "<form method='post' action ='Shop.php'>";
            $searchbar .= "<input type = 'text' name='search' placeholder = \"Search...\">";
            $searchbar .= "<button type=\"submit\">Submit</button>";
            $searchbar .= "</form>";
            $searchbar .= "</div>";
            return $searchbar;
        }
    }
?>