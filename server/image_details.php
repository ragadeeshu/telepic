<?php 
    require("common.php"); 
    if(empty($_SESSION['user'])) { 
    
        header("Location: index.php"); 
        die("Log in first!!");
    } 
?> 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Telepic - Remote Picture Tool</title>
<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">

img {width:800px}
body{margin:8px;     height: 100%;}
#background {

}#controls {

}

</style>
</head>
<?php
if(isset($_GET['file'])){
?>
<div style="position: relative;height:100%;width:100%;">
<div id="background" >
<img src="<?php echo "image.php?file=".$_GET['file']."&w=800";?>">

</div>
<div id="controls">
<form action="edit_file.php" method="post"
enctype="application/x-www-form-urlencoded">
<textarea name="description" rows="4" maxlength="120" id="description" placeholder="Den här bilden saknar beskrivning."><?php
$query = " 
            SELECT 
                owner, description, id
            FROM pictures 
            WHERE 
                path = :path 
        "; 
		$query_params = array( 
            ':path' => $_GET['file']
        ); 
         
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } catch(PDOException $ex) { 
            die("Failed to run query: " . $ex->getMessage()); 
        }
		$row = $stmt->fetch();
		if($row){ 
			if($row['owner']!=$_SESSION['user']['username']){
				//header("Location: telepic.php"); 
            	die("Permission denied");
			}
		}else{
			//header("Location: telepic.php"); 
        	die("Permission denied");
		}
		echo $row['description']
		?>
</textarea>
<input type="hidden"name="id"value="<?php echo $row['id']?>">
<input type="hidden"name="path"value="<?php echo $_GET['file']?>">

						<input type="submit" name="delete" value="Delete" style="float:left;">
						<input type="submit" name="edit" value="Edit" style="float:right;">
					</form>
</div>
</div>
<?php
}
?>
