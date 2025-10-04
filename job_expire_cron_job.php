<?php
require_once 'main-class.php';
$user_home = new USER();

    $current_date = "'". date('Y-m-d'). "'";
    
    $stmt = $user_home->runQuery("SELECT id,end_date FROM jobs WHERE  `end_date` < $current_date AND `status`= 1 "); 

    $stmt->execute();
    $jobtRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if(!empty($jobtRow)){
        foreach($jobtRow as $row){
            $job_id = $row['id'];
            $stmt = $user_home->runQuery("UPDATE jobs SET `status`= 0  WHERE `id` = $job_id "); 
		    		    
			$stmt->execute();
             
        }
        echo "done";
    }else{
        echo "record not found"; 
    }
        
