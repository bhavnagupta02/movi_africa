<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'db-config.php';
require 'phpmailer/vendor/autoload.php';

class USER
{	
	
	private $conn;
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}

    public function reset_password($email){
		try
		{
			$type='forget_password';$Tm=time();
			$token_no = md5(uniqid($Tm, true));
			
			$stmt = $this->conn->prepare("UPDATE users SET token=:token,token_type=:type WHERE email=:email");
			
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":type",$type);
			$stmt->bindparam(":token",$token_no);
			$stmt->execute();	

					//header("Location: verify.php?user_mail=".$email);
					//exit;
					
		}
		catch(PDOException $ex)
		{
			 //echo $ex->getMessage();
		}
		
		return $token_no;
	}
    	
	
	public function newregister($fname,$lname,$passwrd,$email){
		try
		{							
			$password = md5($passwrd);
			$Stus='wating';
			$Tm=time();
			$token_no = md5(uniqid($Tm, true));
			$lst_sen=0;
			$profile_pic='';
			$verify=0;
			$uname=''.$fname.' '.$lname.'';
			
			$stmt = $this->conn->prepare("
						INSERT INTO users(
							user_name,first_name,last_name,password,email,created_at,last_seen,profile_pic,verify,token,token_type
						) 
						VALUES(
							:user_name,:first_name,:last_name,:password,:email,:created_at,:last_seen,:profile_pic,:verify,:token,:token_type
						)
			");
			
					$stmt->bindparam(":user_name",$uname);
					$stmt->bindparam(":first_name",$fname);
					$stmt->bindparam(":last_name",$lname);
					$stmt->bindparam(":password",$password);
					$stmt->bindparam(":email",$email);
					$stmt->bindparam(":created_at",$Tm);
			     	$stmt->bindparam(":last_seen",$lst_sen);
					$stmt->bindparam(":profile_pic",$profile_pic);
					$stmt->bindparam(":verify",$verify);
					$stmt->bindparam(":token",$token_no);
					$stmt->bindparam(":token_type",$Tm);

					$stmt->execute();	

					$Pt = "verify.php?user_mail=".$email."";	
            		echo '<script> window.location.href = "'.$Pt.'"; </script>';
					exit;
					
		}
		catch(PDOException $ex)
		{
			// echo $ex->getMessage();
		}
	}	
	

    public function get_login_data() {
        try{
            $id = $_SESSION['user_id'];
        	$stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id=:user_id");
			$stmt->execute(array(":user_id"=>$id));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			return (object)$userRow;
        }
		catch(PDOException $ex)
		{
			
		}
    }
    
    public function email_exist($email) {
        try{
            $email = $email;
        	$stmt = $this->conn->prepare("SELECT email FROM users WHERE email=:email");
			$stmt->execute(array(":email"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			return (object)$userRow;
        }
		catch(PDOException $ex)
		{
			
		}
    }
	
	public function login($email,$upass){
		try{
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE email=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

			if($stmt->rowCount() == 1){
				if($userRow['verify']==1){
					if($userRow['password']== md5($upass)){
							$user_id_db	 = $userRow['user_id'];
							$cookie_name = $userRow['email'];

							$cookie=str_replace(".","_",$cookie_name);
							$cookier = $_COOKIE[$cookie];
			
							$stmt1 = $this->conn->prepare("SELECT * FROM security_2fa WHERE device_cookies=:user_id");
							$stmt1->execute(array(":user_id"=>$cookier));
							$userRow1=$stmt1->fetch(PDO::FETCH_ASSOC);
							if($stmt1->rowCount() == 1){
								$stmt = $this->conn->prepare("UPDATE security_2fa SET login = '1' WHERE device_cookies=:user_id");
								$stmt->execute(array(":user_id"=>$cookier));
								

								    
									$_SESSION['user_id'] 	 			=  $userRow['user_id'];
									$_SESSION['first_name']       		=  $userRow['first_name'];
									$_SESSION['user_name']       		=  $userRow['user_name'];
									$_SESSION['email']    	 			=  $userRow['email'];
									$_SESSION['status']      			=  $userRow['status'];
									$_SESSION['last_seen']      		=  $userRow['last_seen'];
									$_SESSION['profile_pic']      		=  $userRow['profile_pic'];	
									$_SESSION['cover_image']      		=  $userRow['cover_image'];	
                                    $_SESSION['IdSer'] = $userRow['user_unq'];	
                                    
											
                                    
											
											
								 return true;
							}
							else{
							

							
								$cookie_value = uniqid($cookie_name,true).'-'.uniqid(time(),true);
								setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
							
								$OTP = uniqid(); $Tm=time(); $Fil=0;
								$token_no = md5(uniqid($Tm, true));

								$stmt = $this->conn->prepare("
									INSERT INTO security_2fa(
										device_cookies,user_id,login,2fa_status,code,token,created
									) 
									VALUES(
										:device_cookies,:user_id,:login,:2fa_status,:code,:token,:created
									)
								");

								$stmt->bindparam(":device_cookies",$cookie_name);
								$stmt->bindparam(":user_id",$user_id_db);
								$stmt->bindparam(":login",$Fil);
								$stmt->bindparam(":2fa_status",$Fil);
								$stmt->bindparam(":code",$OTP);
								$stmt->bindparam(":token",$token_no);
								$stmt->bindparam(":created",$Tm);
								$stmt->execute();	


								
							
								

							}
					}
					else
					{
						header("Location: login.php?error=".md5($upass)."");
						exit;
					}
				}
				else
				{
					header("Location: login.php?error=account");
					exit;
				}	
			}
			else
			{
				 // header("Location: login.php?error=found");
				 // exit;
				 session_destroy();
				 echo 'Error <br>';
			}		
		}
		catch(PDOException $ex)
		{
			
		}
	}
	
	
	public function newlogin($email,$upass){
		try{
			$stmt = $this->conn->prepare("SELECT * FROM users WHERE email=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1){
			    if($userRow['delete_status']==0){
    				if($userRow['verify']==1){
    					if($userRow['password']== md5($upass)){
    						$_SESSION['user_id'] 	 			=  $userRow['user_id'];
    						$_SESSION['first_name']       		=  $userRow['first_name'];
    						$_SESSION['user_name']       		=  $userRow['user_name'];
    						$_SESSION['email']    	 			=  $userRow['email'];
    						$_SESSION['status']      			=  $userRow['status'];
    						$_SESSION['last_seen']      		=  $userRow['last_seen'];
    						$_SESSION['profile_pic']      		=  $userRow['profile_pic'];	
    						$_SESSION['cover_image']      		=  $userRow['cover_image'];	
    						$_SESSION['IdSer']					=  $userRow['user_unq'];	
    						$_SESSION['admin_control']      	=  $userRow['admin_control'];
    						$_SESSION['reg_type']      	        =  $userRow['reg_type'];
    						return true;
    					}
    					else
    					{
    						$Pt = SITE_URL.'index.php?error=password';	
    						echo '<script> window.location.href = "'.$Pt.'"; </script>';
    						exit;
    					}
    				}else{
    						$Pt = SITE_URL.'index.php?error=verify';	
    						echo '<script> window.location.href = "'.$Pt.'"; </script>';
    						exit;
    				}
			    }else{
			        $Pt = SITE_URL.'index.php?error=account-deleted';	
					echo '<script> window.location.href = "'.$Pt.'"; </script>';
					exit;
			    }
			}
			else
			{
						$Pt = SITE_URL.'index.php?error=not-exit';	
						echo '<script> window.location.href = "'.$Pt.'"; </script>';
						exit;
			}
		}
		catch(PDOException $ex)
		{
			
		}
	}
	
	public function is_logged_in(){
		if(isset($_SESSION['user_id']))
		{
			return true;
		}
	}

	public function is_admin(){
		if(isset($_SESSION['admin_id']))
		{
			return true;
		}
	//	if($this->get_login_data()->user_type=='2')
		  //  return true;
	}
	
	public function redirect($url){
		header("Location: $url");
	}
	
	public function logout(){
		//session_destroy();
		//$_SESSION['user_id'] = false;
		session_start();
	    $stmt = $this->conn->prepare("UPDATE security_2fa SET login='0' WHERE device_cookies=:device_cookies");
	    $em = str_replace(".","_",$_SESSION['email']); 
	    $stmt->bindparam(":device_cookies",$_COOKIE[$em]);
		$stmt->execute();
		
		session_destroy();
		$_SESSION['user_id'] = false;
		$_SESSION['IdSer'] = false;
		//$this->redirect(SITE_URL);
	}

    /* user profile section start */
    public function change_password($id, $pass) {
        $query = "UPDATE users SET password=:pass WHERE user_id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":id",$id);
        $stmt->bindparam(":pass", md5($pass));
        //$stmt->bindparam(":opass", md5($opass));
        $res = $stmt->execute();
        if($res)
            return 'Password Changed, successfully.'; 
        else
            return 'Some error occurs.'; 

    }

    public function update_profile($id, $name, $mobile, $tel_id, $img) {
        if($img=='')
            $query = "UPDATE users SET user_name=:name,mobile=:mobile,telegram_id=:tel_id WHERE user_id=:id";
        else
            $query = "UPDATE users SET user_name=:name,mobile=:mobile,telegram_id=:tel_id,profile_pic=:img WHERE user_id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindparam(":id",$id);
        $stmt->bindparam(":name",$name);
        $stmt->bindparam(":mobile",$mobile);
        $stmt->bindparam(":tel_id",$tel_id);
        $stmt->bindparam(":img",$img);
        $res = $stmt->execute();
        if($res)
            return "Profile updated successfully.";
    }
    /* user profile section end */


    /* logo section start */
    //$user_home->logoByName('main_logo');
	public function update_logos($img1, $img2){
	    //main_logo for $img1
	    //dash_logo for $img2
	    $a = $this->update_logo('main_logo', $img1);
	    $b = $this->update_logo('dash_logo', $img2);
	    if($a && $b)
	        return $a;
	}
	
	public function update_logo($name, $img){
	    $stmt = $this->conn->prepare("UPDATE logos SET logo_img=:img WHERE logo_name=:name");
        $stmt->bindparam(":name",$name);
        //$stmt->bindparam(":dir",$dir);
        $stmt->bindparam(":img",$img);
		$res = $stmt->execute();
		if($res)
            return 'Logo updated.'; 
        else
            return 'Some error occurs.'; 
	}
	public function full_img_path($name) {
        $data = $this->fetch_logos($name);
        return $data['logo_dir'].$data['logo_img'];
	}
	public function logoByName($name) {
        $data = $this->fetch_logos($name);
        return $data['logo_img'];
	}
	public function fetch_logos($name) {
	    $stmt = $this->conn->prepare("SELECT * FROM logos WHERE logo_name=:name");
        $stmt->bindparam(":name",$name);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
	}
	/* logo section end */


    /* contents section start */
	public function add_content($page, $heading, $desc){
	    $stmt = $this->conn->prepare("INSERT INTO page_contents(content_heading,content_desc,content_page) VALUES(:heading,:desc,:page)");
        $stmt->bindparam(":page",$page);
        $stmt->bindparam(":desc",$desc);
        $stmt->bindparam(":heading",$heading);
		return $stmt->execute();
	}

	public function update_content($id, $heading, $desc){
	    $stmt = $this->conn->prepare("UPDATE page_contents SET content_heading=:heading,content_desc=:desc WHERE content_id=:id");
        $stmt->bindparam(":id",$id);
        //$stmt->bindparam(":page",$page);
        $stmt->bindparam(":desc",$desc);
        $stmt->bindparam(":heading",$heading);
		$res = $stmt->execute();
		if($res)
            return 'Page contents updated.'; 
        else
            return 'Some error occurs.'; 
	}

	public function delete_content($id){
	    $stmt = $this->conn->prepare("DELETE page_contents WHERE content_id=:id) VALUES(:heading,:desc,:page)");
        $stmt->bindparam(":id",$id);
		return $stmt->execute();
	}
	
	public function fetch_content($page){
		try{
			$stmt = $this->conn->prepare("SELECT * FROM page_contents WHERE content_page=:page_name");
    		$stmt->execute(array(":page_name"=>$page));
			$pageRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1){
			    return $pageRow;
			}
			else
			{
				echo 'Error <br>';
			}		
		}
		catch(PDOException $ex)
		{
			
		}
	}

	public function show_content($page, $row1){
	    $rows = $this->fetch_content($page);
	    $row = 'content_'.$row1;
	    echo '<script>alert('.$row.')</script>';
	    return (isset($rows[$row]))?$rows[$row]:'';
	}
    /* contents section end */
	
	
    /* mail section start */
    
    
    
    
    
    
    
	function send_mail($to,$subject,$Hdr,$Msg,$name){		
	    
	$mail = new PHPMailer(true); 

    // $mail->SMTPDebug = 1;
    $mail->isSMTP();
    $mail->Host = 'mail.africafilmclub.com';
    $mail->SMTPAuth = true;        
    $mail->Username = 'info@africafilmclub.com';
    $mail->Password = '123456789';                           
    $mail->SMTPSecure = 'tsl';                            
    $mail->Port = 587;                                   
    $mail->setFrom('no-replay@africafilmclub.com', 'Africa Film Club');
    $mail->addAddress($to,$name);
    $mail->addReplyTo('replay@africafilmclub.com', 'Africa Film Club');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');
    // $mail->addAttachment('/var/tmp/file.tar.gz');

    $mail->isHTML(true);                                   
    $mail->Subject = $subject;
    $mail->Body = '<table style="width: 100%;max-width: 640px;"><tr><td><table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#32517c"> <tbody><tr><td valign="top" align="center"><table width="100" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr><td><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding-bottom:10px;padding-top:10px" width="100%" valign="middle" align="center"><div align="center"><img src=""/></div></td></tr></tbody></table></td></tr></tbody></table></td> </tr></tbody></table><table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff"><tbody><tr> <td valign="top" align="center"><table style="max-width:640px;width:100%;" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr><td style="padding:12px;" align="left">'.$subject.'</td></tr></tbody></table><table style="max-width:640px;width:100%;" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr><td style="padding:12px;" align="left">'.$Hdr.'</td></tr></tbody></table><table style="max-width:640px;width:100%;" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr><td style="padding:12px;" align="left">'.$Msg.'</td></tr></tbody></table></td></tr></tbody></table><table style="width:100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#32517c"><tbody><tr><td valign="top" align="center"><table style="width:100%;max-width:640px;" cellspacing="0" cellpadding="0" border="0" align="center">   <tbody><tr><td style="padding:5px"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="padding:2px;" valign="middle" align="left"><font style="font-size:12px;line-height:18px" face="Arial, sans-serif" color="#fff">Please do not reply to this email. Emails sent to this address will not be answered.<br>Copyright @ 2018 Africa Film Club<br> All rights reserved.</font></td></tr></tbody></table></td></tr></tbody></table></td> </tr></tbody></table></td> </tr></table>';
    	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    	$mail->send();
	}
	
	
	function reset_pass_mail($to,$subject,$Msg,$headers){		
	    
    	$mail = new PHPMailer(true); 
    
        // $mail->SMTPDebug = 1;
        $mail->isSMTP();
        $mail->Host = 'mail.africafilmclub.com';
        $mail->SMTPAuth = true;        
        $mail->Username = 'info@africafilmclub.com';
        $mail->Password = '123456789';                           
        $mail->SMTPSecure = 'tsl';                            
        $mail->Port = 587;                                   
        $mail->setFrom('no-replay@africafilmclub.com', 'Africa Film Club');
        $mail->addAddress($to);
        $mail->addReplyTo('replay@africafilmclub.com', 'Africa Film Club');

        $mail->isHTML(true);                                   
        $mail->Subject = $subject;
        $mail->Body = $Msg;
        	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        	$mail->send();
	}
	
	
	//ar
	function paginate($item_per_page, $current_page, $total_records, $total_pages, $page_url){
        $pagination = '';
        if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
            $pagination .= '<ul class="pagination">';
            
            $right_links    = $current_page + 3; 
            $previous       = $current_page - 2; //previous link 
            $next           = $current_page + 1; //next link
            $first_link     = true; //boolean var to decide our first link
            
            if($current_page > 1){
    			$previous_link = ($previous==0)?1:$previous;
                $pagination .= '<li class="first"><a href="'.$page_url.'?page=1" title="First">«</a></li>'; //first link
                $pagination .= '<li><a href="'.$page_url.'?page='.$previous_link.'" title="Previous"><</a></li>'; //previous link
                    for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                        if($i > 0){
                            $pagination .= '<li><a href="'.$page_url.'?page='.$i.'">'.$i.'</a></li>';
                        }
                    }   
                $first_link = false; //set first link to false
            }
            
            if($first_link){ //if current active page is first link
                $pagination .= '<li class="first active">'.$current_page.'</li>';
            }elseif($current_page == $total_pages){ //if it's the last active link
                $pagination .= '<li class="last active">'.$current_page.'</li>';
            }else{ //regular current link
                $pagination .= '<li class="active">'.$current_page.'</li>';
            }
                    
            for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
                if($i<=$total_pages){
                    $pagination .= '<li><a href="'.$page_url.'?page='.$i.'">'.$i.'</a></li>';
                }
            }
            if($current_page < $total_pages){ 
    				$next_link = ($i > $total_pages)? $total_pages : $i;
                    $pagination .= '<li><a href="'.$page_url.'?page='.$next_link.'" >></a></li>'; //next link
                    $pagination .= '<li class="last"><a href="'.$page_url.'?page='.$total_pages.'" title="Last">»</a></li>'; //last link
            }
            
            $pagination .= '</ul>'; 
        }
        return $pagination; //return pagination links
    }
    
    
    function filter_paginate($item_per_page, $current_page, $total_records, $total_pages, $page_url){
        $pagination = '';
        if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
            $pagination .= '<ul class="pagination">';
            
            $right_links    = $current_page + 3; 
            $previous       = $current_page - 2; //previous link 
            $next           = $current_page + 1; //next link
            $first_link     = true; //boolean var to decide our first link
            
            if($current_page > 1){
    			$previous_link = ($previous==0)?1:$previous;
                $pagination .= '<li class="first"><a href="'.$page_url.'?fllter_player=1" title="First">«</a></li>'; //first link
                $pagination .= '<li><a href="'.$page_url.'?fllter_player='.$previous_link.'" title="Previous"><</a></li>'; //previous link
                    for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                        if($i > 0){
                            $pagination .= '<li><a href="'.$page_url.'?fllter_player='.$i.'">'.$i.'</a></li>';
                        }
                    }   
                $first_link = false; //set first link to false
            }
            
            if($first_link){ //if current active page is first link
                $pagination .= '<li class="first active">'.$current_page.'</li>';
            }elseif($current_page == $total_pages){ //if it's the last active link
                $pagination .= '<li class="last active">'.$current_page.'</li>';
            }else{ //regular current link
                $pagination .= '<li class="active">'.$current_page.'</li>';
            }
                    
            for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
                if($i<=$total_pages){
                    $pagination .= '<li><a href="'.$page_url.'?fllter_player='.$i.'">'.$i.'</a></li>';
                }
            }
            if($current_page < $total_pages){ 
    				$next_link = ($i > $total_pages)? $total_pages : $i;
                    $pagination .= '<li><a href="'.$page_url.'?fllter_player='.$next_link.'" >></a></li>'; //next link
                    $pagination .= '<li class="last"><a href="'.$page_url.'?fllter_player='.$total_pages.'" title="Last">»</a></li>'; //last link
            }
            
            $pagination .= '</ul>'; 
        }
        return $pagination; //return pagination links
    }
    
    
    
    function paginate_filter_in_same_page_scripts($item_per_page, $current_page, $total_records, $total_pages, $page_all){
        
        /*echo "<pre>";
        print_r($page_all);
        echo "</pre>";*/

        
        $page_url = '';
        foreach($page_all as $k => $v){
            if(is_array($v)){
                $push='';
                foreach($v as $ya => $x){
                   $page_url.='genre[]='.$x.'&';
                }
            }
            else{
              if($k != 'page') $page_url.="$k=$v&";  
            } 
        }
        
        // $page_url = rtrim($page_url,"&");
        
         $page_url = '/scripts?'.$page_url;
        
        $pagination = '';
        if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
            $pagination .= '<ul class="pagination">';
            
            $right_links    = $current_page + 3; 
            $previous       = $current_page - 2; //previous link 
            $next           = $current_page + 1; //next link
            $first_link     = true; //boolean var to decide our first link
            
            if($current_page > 1){
    			$previous_link = ($previous==0)?1:$previous;
                $pagination .= '<li class="first"><a href="'.$page_url.'page=1" title="First">«</a></li>'; //first link
                $pagination .= '<li><a href="'.$page_url.'page='.$previous_link.'" title="Previous"><</a></li>'; //previous link
                    for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                        if($i > 0){
                            $pagination .= '<li><a href="'.$page_url.'page='.$i.'">'.$i.'</a></li>';
                        }
                    }   
                $first_link = false; //set first link to false
            }
            
            if($first_link){ //if current active page is first link
                $pagination .= '<li class="first active">'.$current_page.'</li>';
            }elseif($current_page == $total_pages){ //if it's the last active link
                $pagination .= '<li class="last active">'.$current_page.'</li>';
            }else{ //regular current link
                $pagination .= '<li class="active">'.$current_page.'</li>';
            }
                    
            for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
                if($i<=$total_pages){
                    $pagination .= '<li><a href="'.$page_url.'page='.$i.'">'.$i.'</a></li>';
                }
            }
            if($current_page < $total_pages){ 
    				$next_link = ($i > $total_pages)? $total_pages : $i;
                    $pagination .= '<li><a href="'.$page_url.'page='.$next_link.'" >></a></li>'; //next link
                    $pagination .= '<li class="last"><a href="'.$page_url.'page='.$total_pages.'" title="Last">»</a></li>'; //last link
            }
            
            $pagination .= '</ul>'; 
        }
        return $pagination; //return pagination links
    }
    
    
    function paginate_filter_in_same_page_jobs($item_per_page, $current_page, $total_records, $total_pages, $page_all){
        
        /*echo "<pre>";
        print_r($page_all);
        echo "</pre>";*/

        
        $page_url = '';
        foreach($page_all as $k => $v){
            if(is_array($v)){
                $push='';
                foreach($v as $ya => $x){
                   $page_url.='location[]='.$x.'&';
                }
            }
            else{
              if($k != 'page') $page_url.="$k=$v&";  
            } 
        }
        
        // $page_url = rtrim($page_url,"&");
        
        $page_url = '/jobs?'.$page_url;
        
          
        
        $pagination = '';
        if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
            $pagination .= '<ul class="pagination">';
            
            $right_links    = $current_page + 3; 
            $previous       = $current_page - 2; //previous link 
            $next           = $current_page + 1; //next link
            $first_link     = true; //boolean var to decide our first link
            
            if($current_page > 1){
    			$previous_link = ($previous==0)?1:$previous;
                $pagination .= '<li class="first"><a href="'.$page_url.'page=1" title="First">«</a></li>'; //first link
                $pagination .= '<li><a href="'.$page_url.'page='.$previous_link.'" title="Previous"><</a></li>'; //previous link
                    for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                        if($i > 0){
                            $pagination .= '<li><a href="'.$page_url.'page='.$i.'">'.$i.'</a></li>';
                        }
                    }   
                $first_link = false; //set first link to false
            }
            
            if($first_link){ //if current active page is first link
                $pagination .= '<li class="first active">'.$current_page.'</li>';
            }elseif($current_page == $total_pages){ //if it's the last active link
                $pagination .= '<li class="last active">'.$current_page.'</li>';
            }else{ //regular current link
                $pagination .= '<li class="active">'.$current_page.'</li>';
            }
                    
            for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
                if($i<=$total_pages){
                    $pagination .= '<li><a href="'.$page_url.'page='.$i.'">'.$i.'</a></li>';
                }
            }
            if($current_page < $total_pages){ 
    				$next_link = ($i > $total_pages)? $total_pages : $i;
                    $pagination .= '<li><a href="'.$page_url.'page='.$next_link.'" >></a></li>'; //next link
                    $pagination .= '<li class="last"><a href="'.$page_url.'page='.$total_pages.'" title="Last">»</a></li>'; //last link
            }
            
            $pagination .= '</ul>'; 
        }
        return $pagination; //return pagination links
    }
    
    function paginate_filter_in_same_page_support($item_per_page, $current_page, $total_records, $total_pages, $page_all){
        
        /*echo "<pre>";
        print_r($page_all);
        echo "</pre>";*/

        
        $page_url = '';
        foreach($page_all as $k => $v){
            if(is_array($v)){
                $push='';
                foreach($v as $ya => $x){
                   $page_url.='location[]='.$x.'&';
                }
            }
            else{
              if($k != 'page') $page_url.="$k=$v&";  
            } 
        }
        
        // $page_url = rtrim($page_url,"&");
        
        $page_url = '/support?'.$page_url;
        
          
        
        $pagination = '';
        if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
            $pagination .= '<ul class="pagination">';
            
            $right_links    = $current_page + 3; 
            $previous       = $current_page - 2; //previous link 
            $next           = $current_page + 1; //next link
            $first_link     = true; //boolean var to decide our first link
            
            if($current_page > 1){
    			$previous_link = ($previous==0)?1:$previous;
                $pagination .= '<li class="first"><a href="'.$page_url.'page=1" title="First">«</a></li>'; //first link
                $pagination .= '<li><a href="'.$page_url.'page='.$previous_link.'" title="Previous"><</a></li>'; //previous link
                    for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                        if($i > 0){
                            $pagination .= '<li><a href="'.$page_url.'page='.$i.'">'.$i.'</a></li>';
                        }
                    }   
                $first_link = false; //set first link to false
            }
            
            if($first_link){ //if current active page is first link
                $pagination .= '<li class="first active">'.$current_page.'</li>';
            }elseif($current_page == $total_pages){ //if it's the last active link
                $pagination .= '<li class="last active">'.$current_page.'</li>';
            }else{ //regular current link
                $pagination .= '<li class="active">'.$current_page.'</li>';
            }
                    
            for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
                if($i<=$total_pages){
                    $pagination .= '<li><a href="'.$page_url.'page='.$i.'">'.$i.'</a></li>';
                }
            }
            if($current_page < $total_pages){ 
    				$next_link = ($i > $total_pages)? $total_pages : $i;
                    $pagination .= '<li><a href="'.$page_url.'page='.$next_link.'" >></a></li>'; //next link
                    $pagination .= '<li class="last"><a href="'.$page_url.'page='.$total_pages.'" title="Last">»</a></li>'; //last link
            }
            
            $pagination .= '</ul>'; 
        }
        return $pagination; //return pagination links
    }
    
	function pagination_style(){
    	echo "<style>
            .pagination {
            margin: 10px 0 30px;
            padding: 0;
            }
            .pagination {
            margin: 10px 0 30px;
            padding: 0 ;
            }
            .pagination li {
            background: transparent;
            border: 2px solid #336699 ;
            border-radius: 5px ;
            font-family: 'Chivo',sans-serif;
            font-size: 14px ;
            margin: 0 2px ;
            padding: 6px 15px;
            }
            .pagination li a {
            color: #336699 !important;
            }
            .pagination li:hover {
            background: #336699;
            }
            .pagination li:hover a{
            background: #336699; color: #fff !important;
            }
            .pagination li.first {
              color: #336699;
              padding: 6px 15px;
            }
            .pagination li.first:hover {
            color: #fff;
            }
         
        </style>";
        
        
        
        
        
	}
	
	
	
	function generate_unique_username($string_name, $rand_no){
    	while(true){
    		$username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
    		$username_parts = array_slice($username_parts, 0, 2); //return only first two arry part
    	
    		$part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):""; //cut first name to 8 letters
    		$part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):""; //cut second name to 5 letters
    		$part3 = ($rand_no)?rand(0, $rand_no):"";
    		
    		$username = $part1. str_shuffle($part2). $part3; //str_shuffle to randomly shuffle all characters 
    
    	    //echo	$username;
    	   
    	    $sql = "SELECT user_id,user_unq FROM users WHERE `user_unq` = '$username'  ";

    	    $stmt = $this->conn->prepare($sql);
           
    		
    		if($stmt->execute()){
    		    

    			if($stmt->rowCount() == 1){
    		        echo '<script> window.location.href = "'.SITE_URL.'";   </script>';
    			}else{
    			    $user_id = $_SESSION['user_id'];
    	    
    			    /*$sql2 = "SELECT user_id,user_unq FROM users WHERE `user_id` = $user_id  ";
    			    $stmt2 = $this->conn->prepare($sql2);
    			    if($stmt2->execute()){
                        $userRow = $stmt2->fetch(PDO::FETCH_ASSOC);
    			    }*/
    	
    		        $stmt3 = $this->conn->prepare("UPDATE users SET user_unq= '$username'  WHERE `user_id` = $user_id ");
    		        if($stmt3->execute()){
                        $_SESSION['IdSer'] = $username;
                        return $username;
                    }else{
                        echo '<script> window.location.href = "'.SITE_URL.'";   </script>';
                    }
    
    			}
   
    		}else{
    		     echo '<script> window.location.href = "'.SITE_URL.'";   </script>';
    		}

    	}
    }
	

}