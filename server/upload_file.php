<?php 
    require("common.php"); 
    if(empty($_SESSION['user'])) { 
        header("Location: index.php"); 
        die("Log in first!! //Ragnar ");
    } 
     
$allowedExts = array("gif", "jpeg", "jpg", "png","GIF", "JPEG", "JPG", "PNG");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 20000000)
&& in_array($extension, $allowedExts)) {
  if ($_FILES["file"]["error"] > 0) { 
      echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    } else {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
	$path = "../telepicUpload/".$_SESSION['user']['username'];
    if (file_exists($path ."/". $_FILES["file"]["name"])) {
      echo $_FILES["file"]["name"] . " already exists. ";
      } else if (strlen($_POST['description'])>120) {
		echo "Description to long.";
	} else {	  
	  if (!file_exists($path)) {
		mkdir($path, 0777, true);
      }
	  $path = $path ."/". $_FILES["file"]["name"];
      move_uploaded_file($_FILES["file"]["tmp_name"],
      $path);
      echo "Stored as: "  . $_FILES["file"]["name"];
	  $query = " 
            INSERT INTO pictures ( 
                path, 
                description, 
                owner,
				date
            ) VALUES ( 
                :path, 
                :description, 
                :owner,
				:date
            ) 
		"; 
		$query_params = array( 
            ':owner' => $_SESSION['user']['username'], 
            ':description' => $_POST['description'], 
            ':path' => $path ,
			':date' => time()
        ); 
		 try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } catch(PDOException $ex) { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
		header("Location: telepic.php"); 
        die("Redirecting to telepic.php"); 
	  
      }
    }
  } else {
  echo "Invalid file";
  }
  echo "<br><br><a href =\"telepic.php\">Try again</a>";
