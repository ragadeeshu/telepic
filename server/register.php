<?php 

    
       require("common.php"); 
     
    
    if(empty($_SESSION['user'])) { 
        
        header("Location: index.php"); 
         
        
        die("Log in first!");
    } 
	if($_SESSION['user']['username']!="admin"){
		header("Location: telepic.php");
		die("Only admin have access");
	}
   
    if(!empty($_POST)) { 
        
        if(empty($_POST['username'])) { 
           
            die("Please enter a username."); 
        } 
        
        if(empty($_POST['password'])) {
            die("Please enter a password."); 
        } 
         
       
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                username = :username 
        "; 
         
      
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try { 
            
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } catch(PDOException $ex) { 
            
            die("Failed to run query."); 
        } 
         
        $row = $stmt->fetch(); 
        
        if($row) { 
            die("This username is already in use"); 
        } 
       
        $query = " 
            INSERT INTO users ( 
                username, 
                password, 
                salt
            ) VALUES ( 
                :username, 
                :password, 
                :salt
            ) 
        "; 
         
        function createSalt(){
         	$string = md5(uniqid(rand(), true));
    		return substr($string, 0, 3);
		}
		$salt = createSalt();
        
        $password = hash('sha256', $_POST['password'] . $salt); 
         
       
        for($round = 0; $round < 65533; $round++) { 
            $password = hash('sha256', $password . $salt); 
        } 
         
      
        $query_params = array( 
            ':username' => $_POST['username'], 
            ':password' => $password, 
            ':salt' => $salt, 
        ); 
         
        try { 
           
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } catch(PDOException $ex) { 
           
            die("Failed to run query."); 
        } 
         
        header("Location: telepic.php"); 
        
        die("Redirecting to telepic.php"); 
    } 
     
?>

<h1>Register</h1>
<form action="register.php" method="post">
	Username:<br />
	<input type="text" name="username" value="" />
	<br />

	<br />
	Password:<br />
	<input type="password" name="password" value="" />
	<br />
	<br />
	<input type="submit" value="Register" />
</form>
