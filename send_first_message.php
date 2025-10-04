<?php
include 'header.php';

$f_un = $_POST['from'];
$t_un = $_POST['to'];
$msg = rtrim($_POST['msg']);


	$created = time();
	$status = '0';	
	
	$stmt = $user_home->runQuery("INSERT INTO message(timer,f_un,t_un,message) VALUES(:timer,:f_un,:t_un,:message)");
	$stmt->bindParam(':timer',$created);
	$stmt->bindParam(':f_un',$f_un);   ///usr
	$stmt->bindParam(':t_un',$t_un);   // to
	$stmt->bindParam(':message',$msg);
	$stmt->execute();
	
	$stmt = $user_home->runQuery("UPDATE users SET last_seen=:last_seen WHERE user_id=:user_id");
	$stmt->bindParam(':last_seen',$created);
	$stmt->bindParam(':user_id',$_SESSION['user_id']);
	$stmt->execute();
	$_SESSION['timer'] = $created;
	

	$status_as = 0;
	$stmt = $user_home->runQuery("UPDATE friends SET msg_to=:msg_to,msg_by=:msg_by,msg_tm=:msg_tm,msg=:msg,status_as =:status_as WHERE(f_unique=:f_un AND t_unique=:t_un) OR (f_unique=:f_una AND t_unique=:t_una)");
	$stmt->bindParam(':msg_to',$f_un);
	$stmt->bindParam(':msg_by',$t_un);
	$stmt->bindParam(':msg_tm',$created);
	$stmt->bindParam(':msg',$msg);
	$stmt->bindParam(':status_as',$status_as);
	$stmt->bindParam(':f_un',$f_un);
	$stmt->bindParam(':t_un',$t_un);
	$stmt->bindParam(':f_una',$t_un);
	$stmt->bindParam(':t_una',$f_un);
	if($stmt->execute()){
	    echo json_encode(array("data"=>'yes')); 
	}else{
	    echo json_encode(array("data"=>'no')); 
	}
    die();
    


?>