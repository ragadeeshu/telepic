<?php 
    require("common.php"); 
        session_start(); 
$_SESSION = array();
	unset($_SESSION['user']); 
 
session_unset();
session_destroy(); 
    
    header("Location: index.php"); 
    die("Redirecting to: index.php");
