<?php 

require_once 'main-class.php';
$user_home = new USER();

$id = $_POST['id'];
$del = $_POST['status'];

    $stmt = $user_home->runQuery("
    UPDATE scripts 
        SET 
        `del` = $del
    WHERE 
        `id` = $id
    ");

    if($stmt->execute()){
        echo "1";
    }else{
        echo "0";
    }
    
?>