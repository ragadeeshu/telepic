<?php
require("clientCommon.php");
$query = " 
    SELECT 
    ID
    FROM pictures 
    ORDER BY date DESC 
    ";          
$query = " 
    SELECT 
    owner, description, path, date
    FROM pictures 
    WHERE 
    id = :id 
    "; 
$query_params = array( 
    ':id' => $_POST['id']
); 

try { 
    $stmt = $db->prepare($query); 
    $result = $stmt->execute($query_params); 
} 
catch(PDOException $ex) { 
    die("Failed to run query."); 
}
$row = $stmt->fetch();
printf( $row['path']);
printf( "\n");
printf( $row['owner']);
printf( "\n");
printf( $row['description']);
printf( "\n");
printf( $row['date']);
printf( "\n");

