<?php 

require_once 'main-class.php';
$user_home = new USER();

$id = $_POST['id'];
$del = $_POST['status'];

    $stmt = $user_home->runQuery("
    UPDATE users 
        SET 
        `delete_status` = $del
    WHERE 
        `user_id` = $id
    ");

    if($stmt->execute()){
        echo "1";
    }else{
        echo "0";
    }
    
?>