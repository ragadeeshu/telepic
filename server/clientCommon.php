<?php 

    $username = "db_username"; 
    $password = "db_pass"; 
    $host = "db_host"; 
    $dbname = "db_name"; 
	$port = "db_port";

    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
	
    try 
    { 
        $db = new PDO("mysql:host={$host};dbname={$dbname};port={$port};charset=utf8", $username, $password, $options); 
    } 
    catch(PDOException $ex) 
    { 
        
        die("Failed to connect to the database: " . $ex->getMessage()); 
    } 
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
    { 
        function undo_magic_quotes_gpc(&$array) 
        { 
            foreach($array as &$value) 
            { 
                if(is_array($value)) 
                { 
                    undo_magic_quotes_gpc($value); 
                } 
                else 
                { 
                    $value = stripslashes($value); 
                } 
            } 
        } 
     
        undo_magic_quotes_gpc($_POST); 
        undo_magic_quotes_gpc($_GET); 
        undo_magic_quotes_gpc($_COOKIE); 
    } 
    
    header('Content-Type: text/html; charset=utf-8'); 
    if(!empty($_POST)) 
    { 
        $query = " 
            SELECT 
                id, 
                username, 
                password, 
                salt
            FROM users 
            WHERE 
                username = :username 
        "; 
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try 
        { 
        
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
        $login_ok = false; 
		$login_status="";
        
        $row = $stmt->fetch(); 
        if($row &&$_POST['username']=="Client_username") 
        { 
            
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65533; $round++) 
            { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
            } 
             
            if($check_password === $row['password']) 
            { 
           
                $login_ok = true; 
            } 
        } 
        
        if(!$login_ok) 
        { 
            die("Not authorized");
            
        } 
         
    } 
     

