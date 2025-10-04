<?php
session_start();
require_once 'main-class.php';
$user_home = new USER();



    $stmt = $user_home->runQuery("SELECT * FROM users WHERE gmail_id=:gmail_id");
    $stmt->execute(array(":gmail_id"=>$_POST['gmail_id']));
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1){
			    

			    
			    if($userRow['delete_status']==0){
			        
                    $_SESSION['user_id'] = $userRow['user_id'];
                    $_SESSION['first_name'] = $_POST['first_name'];
                    $_SESSION['user_name'] = $userRow['user_name'];
                    $_SESSION['email'] = $userRow['email'];
        			$_SESSION['status'] = $userRow['status'];
    				$_SESSION['last_seen'] = $userRow['last_seen'];
    				$_SESSION['profile_pic'] = $userRow['profile_pic'];	
    				$_SESSION['cover_image'] =  $userRow['cover_image'];	
                    $_SESSION['IdSer'] = $userRow['user_unq'];	
                    $_SESSION['reg_type'] = $userRow['reg_type'];	
        			echo "1";
			    }else{
			        echo "0";
			    }
			}
			else{
			    $verify = '1' ;
			    $Time = time();
		        $reg_type = "gmail";
		        $last_seen = 0;
		        $admin_control = 0;
		        
			    $stmt = $user_home->runQuery("
						INSERT INTO users(
							user_name,first_name,last_name,email,gmail_id,created_at,last_seen,verify,admin_control,reg_type
						) 
						VALUES(
							:user_name,:first_name,:last_name,:email,:gmail_id,:created_at,:last_seen,:verify,:admin_control,:reg_type
						)
			    ");    
                    

				
				$stmt->bindparam(":first_name",$_POST['first_name']);
		        $stmt->bindparam(":last_name",$_POST['last_name']);
				$stmt->bindparam(":user_name",$_POST['name']);
				$stmt->bindparam(":email",$_POST['email']);
                $stmt->bindparam(":gmail_id",$_POST['gmail_id']);
		        $stmt->bindparam(":created_at",$Time);
				$stmt->bindparam(":last_seen",$last_seen);
				$stmt->bindparam(":verify",$verify);
		        $stmt->bindparam(":reg_type",$reg_type);
		        $stmt->bindparam(":admin_control",$admin_control);
		        
		        $stmt->execute();
		
				$Id = $user_home->lasdID();

					 
			    $_SESSION['user_id'] = $Id;
			    $_SESSION['first_name'] = $_POST['first_name'];
                $_SESSION['user_name'] = $_POST['name'];
                $_SESSION['email'] = $_POST['email'];
				$_SESSION['last_seen'] = $last_seen;
				$_SESSION['profile_pic'] = "";	
				$_SESSION['cover_image'] =  "";	
                $_SESSION['reg_type'] = $reg_type;
				
				echo "1";

			}
?>