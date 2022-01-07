<?php
    
    setcookie("login", time());
    if(isset($_COOKIE["isAdmin"]))
    {
        setcookie("isAdmin", time());
    }
    
    setcookie("userId", time());

    header("Location: index.php");
?>