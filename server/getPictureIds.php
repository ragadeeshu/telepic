<?php
require("clientCommon.php");
$query = " 
            SELECT 
                ID
            FROM pictures 
			ORDER BY date DESC 
        ";          
        try { 
            
            $stmt = $db->prepare($query); 
            $result = $stmt->execute(); 
        } catch(PDOException $ex) { 
            die("Failed to run query. " ); 
        }
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $curimg){

                echo $curimg['ID'];
				echo "\n";
            
        } 

