<?php 

    //Enter connection information for your MySQL database here 
    $username = "db_username"; 
    $password = "db_pass"; 
    $host = "db_pass"; 
    $dbname = "db_name"; 
    $port = "db_port";

    // Using UTF-8 
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
     
    try { 
        //Connect to database
        $db = new PDO("mysql:host={$host};dbname={$dbname};port={$port};charset=utf8", $username, $password, $options); 
    } 
    catch(PDOException $ex) { 
        // Failed to connect to database. 
        die("Failed to connect to the database."); 
    } 
        //Setting pdo options  
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
     
    // Undo magic quotes. 
    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) { 
        function undo_magic_quotes_gpc(&$array) { 
            foreach($array as &$value) { 
                if(is_array($value)) { 
                    undo_magic_quotes_gpc($value); 
                } else { 
                    $value = stripslashes($value); 
                } 
            } 
        } 
     
        undo_magic_quotes_gpc($_POST); 
        undo_magic_quotes_gpc($_GET); 
        undo_magic_quotes_gpc($_COOKIE); 
    } 
    header('Content-Type: text/html; charset=utf-8'); 
    session_start(); 
