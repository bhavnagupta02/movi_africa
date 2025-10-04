<?php
session_start();
//error_reporting(0);

require_once 'main-class.php';
$user_home = new USER();

$activePage = basename($_SERVER['PHP_SELF'], ".php");
 

 //$Page = $_SERVER['PHP_SELF'];
 
    if($user_home->is_logged_in()){
        if(empty($_SESSION['IdSer'])){
            $user_name = $_SESSION['first_name'];
            $user_home->generate_unique_username($user_name,2000);
        }
    }
    
   /* if($user_home->is_logged_in()){
        if($_SESSION['IdSer'] == ''){
            $Pt = SITE_URL.'username';
        	header("Location: $Pt", true, 301);
        	exit();
        }
    }*/
    
    /* logo image */
    
    $stmts= $user_home->runQuery("SELECT col1 FROM admin_manage WHERE id=7");
    $stmts->execute();
    $logoRow = $stmts->fetch(PDO::FETCH_ASSOC);
    
    
    
     if($_POST['Noticecount']){
                
                $Fcount = ($_POST['Noticecount'] * 5) + 1;
                $Tcount = ($_POST['Noticecount'] + 1) * 5;

                $user_unq =$_SESSION['IdSer'];
				$stmt_noti= $user_home->runQuery("SELECT 
					 users.user_unq,users.user_name,noticefication.type,noticefication.read_by,noticefication.post_name,noticefication. 	extra,noticefication.n_tm,noticefication.post_id,users.profile_pic 
					FROM users
					LEFT JOIN noticefication ON users.user_unq = noticefication.t_id
					WHERE noticefication.f_id=:f_id  ORDER BY `noticefication`.`n_tm` DESC LIMIT $Fcount,$Tcount");
				$stmt_noti->execute(array(":f_id"=>$user_unq));
				//$userRowFrnd = $stmt_noti->fetchAll(PDO::FETCH_ASSOC);
				$user_Frnd_noti = [];
				while($userRowFrnd = $stmt_noti->fetch(PDO::FETCH_ASSOC)) {

            		

        			$userRowFrnd['date'] = date('j F, Y', $userRowFrnd['n_tm'] ); 
        			$user_Frnd_noti[] = $userRowFrnd;	
            		

            		
	            }
				
				/*echo "<pre>";
                print_r($user_Frnd_noti);
                echo "</pre>";
                die('hi');*/
				
				
                $data = json_encode($user_Frnd_noti,true);
                
                
                echo json_encode(array('data'=>$data,'cnt'=> ($_POST['Noticecount'] + 1), 'start' => $Fcount,'end' => $Tcount ));
                
                
                
                exit;
                
            }
    
    /* logo image end */

    $stmt = $user_home->runQuery("SELECT user_like FROM users WHERE user_id=:user_id");
    $stmt->execute(array(":user_id"=>$_SESSION['user_id']));
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	if($userRow['user_like'] == ''){
		$DataLk = '{}';
	}
	else{
		$DataLk = $userRow['user_like'];
	}

if($user_home->is_logged_in()){
    $user_id = $_SESSION['user_id'];
	if(isset($_POST)){
		if($_POST['type'] == 'like'){
			$stmt = $user_home->runQuery("SELECT user_like FROM users WHERE user_id=:user_id");
			$stmt->execute(array(":user_id"=>$_SESSION['user_id']));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
				if($userRow['user_like'] == ''){
					$DataLk=array();
				}
				else{
					$DataLk = json_decode($userRow['user_like'],true);
				}
			
				if(array_key_exists($_POST['Wp'],$DataLk)){
					unset($DataLk[$_POST['Wp']]);
					$stmt = $user_home->runQuery("DELETE FROM likes WHERE wall_post_id=:wall_post_id AND user_id=:user_id");
					$stmt->execute(array(":wall_post_id"=>$_POST['Wp'],":user_id"=>$_SESSION['IdSer']));
						$user_like = json_encode($DataLk,true);
						$stmt = $user_home->runQuery("UPDATE users SET user_like = :user_like WHERE user_unq=:user_unq");
						$stmt->bindParam(':user_like',$user_like);
						$stmt->bindParam(':user_unq',$_SESSION['IdSer']);
						$stmt->execute();
						
						$stmt = $user_home->runQuery("UPDATE wall_posts SET count_like = count_like-1 WHERE post_unq=:post_unq");
						$stmt->bindParam(':post_unq',$_POST['Wp']);
						$stmt->execute();
					echo 'Unlike';	
				}
				else{
					
					$stmt = $user_home->runQuery("SELECT unique_id FROM wall_posts WHERE post_unq=:post_unq");
					$stmt->execute(array(":post_unq"=>$_POST['Wp']));
					$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
					
					if($stmt->rowCount() == 1){
						$UniqueId=$userRow['unique_id'];
					}
					
					
					$DataLk[$_POST['Wp']]='1';
					$created=time();
					$stmt = $user_home->runQuery("INSERT INTO likes(wall_post_id,user_id,created) VALUES (:wall_post_id,:user_id,:created)");
					$stmt->bindParam(':wall_post_id',$_POST['Wp']);
					$stmt->bindParam(':user_id',$_SESSION['IdSer']);
					$stmt->bindParam(':created',$created);
					$stmt->execute();
					
						$user_like = json_encode($DataLk,true);
						$stmt = $user_home->runQuery("UPDATE users SET user_like = :user_like WHERE user_unq=:user_unq");
						$stmt->bindParam(':user_like',$user_like);
						$stmt->bindParam(':user_unq',$_SESSION['IdSer']);
						$stmt->execute();
	
						$stmt = $user_home->runQuery("UPDATE wall_posts SET count_like = count_like+1 WHERE post_unq=:post_unq");
						$stmt->bindParam(':post_unq',$_POST['Wp']);
						$stmt->execute();
						
						if($UniqueId != $_SESSION['IdSer']){
							$rdSts=0;$typenw='like';	
							$stmt = $user_home->runQuery("INSERT INTO noticefication(t_id,f_id,n_tm,type,read_by,post_id) VALUES (:t_id,:f_id,:n_tm,:type,:read_by,:post_id)");
							$stmt->bindParam(':t_id',$UniqueId);
							$stmt->bindParam(':f_id',$_SESSION['IdSer']);
							$stmt->bindParam(':n_tm',$created);
							$stmt->bindParam(':type',$typenw);
							$stmt->bindParam(':read_by',$rdSts);
							$stmt->bindParam(':post_id',$_POST['Wp']);
							$stmt->execute();
						}				
					echo 'Like';	
				}

				die();
		}
		if($_POST['type'] == 'cmnt'){
			
			
					$stmt = $user_home->runQuery("SELECT unique_id FROM wall_posts WHERE post_unq=:post_unq");
					$stmt->execute(array(":post_unq"=>$_POST['Wp']));
					$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
					
					if($stmt->rowCount() == 1){
						$UniqueId=$userRow['unique_id'];
					
					$created=time();
					$stmt = $user_home->runQuery("INSERT INTO comments(wall_post_id,user_id,comment,created) VALUES (:wall_post_id,:user_id,:comment,:created)");
					$stmt->bindParam(':wall_post_id',$_POST['Wp']);
					$stmt->bindParam(':user_id',$_SESSION['IdSer']);
					$stmt->bindParam(':created',$created);
					$stmt->bindParam(':comment',$_POST['Vlu']);
					$stmt->execute();
			
					$comnter = array("t"=>$created,'u'=>$_SESSION['IdSer'],"c"=>$_POST['Vlu']);
					$comnt = json_encode($comnter,true);

					$stmt = $user_home->runQuery("UPDATE wall_posts SET comnt = :comnt,count_comment = count_comment+1 WHERE post_unq =:post_unq ");
					$stmt->bindParam(':comnt',$comnt);
					$stmt->bindParam(':post_unq',$_POST['Wp']);
					$stmt->execute();
						if($UniqueId != $_SESSION['IdSer']){
							$rdSts=0;$typenw='comment';	
							$stmt = $user_home->runQuery("INSERT INTO noticefication(t_id,f_id,n_tm,type,read_by,post_id) VALUES (:t_id,:f_id,:n_tm,:type,:read_by,:post_id)");
							$stmt->bindParam(':t_id',$UniqueId);
							$stmt->bindParam(':f_id',$_SESSION['IdSer']);
							$stmt->bindParam(':n_tm',$created);
							$stmt->bindParam(':type',$typenw);
							$stmt->bindParam(':read_by',$rdSts);
							$stmt->bindParam(':post_id',$_POST['Wp']);
							$stmt->execute();
						}	
					
					echo $created;
					die();
				}	
		}
		if($_POST['type'] == 'MsgShw'){
				$created = time();
				$Oky = array();
				$status = '0';
				$_SESSION['timer'] = $created;
			
				$stmt = $user_home->runQuery("SELECT message,timer,f_un,t_un FROM message WHERE f_un=:f_un AND t_un=:t_un AND status = :status");
				$stmt->execute(array(":f_un"=>$_POST['ToMsg'],":t_un"=>$_SESSION['IdSer'],":status"=>$status));
				$allst = $stmt->fetchAll(PDO::FETCH_ASSOC);
					foreach($allst as $apnw){
					    
					    $date_time = date('j F, Y',$apnw['timer']);
					    
						array_push($Oky,array('m'=>$apnw['message'],'t'=>$apnw['timer'],'s'=>$apnw['f_un'],'date_time'=>$date_time));
					}
				
					$status_as='1';
					$stmt = $user_home->runQuery("UPDATE friends SET status_as=:status_as WHERE msg_by=:f_un AND msg_to=:msg_to");
					$stmt->bindParam(':status_as',$status_as);
					$stmt->bindParam(':f_un',$_SESSION['IdSer']);
					$stmt->bindParam(':msg_to',$_POST['ToMsg']);
					$stmt->execute();
					
					$DtMsg = json_encode($Oky,TRUE);
					$yes=1;
					$stmt = $user_home->runQuery("UPDATE message SET status=:status WHERE f_un=:f_un AND t_un=:t_un AND status=:sty");
					$stmt->bindParam(':status',$yes);
					$stmt->bindParam(':f_un',$_POST['ToMsg']);
					$stmt->bindParam(':t_un',$_SESSION['IdSer']);
					$stmt->bindParam(':sty',$status);
					$stmt->execute();
					$date_time = date('j F, Y', $created);
					echo json_encode(array("t"=>$created,"d"=>$DtMsg,'date_time'=>$date_time)); 	
					die();

		
		}
		if($_POST['type'] == 'msgsnd'){
					$created=time();
					$Oky=array();
					$status='0';	
					$stmt = $user_home->runQuery("INSERT INTO message(timer,f_un,t_un,message) VALUES(:timer,:f_un,:t_un,:message)");
					$stmt->bindParam(':timer',$created);
					$stmt->bindParam(':f_un',$_POST['usr']);
					$stmt->bindParam(':t_un',$_POST['to']);
					$stmt->bindParam(':message',$_POST['msg']);
					$stmt->execute();
					
					$stmt = $user_home->runQuery("UPDATE users SET last_seen=:last_seen WHERE user_id=:user_id");
					$stmt->bindParam(':last_seen',$created);
					$stmt->bindParam(':user_id',$_SESSION['user_id']);
					$stmt->execute();
					$_SESSION['timer'] = $created;
					
					$date_time = date('j F, Y', $created);
					
					
					$status_as=0;
					$stmt = $user_home->runQuery("UPDATE friends SET msg_to=:msg_to,msg_by=:msg_by,msg_tm=:msg_tm,msg=:msg,status_as =:status_as WHERE(f_unique=:f_un AND t_unique=:t_un) OR (f_unique=:f_una AND t_unique=:t_una)");
					$stmt->bindParam(':msg_to',$_POST['usr']);
					$stmt->bindParam(':msg_by',$_POST['to']);
					$stmt->bindParam(':msg_tm',$created);
					$stmt->bindParam(':msg',$_POST['msg']);
					$stmt->bindParam(':status_as',$status_as);
					$stmt->bindParam(':f_un',$_POST['usr']);
					$stmt->bindParam(':t_un',$_POST['to']);
					$stmt->bindParam(':f_una',$_POST['to']);
					$stmt->bindParam(':t_una',$_POST['usr']);
					$stmt->execute();
					
					$stmt = $user_home->runQuery("SELECT message,timer,f_un,t_un FROM message WHERE f_un=:f_un AND t_un=:t_un AND status = :status");
					$stmt->execute(array(":f_un"=>$_POST['to'],":t_un"=>$_POST['usr'],":status"=>$status));
					$allst = $stmt->fetchAll(PDO::FETCH_ASSOC);
					foreach($allst as $apnw){
						array_push($Oky,array('m'=>$apnw['message'],'t'=>$apnw['timer'],'s'=>$apnw['f_un'],'date_time'=>$date_time));
					}
						
						array_push($Oky,array('m'=>$_POST['msg'],'t'=>$created,'s'=>$_POST['usr'],'current_user'=>$_POST['usr'],'date_time'=>$date_time));
						
						
					$DtMsg = json_encode($Oky,TRUE);
					$yes=1;
					$stmt = $user_home->runQuery("UPDATE message SET status=:status WHERE f_un=:f_un AND t_un=:t_un AND status=:sty");
					$stmt->bindParam(':status',$yes);
					$stmt->bindParam(':f_un',$_POST['to']);
					$stmt->bindParam(':t_un',$_POST['usr']);
					$stmt->bindParam(':sty',$status);
					$stmt->execute();
					
					echo json_encode(array("t"=>$created,"d"=>$DtMsg)); 	
					die();
		}
	
		
		if($_POST['type'] == 'SoMbr'){
			
				$PerPage='10';
				if($_POST['page'] != ''){
					$CrntPage=$_POST['page'];
					$End=$PerPage * $CrntPage;
					if($_GET['page'] == 1){
						$Start=0;
					}
					else{
						$Start=$End - $PerPage; 
					}
				}
				else{
					$Start=0;
					$End=$PerPage;
					$CrntPage=1;
				}
			
			
				if($_POST['vlu'] == 'Recent Added'){
					  $stmt= $user_home->runQuery("SELECT user_unq,user_name,email,country_id,profile_pic,headline,occupation FROM users WHERE user_unq!=:user_unq AND `delete_status` = 0 ORDER BY `users`.`created_at` DESC LIMIT $Start,$PerPage");
					  $stmt->execute(array(":user_unq"=>$_SESSION['IdSer']));
					  $userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
					  $Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
					  echo json_encode($Ay,TRUE);
					  exit();
				}
				else if($_POST['vlu'] == 'First Name'){
					  $stmt= $user_home->runQuery("SELECT user_unq,user_name,email,country_id,profile_pic,headline,occupation FROM users WHERE user_unq!=:user_unq AND `delete_status` = 0 ORDER BY `users`.`first_name` ASC LIMIT $Start,$PerPage");
					  $stmt->execute(array(":user_unq"=>$_SESSION['IdSer']));
					  $userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
					  $Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
					  echo json_encode($Ay,TRUE);
					  exit();
				}
				else if($_POST['vlu'] == 'Last Name'){
					  $stmt= $user_home->runQuery("SELECT user_unq,user_name,email,country_id,profile_pic,headline,occupation FROM users WHERE user_unq!=:user_unq AND `delete_status` = 0 ORDER BY `users`.`last_name` ASC LIMIT $Start,$PerPage");
					  $stmt->execute(array(":user_unq"=>$_SESSION['IdSer']));
					  $userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
					  $Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
					  echo json_encode($Ay,TRUE);
					  exit();
				}
		}
		else if($_POST['type'] == 'SoMbrConVw'){
				
				$v = $_POST['vlu'];
				$PerPage='10';
				if($_POST['page'] != ''){
					$CrntPage=$_POST['page'];
					$End=$PerPage * $CrntPage;
					if($_GET['page'] == 1){
						$Start=0;
					}
					else{
						$Start=$End - $PerPage; 
					}
				}
				else{
					$Start=0;
					$End=$PerPage;
					$CrntPage=1;
				}
				
			$user_unq =$_POST['usr'];$status='1';
			$stmt= $user_home->runQuery("SELECT f_unique,t_unique FROM friends WHERE (f_unique=:f_unique OR  t_unique=:t_unique) AND status=:status");
			$stmt->execute(array(":f_unique"=>$user_unq,":t_unique"=>$user_unq,":status"=>$status));
			$Ar=array();$Dta='';
			while($userRow=$stmt->fetch( PDO::FETCH_ASSOC )){
				
				
				if($userRow['f_unique'] == $user_unq){
					array_push($Ar,$userRow['t_unique']);
					$Dta.="'".$userRow['t_unique']."',";
				}
				else if($userRow['t_unique'] == $user_unq){
					array_push($Ar,$userRow['f_unique']);
					$Dta.="'".$userRow['f_unique']."',";
				}
			}
			
			$lst = implode (",",$Ar);
			$Lf = rtrim($Dta,",");

			if($Lf){	
				if($_POST['vlu'] == 'Recent Added'){		
					$stmt= $user_home->runQuery("SELECT * FROM users WHERE user_unq IN ($Lf) ORDER BY `users`.`created_at` DESC LIMIT $Start,$PerPage");
					$stmt->execute();
					$userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
					$Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
					echo json_encode($Ay,TRUE);
					exit();		
				}
				else if($_POST['vlu'] == 'First Name'){
					  $stmt= $user_home->runQuery("SELECT * FROM users WHERE user_unq IN ($Lf)  ORDER BY `users`.`first_name` ASC LIMIT $Start,$PerPage");
					  $stmt->execute();
					  $userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
					  	$Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
					    echo json_encode($Ay,TRUE);
					  exit();
				}
				else if($_POST['vlu'] == 'Last Name'){
					  $stmt= $user_home->runQuery("SELECT * FROM users WHERE user_unq IN ($Lf)  ORDER BY `users`.`last_name` ASC LIMIT $Start,$PerPage");
					  $stmt->execute();
					  $userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
						$Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
					    echo json_encode($Ay,TRUE);
					  exit();
				}
			}else{
				$userRow=array();
				$Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
				echo json_encode($Ay,TRUE);
				exit();
			}	
		}
		else if($_POST['type'] == 'SoMbrCon'){
				
				$v = $_POST['vlu'];
				
				$PerPage='10';
				if($_POST['page'] != ''){
					$CrntPage=$_POST['page'];
					$End=$PerPage * $CrntPage;
					if($_GET['page'] == 1){
						$Start=0;
					}
					else{
						$Start=$End - $PerPage; 
					}
				}
				else{
					$Start=0;
					$End=$PerPage;
					$CrntPage=1;
				}
				
				
			$user_unq =$_SESSION['IdSer'];$status='1';
			$stmt= $user_home->runQuery("SELECT f_unique,t_unique FROM friends WHERE (f_unique=:f_unique OR  t_unique=:t_unique) AND status=:status");
			$stmt->execute(array(":f_unique"=>$user_unq,":t_unique"=>$user_unq,":status"=>$status));
			$Ar=array();$Dta='';
			while($userRow=$stmt->fetch( PDO::FETCH_ASSOC )){
				if($userRow['f_unique'] == $user_unq){
					array_push($Ar,$userRow['t_unique']);
					$Dta.="'".$userRow['t_unique']."',";
				}
				else if($userRow['t_unique'] == $user_unq){
					array_push($Ar,$userRow['f_unique']);
					$Dta.="'".$userRow['f_unique']."',";
				}
			}
			$lst = implode (",",$Ar);
			$Lf = rtrim($Dta,",");
			if($Lf){
				if($_POST['vlu'] == 'Recent Added'){		
					$stmt= $user_home->runQuery("SELECT * FROM users WHERE user_unq IN ($Lf) ORDER BY `users`.`created_at` DESC LIMIT $Start,$PerPage");
					$stmt->execute();
					$userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);

					 $Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
					 echo json_encode($Ay,TRUE);
					exit();		
				}
				else if($_POST['vlu'] == 'First Name'){
					  $stmt= $user_home->runQuery("SELECT * FROM users WHERE user_unq IN ($Lf)  ORDER BY `users`.`first_name` ASC LIMIT $Start,$PerPage");
					  $stmt->execute();
					  $userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
					  $Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
 					  echo json_encode($Ay,TRUE);
					  exit();
				}
				else if($_POST['vlu'] == 'Last Name'){
					  $stmt= $user_home->runQuery("SELECT * FROM users WHERE user_unq IN ($Lf)  ORDER BY `users`.`last_name` ASC LIMIT $Start,$PerPage");
					  $stmt->execute();
					  $userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
					  $Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
 					  echo json_encode($Ay,TRUE);
					  exit();
				}
			}
			else{
				$userRow=array();
				 $Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
 				 echo json_encode($Ay,TRUE);
				exit();
			}	
				
			
		}
		else if($_POST['type'] == 'SrKy'){
				$v = $_POST['vlu']; 
		
				$PerPage='10';
				if($_POST['page'] != ''){
					$CrntPage=$_POST['page'];
					$End=$PerPage * $CrntPage;
					if($_GET['page'] == 1){
						$Start=0;
					}
					else{
						$Start=$End - $PerPage; 
					}
				}
				else{
					$Start=0;
					$End=$PerPage;
					$CrntPage=1;
				}
				
				$stmt= $user_home->runQuery("SELECT user_unq,user_name,email,country_id,profile_pic,headline,occupation FROM users WHERE user_name LIKE  CONCAT('%', :user_name, '%') AND user_unq!=:user_unq AND `delete_status` = 0 ORDER BY `users`.`user_name` ASC  LIMIT $Start,$PerPage");
				$stmt->execute(array(":user_unq"=>$_SESSION['IdSer'],":user_name"=>$v));
				$userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
				echo json_encode($Ay,TRUE);
			exit();		
		}
		else if($_POST['type'] == 'SrKyCon'){
			$v = $_POST['vlu'];
			
				$PerPage='10';
				if($_POST['page'] != ''){
					$CrntPage=$_POST['page'];
					$End=$PerPage * $CrntPage;
					if($_GET['page'] == 1){
						$Start=0;
					}
					else{
						$Start=$End - $PerPage; 
					}
				}
				else{
					$Start=0;
					$End=$PerPage;
					$CrntPage=1;
				}
			
			$user_unq =$_SESSION['IdSer'];$status='1';
			$stmt= $user_home->runQuery("SELECT f_unique,t_unique FROM friends WHERE (f_unique=:f_unique OR  t_unique=:t_unique) AND status=:status");
			$stmt->execute(array(":f_unique"=>$user_unq,":t_unique"=>$user_unq,":status"=>$status));
			$Ar=array();$Dta='';
			while($userRow=$stmt->fetch( PDO::FETCH_ASSOC )){
				
				
				if($userRow['f_unique'] == $user_unq){
					array_push($Ar,$userRow['t_unique']);
					$Dta.="'".$userRow['t_unique']."',";
				}
				else if($userRow['t_unique'] == $user_unq){
					array_push($Ar,$userRow['f_unique']);
					$Dta.="'".$userRow['f_unique']."',";
				}
			}
			
			$lst = implode (",",$Ar);
			$Lf = rtrim($Dta,",");
			if($Lf){		
				$user_unq =$_GET['id'];
				$stmt= $user_home->runQuery("SELECT * FROM users WHERE user_unq IN ($Lf) AND user_name LIKE  CONCAT('%', :user_name, '%') ORDER BY `users`.`user_name` ASC LIMIT $Start,$PerPage");
				$stmt->execute(array(":user_name"=>$v));
				$userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			else{
				$userRow=array();
			}
			$Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
			echo json_encode($Ay,TRUE);
			exit();		

		}
		else if($_POST['type'] == 'SrKyConVw'){
			$v = $_POST['vlu'];
				$PerPage='10';
				if($_POST['page'] != ''){
					$CrntPage=$_POST['page'];
					$End=$PerPage * $CrntPage;
					if($_GET['page'] == 1){
						$Start=0;
					}
					else{
						$Start=$End - $PerPage; 
					}
				}
				else{
					$Start=0;
					$End=$PerPage;
					$CrntPage=1;
				}
			$user_unq =$_POST['usr'];$status='1';
			$stmt= $user_home->runQuery("SELECT f_unique,t_unique FROM friends WHERE (f_unique=:f_unique OR  t_unique=:t_unique) AND status=:status");
			$stmt->execute(array(":f_unique"=>$user_unq,":t_unique"=>$user_unq,":status"=>$status));
			$Ar=array();$Dta='';
			while($userRow=$stmt->fetch( PDO::FETCH_ASSOC )){
				
				
				if($userRow['f_unique'] == $user_unq){
					array_push($Ar,$userRow['t_unique']);
					$Dta.="'".$userRow['t_unique']."',";
				}
				else if($userRow['t_unique'] == $user_unq){
					array_push($Ar,$userRow['f_unique']);
					$Dta.="'".$userRow['f_unique']."',";
				}
			}
			
			$lst = implode (",",$Ar);
			$Lf = rtrim($Dta,",");
			if($Lf){		
				$user_unq =$_GET['id'];
				$stmt= $user_home->runQuery("SELECT * FROM users WHERE user_unq IN ($Lf) AND user_name LIKE  CONCAT('%', :user_name, '%') ORDER BY `users`.`user_name` ASC LIMIT $Start,$PerPage");
				$stmt->execute(array(":user_name"=>$v));
				$userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			else{
				$userRow=array();
			}
			$Ay = array('js'=>$userRow,'cnt'=>array('s'=>$Start,'e'=>$End,'c'=>$CrntPage));
			echo json_encode($Ay,TRUE);
			exit();		
		}
	
		if($_POST['type'] == 'FrndLst'){
			$frndst=array();
			$status = 0;
			$stmt = $user_home->runQuery("SELECT f_unique,t_unique,time FROM friends WHERE t_unique=:t_unique AND status=:status");
			$stmt->execute(array(":t_unique"=>$_SESSION['IdSer'],":status"=>$status));
			$allst = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach($allst as $apnw){
				array_push($frndst,array('f'=>$apnw['f_unique'],'t'=>$apnw['time']));
			}
			$LstFrd = json_encode($frndst,TRUE);
			echo $LstFrd;
			exit;
		}
		if($_POST['type'] == 'rating'){
		
		$stmt = $user_home->runQuery("SELECT id,f_name,created_by,url  FROM films WHERE url=:url");
		$stmt->execute(array(":url"=>$_POST['id']));
		$FlmRw=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() == 1){
			$stmt = $user_home->runQuery("SELECT rating FROM users WHERE user_unq=:user_unq");
			$stmt->execute(array(":user_unq"=>$_SESSION['IdSer']));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1){
				$Rt = json_decode($userRow['rating'],TRUE);
				if (array_key_exists($FlmRw['id'],$Rt)){
					echo "Already Rate Movie";
				}
				else
				{
					$Rt[$FlmRw['id']]=$_POST['r'];
					$Tr	= json_encode($Rt,TRUE);
					$stmt = $user_home->runQuery("UPDATE users SET rating=:rating WHERE user_unq=:user_unq");
					$stmt->execute(array(":rating"=>$Tr,":user_unq"=>$_SESSION['IdSer']));
					$stmt = $user_home->runQuery("UPDATE films SET rating=rating+:rating,rating_total=rating_total+1 WHERE id=:id");
					$stmt->execute(array(":rating"=>$_POST['r'],":id"=>$FlmRw['id']));
					
					
					$user_unq = $_SESSION['IdSer'];
					$time=time();$type='rating';$read_by=0;
					$send_request = $user_home->runQuery("INSERT INTO noticefication(t_id,f_id,n_tm,type,read_by,post_id,post_name,extra) VALUES (:t_id,:f_id,:n_tm,:type,:read_by,:post_id,:post_name,:extra)");
					$send_request->bindParam(':t_id',$user_unq);
					$send_request->bindParam(':f_id',$FlmRw['created_by']);
					$send_request->bindParam(':n_tm',$time);
					$send_request->bindParam(':type',$type);      
					$send_request->bindParam(':read_by',$read_by);                   
					$send_request->bindParam(':post_id',$FlmRw['url']);                   
					$send_request->bindParam(':post_name',$FlmRw['f_name']);                   
					$send_request->bindParam(':extra',$_POST['r']);                   
					$send_request->execute();
					
					
					
					
					
					echo $Tr;
					
					
					
				}
			}
		  }	
			exit;
		}
		if($_POST['type'] == 'likes'){
			$stmt = $user_home->runQuery("SELECT likes FROM users WHERE user_unq=:user_unq");
			$stmt->execute(array(":user_unq"=>$_SESSION['IdSer']));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1){
				$Rt = json_decode($userRow['likes'],TRUE);
				if (array_key_exists($_POST['id'],$Rt)){
					unset($Rt[$_POST['id']]);
					$Tr	= json_encode($Rt,TRUE);
					$stmt = $user_home->runQuery("UPDATE users SET likes=:likes WHERE user_unq=:user_unq");
					$stmt->execute(array(":likes"=>$Tr,":user_unq"=>$_SESSION['IdSer']));
					$stmt = $user_home->runQuery("UPDATE films SET like_total=like_total-1 WHERE id=:id");
					$stmt->execute(array(":id"=>$_POST['id']));
					echo 'UnLike';
				}
				else
				{
					$Rt[$_POST['id']]=$_POST['r'];
					$Tr	= json_encode($Rt,TRUE);
					$stmt = $user_home->runQuery("UPDATE users SET likes=:likes WHERE user_unq=:user_unq");
					$stmt->execute(array(":likes"=>$Tr,":user_unq"=>$_SESSION['IdSer']));
					$stmt = $user_home->runQuery("UPDATE films SET like_total=like_total+1 WHERE id=:id");
					$stmt->execute(array(":id"=>$_POST['id']));
					echo 'Like';
				}
			}
			exit;
		}
		
		
		if($_POST['type'] == 'RemoveCvr'){
				$img='defualt.jpg';
				$stmt = $user_home->runQuery("UPDATE users SET cover_image=:cover_image WHERE user_id=:user_id");
						$stmt->bindParam(':cover_image',$img);
						$stmt->bindParam(':user_id',$_SESSION['user_id']);
				if($stmt->execute()){
					echo 'Image Delete Successfully';
				}
				else{
					echo 'something went wrong';
				}
				exit;
		}
		
		if($_POST['type'] == 'RemovePic'){
			$img='defualt.webp';
				$stmt = $user_home->runQuery("UPDATE users SET profile_pic=:profile_pic WHERE user_id=:user_id");
						$stmt->bindParam(':profile_pic',$img);
						$stmt->bindParam(':user_id',$_SESSION['user_id']);
				if($stmt->execute()){
					echo 'Image Delete Successfully';
				}
				else{
					echo 'something went wrong';
				}
				exit;
		}
		
		if($_POST['type'] == 'NoticeLst'){
			$frndst=array();
			$status = 0;
			$user_unq =$_SESSION['IdSer'];$status='0';
				$stmt= $user_home->runQuery("SELECT 
					users.user_unq,users.user_name,noticefication.type,
					noticefication.n_tm,noticefication.post_id,users.profile_pic 
					FROM users
					LEFT JOIN noticefication ON users.user_unq = noticefication.t_id
					WHERE noticefication.f_id=:f_id AND noticefication.read_by=:read_by");
				$stmt->execute(array(":f_id"=>$user_unq,":read_by"=>$status));
				$userRowFrnd=$stmt->fetchAll(PDO::FETCH_ASSOC);
				echo json_encode($userRowFrnd);
				exit;
		}
		if($_POST['type'] == 'MsgLst'){
			$user_unq = $_SESSION['IdSer'];
			$status='0';
			
			$userRowFrnd_arr = [];
			
			$stmt= $user_home->runQuery("SELECT 
				users.user_unq,users.user_name,users.profile_pic,
				friends.msg,friends.msg_tm,friends.status_as  
				FROM users
				LEFT JOIN friends ON users.user_unq = friends.msg_to
				WHERE friends.msg_by=:by AND friends.status!=:st ORDER BY friends.msg_tm DESC");
			$stmt->execute(array(":by"=>$user_unq,":st"=>$status));
			$userRowFrnd = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				foreach($userRowFrnd as $userRow){
				    $userRow['date_time'] = date('j F, Y', $userRow['msg_tm']);
				    $userRowFrnd_arr[] = $userRow;
				}
				
				
				echo json_encode($userRowFrnd_arr);
				exit;
		}
		if($_POST['type'] == 'NoticeLstRead'){
			
		}
		if($_POST['type'] == 'NoticeLstRead'){
			
		}
		if($_POST['type'] == 'FltrMy'){
			
				$Ay = array(
					"Film Name"=>"f_name",
					"Country"=>"f_cnty",
					"Language"=>"f_lng",
					"Producer"=>"p_name",
					"Director"=>"d_name",
					"Writer"=>"w_name",
					"Actor"=>"a_name"
				);
			
			$Nm = $_POST['OvrHnL'];
			$Fp = $_POST['FltSg'];
			$Sg = $_POST['OvrHnLsnd'];
			$Ur = $_POST['user'];
			
			
			$D = array(":created_by"=>$Ur);
			
			if($Sg == 'All'){
				$Sgw='';
			}
			else{
				$Sgw=' AND f_stg = :f_stg';
				$D[":f_stg"] = $Sg; 
			}
		
			if($Fp == 2){
				$Fpw='AND film_premiere_date >= :film_premiere_date';
				$D[":film_premiere_date"] = $Date; 
			}
			else if($Fp == 3){
				$Fpw='';
			}

			if($_POST['id'] != ''){
				$IDs = $_POST['id'];
				$Dts="";						
				$D[":f_genre"] = $IDs; 
			}
			else{
				$Dts="";	
			}
				
			$Date = date("Y-m-d H:i:s");
			if($_POST['OvrHnR'] != ''){
				
			$D[":Ay"] = $_POST['OvrHnR'];
					

			if($_POST['id'] != ''){
				$stmt = $user_home->runQuery("
					SELECT 	
					f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
					f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
					f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
					FROM 
						films 
					WHERE 
						$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') AND f_genre LIKE CONCAT('%', :f_genre, '%') AND created_by =:created_by $Sgw $Fpw
				");
			}
			else{
				$stmt = $user_home->runQuery("
					SELECT 	
					f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
					f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
					f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
					FROM 
						films 
					WHERE 
						$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') AND created_by =:created_by $Sgw $Fpw
				");
			}	
				
				$stmt->execute($D);
				$RwCnt = $stmt->rowCount();
				
				
					$PerPage='3';
					if($_GET['page'] != ''){
						$CrntPage=$_GET['page'];
						$End=$PerPage * $CrntPage;
						if($_GET['page'] == 1){
							$Start=0;
						}
						else{
							$Start=$End - $PerPage; 
						}
					}
					else{
						$Start=0;
						$End=$PerPage;
						$CrntPage=1;
					}
					$TotPage= $RwCnt/$PerPage;
					if ((int) $TotPage == $TotPage) {
						$TotPage = intval($TotPage);
					}
					else{
						$TotPage = intval($TotPage) + 1;
					}
	
			if($_POST['id'] != ''){
				$stmt = $user_home->runQuery("
					SELECT 	
					f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
					f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
					f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
					FROM 
						films 
					WHERE 
						$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') AND f_genre LIKE CONCAT('%', :f_genre, '%')  AND created_by =:created_by $Sgw $Fpw LIMIT $Start,$PerPage
				");
			}
			else{
				$stmt = $user_home->runQuery("
					SELECT 	
					f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
					f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
					f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
					FROM 
						films 
					WHERE 
						$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') AND created_by =:created_by $Sgw $Fpw LIMIT $Start,$PerPage
				");
			}	
				$stmt->execute($D);
				$userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				$Ay = array('js'=>$userRow,'cnt'=>array('t'=>$TotPage,'s'=>$Start,'e'=>$End,'c'=>$CrntPage));
				echo json_encode($Ay,TRUE);
			}
			else{
			
				
				if($_POST['id'] != ''){
					$IDs = $_POST['id'];
					$Dts="";			
					$D[":f_genre"] = $IDs; 
				}
				else{
					$Dts="";	
				}
				
				if($_POST['id'] != ''){
					$stmt = $user_home->runQuery("
						SELECT 	
						f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
						f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
						f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
						FROM 
							films 
						WHERE 
							f_genre LIKE CONCAT('%', :f_genre, '%') AND created_by=:created_by $Sgw $Fpw
					");
				}
				else{
					$stmt = $user_home->runQuery("
						SELECT 	
						f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
						f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
						f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
						FROM 
							films 
						WHERE 
							 created_by=:created_by $Sgw $Fpw
					");
				}	
					$stmt->execute($D);
					$RwCnt = $stmt->rowCount();
					
					$PerPage='3';
					if($_GET['page'] != ''){
					
						$CrntPage=$_GET['page'];
						$End=$PerPage * $CrntPage;
						if($_GET['page'] == 1){
							$Start=0;
						}
						else{
							$Start=$End - $PerPage; 
						}
					}
					else{
						$Start=0;
						$End=$PerPage;
						$CrntPage=1;
					}
					$TotPage= $RwCnt/$PerPage;
					if ((int) $TotPage == $TotPage) {
						$TotPage = intval($TotPage);
					}
					else{
						$TotPage = intval($TotPage) + 1;
					}
				
				if($_POST['id'] != ''){
					$stmt = $user_home->runQuery("
						SELECT 	
						f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
						f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
						f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
						FROM 
							films 
						WHERE 
						f_genre LIKE CONCAT('%', :f_genre, '%') AND created_by=:created_by $Sgw $Fpw LIMIT $Start,$PerPage
					");
				}
				else{
					$stmt = $user_home->runQuery("
						SELECT 	
						f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
						f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
						f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
						FROM 
							films 
						WHERE 
							created_by=:created_by $Sgw $Fpw LIMIT $Start,$PerPage
					");
				}
				$stmt->execute($D);
				$userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				$Ay = array('js'=>$userRow,'cnt'=>array('t'=>$TotPage,'s'=>$Start,'e'=>$End,'c'=>$CrntPage));
				echo json_encode($Ay,TRUE);
			}
			exit;
		}
		if($_POST['type'] == 'FltrCld'){
				$Ay = array(
					"Film Name"=>"f_name",
					"Country"=>"f_cnty",
					"Language"=>"f_lng",
					"Producer"=>"p_name",
					"Director"=>"d_name",
					"Writer"=>"w_name",
					"Actor"=>"a_name"
				);
				
				$Nm = $_POST['OvrHnL'];
				$Wt = $_POST['OvrHnR'];
				
				
				$stg='Complete';
				$D = array(":Ay"=>$_POST['OvrHnR'],":f_stg"=>$stg);
			
				if($_POST['id'] != ''){
					$IDs=$_POST['id'];
					$link="&OvrHnL=$Nm&OvrHnR=$Wt&type=filter&id=$IDs";
					$D[":f_genre"] = $IDs; 
				}
				else{
					$link="&OvrHnL=$Nm&OvrHnR=$Ov&type=filter";
				}
				
				
				if($_POST['id'] != ''){
					$result = $user_home->runQuery("
							SELECT 	
								f_name  
							FROM
								films 
							WHERE 
								$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') AND f_stg = :f_stg AND f_genre LIKE CONCAT('%', :f_genre, '%')
					");
				}
				else{
					$result = $user_home->runQuery("
							SELECT 	
								f_name  
							FROM
								films 
							WHERE 
								$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') AND f_stg = :f_stg
					");
				}		
				
				
				
				
				
				$result->execute($D);
				$RwCnt = $result->rowCount();

				

				
				$PerPage='3';
				$Start=0;
				$End=$PerPage;
				$CrntPage=1;
				
				
					$TotPage= $RwCnt/$PerPage;
					if ((int) $TotPage == $TotPage) {
						$TotPage = intval($TotPage);
					}
					else{
						$TotPage = intval($TotPage) + 1;
					}
				
				
			
				
				if($_POST['id'] != ''){
					$stmt = $user_home->runQuery("
						SELECT 	
						f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
						f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
						f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
						FROM 
							films 
						WHERE 
							$Ay[$Nm] LIKE CONCAT('%', :Ay, '%') AND f_stg=:f_stg AND f_genre LIKE CONCAT('%', :f_genre, '%') LIMIT $Start,$PerPage
					");
				}
				else{
					$stmt = $user_home->runQuery("
						SELECT 	
						f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
						f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
						f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
						FROM 
							films 
						WHERE 
							$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') AND f_stg=:f_stg LIMIT $Start,$PerPage
					");
				}	
					$stmt->execute($D);
					$userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				$Ay = array('js'=>$userRow,'cnt'=>array('t'=>$TotPage,'s'=>$Start,'e'=>$End,'c'=>$CrntPage));
				echo json_encode($Ay,TRUE);
				exit;
		}
		if($_POST['type'] == 'FltrClp'){
			
			$Ay = array(
					"Film Name"=>"f_name",
					"Country"=>"f_cnty",
					"Language"=>"f_lng",
					"Producer"=>"p_name",
					"Director"=>"d_name",
					"Writer"=>"w_name",
					"Actor"=>"a_name"
				);
			
			$Nm = $_POST['OvrHnL'];
			$Fp = $_POST['FltSg'];
			$Sg = $_POST['OvrHnLsnd'];
			
			if($Fp == 2){
				$Fpw='AND film_premiere_date >= :film_premiere_date';
			}
			else if($Fp == 3){
				$Fpw='';
			}
			$Date = date("Y-m-d H:i:s");
			if($_POST['OvrHnR'] != ''){
				if($Sg == 'All'){
					$Sgw='AND f_stg != :f_stg';
					$Sg='Complete';
				}
				else{
					$Sgw=' AND f_stg = :f_stg';
				}
				
				$D = array(":Ay"=>$_POST['OvrHnR'],":f_stg"=>$Sg);
				if($Fp == 2){
					$D[":film_premiere_date"] = $Date; 
				}
				
				$IDs = $_POST['id'];
					
				if($_POST['id'] != ''){
					$Dts="";						
					$D[":f_genre"] = $IDs; 
				}
				else{
					$Dts="";	
				}	
					

			if($_POST['id'] != ''){
				$stmt = $user_home->runQuery("
					SELECT 	
					f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
					f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
					f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
					FROM 
						films 
					WHERE 
						$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') AND f_genre LIKE CONCAT('%', :f_genre, '%') $Sgw $Fpw
				");
			}
			else{
				$stmt = $user_home->runQuery("
					SELECT 	
					f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
					f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
					f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
					FROM 
						films 
					WHERE 
						$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') $Sgw $Fpw
				");
			}	
				
				$stmt->execute($D);
				$RwCnt = $stmt->rowCount();
				
				
					$PerPage='3';
					if($_GET['page'] != ''){
						$CrntPage=$_GET['page'];
						$End=$PerPage * $CrntPage;
						if($_GET['page'] == 1){
							$Start=0;
						}
						else{
							$Start=$End - $PerPage; 
						}
					}
					else{
						$Start=0;
						$End=$PerPage;
						$CrntPage=1;
					}
					$TotPage= $RwCnt/$PerPage;
					if ((int) $TotPage == $TotPage) {
						$TotPage = intval($TotPage);
					}
					else{
						$TotPage = intval($TotPage) + 1;
					}
	
			if($_POST['id'] != ''){
				$stmt = $user_home->runQuery("
					SELECT 	
					f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
					f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
					f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
					FROM 
						films 
					WHERE 
						$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') AND f_genre LIKE CONCAT('%', :f_genre, '%') $Sgw $Fpw  LIMIT $Start,$PerPage
				");
			}
			else{
				$stmt = $user_home->runQuery("
					SELECT 	
					f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
					f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
					f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
					FROM 
						films 
					WHERE 
						$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') $Sgw $Fpw LIMIT $Start,$PerPage
				");
			}	
				$stmt->execute($D);
				$userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				$Ay = array('js'=>$userRow,'cnt'=>array('t'=>$TotPage,'s'=>$Start,'e'=>$End,'c'=>$CrntPage));
				echo json_encode($Ay,TRUE);
			}
			else{
			
			
				if($Sg == 'All'){
					$Sgw='f_stg != :f_stg';
					$Sg='Complete';
				}
				else{
					$Sgw='f_stg = :f_stg';
				}
				
				$D = array(":f_stg"=>$Sg);
				if($Fp == 2){
					$D[":film_premiere_date"] = $Date; 
				}
				
				$IDs = $_POST['id'];
				if($_POST['id'] != ''){
					$Dts="";			
					$D[":f_genre"] = $IDs; 
				}
				else{
					$Dts="";	
				}
				
				if($_POST['id'] != ''){
					$stmt = $user_home->runQuery("
						SELECT 	
						f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
						f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
						f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
						FROM 
							films 
						WHERE 
							f_genre LIKE CONCAT('%', :f_genre, '%') AND $Sgw $Fpw
					");
				}
				else{
					$stmt = $user_home->runQuery("
						SELECT 	
						f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
						f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
						f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
						FROM 
							films 
						WHERE 
							$Sgw $Fpw
					");
				}	
					$stmt->execute($D);
					$RwCnt = $stmt->rowCount();
					
					$PerPage='3';
					if($_GET['page'] != ''){
					
						$CrntPage=$_GET['page'];
						$End=$PerPage * $CrntPage;
						if($_GET['page'] == 1){
							$Start=0;
						}
						else{
							$Start=$End - $PerPage; 
						}
					}
					else{
						$Start=0;
						$End=$PerPage;
						$CrntPage=1;
					}
					$TotPage= $RwCnt/$PerPage;
					if ((int) $TotPage == $TotPage) {
						$TotPage = intval($TotPage);
					}
					else{
						$TotPage = intval($TotPage) + 1;
					}
				
				if($_POST['id'] != ''){
					$stmt = $user_home->runQuery("
						SELECT 	
						f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
						f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
						f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
						FROM 
							films 
						WHERE 
						f_genre LIKE CONCAT('%', :f_genre, '%') AND $Sgw $Fpw LIMIT $Start,$PerPage
					");
				}
				else{
					$stmt = $user_home->runQuery("
						SELECT 	
						f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
						f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
						f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
						FROM 
							films 
						WHERE 
							$Sgw $Fpw LIMIT $Start,$PerPage
					");
				}
				$stmt->execute($D);
				$userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				$Ay = array('js'=>$userRow,'cnt'=>array('t'=>$TotPage,'s'=>$Start,'e'=>$End,'c'=>$CrntPage));
				echo json_encode($Ay,TRUE);
			}
			exit;
		}
		
		
	}
}
					


$BY='
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-signin-client_id" content="860006994381-3t8ghk076l51jcmhtvpthv4odahesef0.apps.googleusercontent.com">
    
	<link href="http://localhost/movi_africa/css/font-awesome.min.css" rel="stylesheet"/>
	<link href="http://localhost/movi_africa/css/bootstrap.min.css" rel="stylesheet"/>
	<link href="http://localhost/movi_africa/css/style.css" rel="stylesheet"/>
	<link href="http://localhost/movi_africa/css/custom-css.css" rel="stylesheet"/>
	<link rel="icon" href="http://localhost/movi_africa/images/icon.png" type="image/png" sizes="16x16"/>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="http://localhost/movi_africa/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://localhost/movi_africa/js/bootstrap.min.js"></script>
    <script src="http://localhost/movi_africa/js/bootstrap-datetimepicker.js"></script>
    <script src="http://localhost/movi_africa/js/bootstrap-datetimepicker.fr.js"></script>
    <script></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
  </head>
<body style="background:#fff;">';



if($logoRow['col1']!=""){
    $logo_img = "http://localhost/movi_africa/webimg/".$logoRow['col1'];
}else{
    $logo_img = "http://localhost/movi_africa/images/africa logo01.png";
}

if(!$user_home->is_logged_in()){

$BY.='
	<nav class="navbar navbar-inverse navbar-static-top navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" 
				  aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"> <img src="'.$logo_img.'"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="header-right">';
                 
                if($activePage=="contact" || $activePage=="aboutus" || $activePage=="terms"|| $activePage=="privacy" ){
                    $BY.='<div class="login_signup">
                            <a class="login_btn" href="/index">Login</a>
                            <a class="login_btn" href="/index">Sign Up</a>
                        </div>';
                }else{
                    $BY.='<form class="navbar-form navbar-right" method="POST">
                        <div class="form-group">
                          <input placeholder="Email" class="form-control" type="text" name="login_email" required>
                        </div>
                        <div class="form-group outer_fg">
                          <input placeholder="Password" class="form-control" type="password" name="login_password" required>
                          <a class="f_pas" href="forget-password">Forget Your Password?</a>
                        </div>
        			    <button type="submit" style="text-transform: capitalize;" class="btn btn-success">Log in</button>
                    </form>';
                }
                
                
            
                
                
            $BY.='</div>
        </div>
      </div>
    </nav>';            
}
else{
$BY.='            
	<nav class="navbar navbar-inverse navbar-static-top navigation" style="top:0;">
		<div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed desktp" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><img src="'.$logo_img.'" alt="img"/></a>
        </div>
     
	 <div class="mobile_seen">
	<div id="mySidenav" class="sidenav">
	  <ul>
	    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <!--<ul class="drop-down closed">
                <li><a href="#" id="filmproject" class="nav-button">Projects</a></li>
                <li><a href="/manage-film">New Film</a></li>
                <li><a href="/film/in-progress">In Progress</a></li>
                <li><a href="/film/complete">Completed</a></li>
            </ul>-->
		</li>
		    <a id="people" class="li-pdng-a"  href="/project">Projects</a>   
            <a id="people" class="li-pdng-a"  href="/people"> People</a>
            
            <a id="people" class="li-pdng-a"  href="/scripts">Scripts</a>
            <a id="people" class="li-pdng-a"  href="/jobs">Jobs</a>
             <a id="people" class="li-pdng-a"  href="/support">Support</a>
             
            <a class="li-pdng-a"  id="Connection" href="/my-connections">My Network</a>
            <a class="li-pdng-a li-pdng-active" id="MsgLst" href="/message">Messages</a>
            <a class="li-pdng-a li-pdng-active" id="NoticeLst" href="/notification">Notifications</a>
            <a class="li-pdng-a"  href="/@'.$_SESSION['IdSer'].'"> Profile </a>';

        if($_SESSION['admin_control']==0){ 	
            $BY.='<!--<a id="feedback" class="li-pdng-a" href="/feedback">Feedback</a>-->';
        } 
	    else{
	       $BY.='<!--<a id="feedback" class="li-pdng-a" href="/admin/feedback-report">Feedback</a>-->
				 <a class="li-pdng-a li-pdng-active" id="dashboardLst" href="/admin/dashboard">Dashboard</a>';
	    }

	$BY.='<a style="height: 34px;" onclick="signOut();" href="logout">Logout</a></ul></div><span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span></div>  
        
        
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right nav_nl">	 
                    <!--<li class="li-pdng-nw" id="filmprojectDrp"><a id="filmproject" class="li-pdng-a">
                    	<i style="background:url(\'/headnav/filmproject.png\');width:24px;height:24px;"></i>
                    	<span>Projects</span></a>
                    	<div id="SubProjectMnu"> 
                    		<a class="SubProjectMnu" style="border-bottom: 1px solid #c7d1d8;" href="/manage-film">New Film</a>
                    		<a class="SubProjectMnu" style="border-bottom: 1px solid #c7d1d8;" href="/film/in-progress">In Progress</a>
                    		<a class="SubProjectMnu" href="/film/complete">Completed</a>
                    	</div>-->
                    </li> 
                    
                    
                    
                    <li class="li-pdng-nw">
                    	<a id="filmproject" class="li-pdng-a" href="/project">
                    	<!--<i style="background:url(\'/headnav/filmproject.png\');width:24px;height:24px;"></i>-->
                    	<span>Projects</span></a>
                    </li> 
                    
                    
                    
                    <li class="li-pdng-nw"><a id="people" class="li-pdng-a"  href="/people">
           
                    	<!--<i style="background:url(\'/headnav/people.png\');width:24px;height:24px;"></i>-->
                    	<span> People</span></a>
                    </li>
                    
                    <li class="li-pdng-nw"><a id="people" class="li-pdng-a"  href="/scripts">
                        <span>Scripts</span></a>
                    </li>
                    
                    <li class="li-pdng-nw"><a id="people" class="li-pdng-a"  href="/jobs">
                        <span>Jobs</span></a>
                    </li>
                    <li class="li-pdng-nw"><a id="people" class="li-pdng-a"  href="/support">
                        <span>Support</span></a>
                    </li>
                    
                    
                    
                    <!--<li class="li-pdng-nw"><a class="li-pdng-a"  id="Connection" href="/my-connections">
                    	<span class="cnt"></span>
                    	<i style="background:url(\'/headnav/network.png\');width:24px;height:24px;"></i>
                    	<span>My Network</span></a>
                    </li>-->
                    
                    <!--<li class="li-pdng-nw">
                        <a class="li-pdng-a li-pdng-active" id="MsgLst" href="/message">
                        	<span class="cnt"></span>
                        	<i style="background:url(\'/headnav/message.png\');width:24px;height:24px;"></i>
                        	<span>Messages</span>
                        	<div class="NoticeMsg" id="MsgLstBxr"></div>
                        </a>
                    </li>
                    <li class="li-pdng-nw">
                        <a class="li-pdng-a li-pdng-active" id="NoticeLst" href="/notification">
                        	<span class="cnt"></span>
                        	<i style="background:url(\'/headnav/bell.png\');width:24px;height:24px;"></i>
                        	<span>Notifications</span>
                    	</a>
                    	<div class="NoticeMsg" id="NoticeLstBxr"></div>
                    </li>
                    
                    <li class="li-pdng-nw"><a id="profile" class="li-pdng-a"  href="/@'.$_SESSION['IdSer'].'">
                    		<i style="background:url(\'/headnav/profile1.png\');width:24px;height:24px;"></i>
                    	<span>My Profile</span></a>
                    </li>-->
                   
                    ';
                    
                    
                    	
                    if($_SESSION['admin_control']==0){
                    	$BY.='<!--<li class="nav-item li-pdng-nw"><a id="feedback" class="li-pdng-a" href="/feedback">
                    		</a>
                    	</li>-->';
                    }
                    else{
                    	$BY.='<!--<li class="nav-item li-pdng-nw"><a id="feedback" class="li-pdng-a" href="/admin/feedback-report">
                    	
                    		<span>Feedback</span></a>
                    	</li>
                    	<li class="nav-item li-pdng-nw"><a class="li-pdng-a li-pdng-active" id="dashboardLst" href="/admin/dashboard">
                    		<span class="cnt"></span>
  
                    		<span>Dashboard</span></a>
                    		<div class="NoticeMsg" id="NoticeLstBxr"></div>
                    	</li> -->';
                    }
                    
                    
                    
                    $BY.='
                        <li class="nav-item li-pdng-nw dropdown">
                        <a href="javascript:void(0);"  class="dropdown-toggle li-pdng-a" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="profile" >
                    		<img src="/headnav/profile1.png"><i class="fa fa-chevron-down"></i> <!--<span class="cnt"></span>-->   </a>
                    	
                    	<ul class="dropdown-menu">
                    	
                    	
                            <li class=" "><a href="/@'.$_SESSION['IdSer'].'">Profile</a></li>
                            
                            <li class=" ">
                                <a id="MsgLst" href="/message">Messages <span class="cnt"></span> <div class="NoticeMsg" id="MsgLstBxr"></div></a> 
                            </li>
                            
                            <li class=" ">
                                <a id="NoticeLst" href="/notification">Notifications  <span class="cnt"></span> <div class="NoticeMsg" id="NoticeLstBxr"></div></a>
                            </li>
                            
                            
                            <li class=" ">
                                <a id="Connection" href="/my-connections">My Network  <span class="cnt"></span> 
                                
                                    
                                </a>
                            </li>';
                            if($_SESSION['admin_control']==1){
                                $BY.='<li class=" ">
                                    <a id="dashboardLst" href="/admin/dashboard">Dashboard <span class="cnt"></span> 
                                    
                                       <div class="NoticeMsg" id="NoticeLstBxr"></div> 
                                    </a>
                                </li>';
                            }
                            
                            
                            
                            $BY.='<li><a onclick="signOut();" href="/logout">Logout</a></li>
                        </ul>
                    </li>
                    
                    
                    ';
                    
                        $BY.='
                    
                </ul>
            </div>
        </div>
</nav>';
	
	
	}
	
		$BY.='<div style="width:100%;height:67px;"></div>';


  