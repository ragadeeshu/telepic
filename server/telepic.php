<?php 

    require("common.php"); 
    if(empty($_SESSION['user'])){ 
        header("Location: index.php"); 
        die("Log in first.");
    } 
?>

<!doctype html>
<html>
<head>

<meta charset="utf-8">

<title>Telepic - Remote Picture Tool</title>
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<script type="text/javascript">
		if (top.location!= self.location) {
			top.location = self.location.href
		}
</script>

#uploaderform {
	width: 20em;
}
#pictureinfo {
	width:822px;
	height:822px;
	
}
#picturegallery {
	height: auto;
	overflow:auto;
	white-space:nowrap;
}
#pictureinfowrappper {
	
	padding-left: 10px;
	padding-right: 4px;
	overflow: auto;
	padding-bottom: 10px;
}
#leftinfowrapper {
	padding-left: 4px;
	float: left;
}
#uploaderformwrapper {
	padding-top: 10px;
	padding-bottom: 10px;
}
#picturegallerywrapper {
	clear:both;
	padding-top: 8px;
	padding-right: 4px;
	padding-bottom: 4px;
	padding-left: 4px;
	margin:2px;
	
} #infoFrame{
	
	width:822px;
	height:821px;
	

}

</style>
</head>

<body>
<div id="wrap">
	<div id="header">
		<header><img id ="headerImage" src="images/Telepic.png" width="800" height="200"  alt="Welcome to Telepic"/></header>
	</div>
	<div id="main">
		<div id="leftinfowrapper">
			<div id="uploaderform" class="box">
				<p>Welcome <?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>.</p>
				<a href="logout.php">Logout</a>
				<?php
				if($_SESSION['user']['username']=="admin"){
					echo "<br><a href=\"register.php\">Register</a>";
				}
				?>
			</div>
			<div id="uploaderformwrapper">
				<div id="uploaderform" class="box">
					<form action="upload_file.php" method="post"
enctype="multipart/form-data">
						Upload file:<br>
						<input name="file" type="file" required id="file">
						<br>
						<textarea name="description" rows="8" maxlength="120" required id="description" placeholder="Short description of picture. 120 characters max."></textarea>
						<br>
						<input type="submit" name="submit" value="Submit">
					</form>
				</div>
			</div>
		</div>
		<div id="pictureinfowrappper">
			<div id="pictureinfo" class="box">
			<iframe id="infoFrame" name="infoFrame" frameBorder="0" scrolling="no" seamless='seamless' src="image_details.php">
  <p>Your browser does not support iframes.</p>
</iframe></div>

		</div>
		<div id="picturegallerywrapper"class="box">
			<div id="picturegallery" >
				<ul>
                <?php

                //Get user submitted pictures
                $query = " 
                SELECT 
                path
                FROM pictures 
                WHERE 
                owner = :owner
                ORDER BY date DESC 
                "; 
                $query_params = array( 
                        ':owner' => $_SESSION['user']['username'] 
                        ); 
                try{ 
                    $stmt = $db->prepare($query); 
                    $result = $stmt->execute($query_params); 
                } catch(PDOException $ex){ 
                    die("Failed to run query."); 
                }
foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $curimg){
    if(!in_array($curimg, $ignore)) {
        echo "<li style=\"list-style-type:none; margin-right:5px; margin-left:5px; display:inline;\"><a href=\"image_details.php?file=".$curimg['path']."\" target=\"infoFrame\"><img src='image.php?file=".$curimg['path']."&h=150' alt='' /></a></li>\n ";
    }
}                 
    ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<div id="footer">Your footer text here<div>
</body>
</html>
