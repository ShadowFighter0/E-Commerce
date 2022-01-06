<?php

    define("USER_LOCAL", "admin");
    define("PASSWORD_LOCAL", "admin");
    define("HOST_LOCAL", "localhost");
    define("DATABASE_LOCAL", "e-commerce");

    define("USER_SERVER", "id17631416_ecommerceuser");
    define("PASSWORD_SERVER", "t7>EgA>blo\m(Niv");
    define("HOST_SERVER", "localhost");
    define("DATABASE_SERVER", "id17631416_ecommerce");

    class SQL{

        private $mysqli;

        public function OpenSqli()
        {
            $this->mysqli = new mysqli(
                HOST_SERVER,
                USER_SERVER,
                PASSWORD_SERVER,
                DATABASE_SERVER);

            return $this->mysqli;
        }

        public function CloseConnection()
        {
            $this->mysqli->close();
        }
    }
?>