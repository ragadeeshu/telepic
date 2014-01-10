<?php 

// Connect to database and start session
require("common.php"); 

//Check credentials if user is trying to log in 
$submitted_username = ''; 
if(!empty($_POST)){ 
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

    try{ 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    }catch(PDOException $ex){ 
        die("Failed to run query."); 
    } 

    $login_ok = false; 
    $login_status="";

    $row = $stmt->fetch(); 
    if($row){ 
        $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
        for($round = 0; $round < 65533; $round++){ 
            $check_password = hash('sha256', $check_password . $row['salt']); 
        } 

        if($check_password === $row['password']){ 
            $login_ok = true; 
        } 
    } 
    if($login_ok){ 
        unset($row['salt']); 
        unset($row['password']); 

        $_SESSION['user'] = $row; 

        header("Location: telepic.php"); 
        die("Welcome, redirecting to telepic"); 
    }else{ 
        $login_status="Login Failed."; 

        $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
    } 
} 

?> 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Telepic - Remote Picture Tool</title>
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">

#login {
    bottom: 0;
    height: 120px;
    left: 0;
    margin: auto;
    position: fixed;
    top: 0;
    right: 0;
    width: 180px;
    background-color: #CFF;
    border: 1px solid #ccc;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
    -moz-box-shadow: 2px 2px 3px #666;
    -webkit-box-shadow: 2px 2px 3px #666;
    box-shadow: 2px 2px 3px #666;
    font-size: 12px;
    padding: 4px 7px;
    outline: 0;
         -webkit-appearance: none;
}
#loginform {
    text-align: center;
    border-radius: 2px;
}
#loginbutton {
    margin-top: 8px;
}
</style>
<!--[if !IE 7]>
<style type="text/css">
#wrap {display:table;height:100%}
</style>
<![endif]-->
</head>

<body>
<div id="wrap">
<div id="header">
<header><img src="images/Telepic.png" width="800" height="200"  alt="Welcome to Telepic"/>
<br>
<?php print($login_status);?></header>
</div>
<div id="main">
<div id="login">
<form action="index.php" method="post" id="loginform">
Username:
<input type="text" class="rounded" name="username" value="<?php echo $submitted_username; ?>"/>
Password:
<input type="password" class="rounded" name="password" />
<input id="loginbutton" type="submit" value="Login" />
</form>
</div>
</div>
</div>
<div id="footer">Your footer text here </div>
</body>
</html>
