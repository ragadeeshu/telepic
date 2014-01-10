<?php 
require("common.php"); 
if(empty($_SESSION['user'])) { 
    header("Location: index.php"); 
    die("Log in first!! //Ragnar ");
} 
if($_POST['delete']){
    $query = " 
        DELETE FROM pictures WHERE
        ID=:id             
        "; 
        $query_params = array(           
                ':id' => $_POST['id']
                ); 
    try { 
        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } catch(PDOException $ex) { 
        die("Failed to run query."); 
    }
    unlink($_POST['path']);
}else if($_POST['edit']){
    $query = " 
        UPDATE pictures SET 
        description = :description
        WHERE
        ID=:id             
        "; 
        $query_params = array(           
                ':description' => $_POST['description'], 
                ':id' => $_POST['id']
                ); 
    try { 

        $stmt = $db->prepare($query); 
        $result = $stmt->execute($query_params); 
    } catch(PDOException $ex) { 
        die("Failed to run query. " ); 
    } 
}echo '<script>parent.window.location.reload(true);</script>';
