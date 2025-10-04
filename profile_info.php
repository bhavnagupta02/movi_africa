<?php 

include 'header.php';
   
    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    
        $reg_type = $_SESSION['reg_type'];

        $user_unq =$_GET['id'];
        $stmt= $user_home->runQuery("SELECT user_name,profile_pic,cover_image,user_unq,date_of_birth,gender,about_me,email, 	facebook_username,tweeter_username,instagram_username FROM users WHERE user_unq=:user_unq");
        $stmt->execute(array(":user_unq"=>$user_unq));
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

      
  	    echo '<title>'.$userRow['user_name'].' - Profile </title>';
		if(isset($_POST['submit_frnd'])){
			$status=2;
			$unfriend = $user_home->runQuery("UPDATE friends SET status=:status WHERE (f_unique=:f_unique AND t_unique=:t_unique) OR (t_unique=:t_uniques AND f_unique=:f_uniques)");
			$unfriend->bindParam(':status',$status);
			$unfriend->bindParam(':f_unique',$_SESSION['IdSer']);
			$unfriend->bindParam(':t_unique',$user_unq);
			$unfriend->bindParam(':t_uniques',$_SESSION['IdSer']);
			$unfriend->bindParam(':f_uniques',$user_unq);
			$unfriend->execute();
        }
 
		if(isset($_POST['submit_request'])){
		
		
	
		
				$stmt = $user_home->runQuery("SELECT f_unique,t_unique,status FROM friends WHERE (f_unique=:f_unique AND t_unique=:t_unique) OR (t_unique=:t_uniques AND f_unique=:f_uniques)");
					$stmt->bindParam(':f_unique',$_SESSION['IdSer']);
					$stmt->bindParam(':t_unique',$user_unq);
					$stmt->bindParam(':t_uniques',$_SESSION['IdSer']);
					$stmt->bindParam(':f_uniques',$user_unq);
					$stmt->execute();
				if($stmt->rowCount() == 1){
	
					$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
					
					if($userRow['f_unique'] == $_SESSION['IdSer']){
						$fun = $userRow['f_unique'];
						$tun = $userRow['t_unique'];
					}else{
						$fun = $userRow['t_unique'];
						$tun = $userRow['f_unique'];
					}
					
							
					$status=0;$time=time();
					$unfriend = $user_home->runQuery("UPDATE friends SET status=:status,time=:time,f_unique=:f_un,t_unique=:t_un WHERE (f_unique=:f_unique AND t_unique=:t_unique) OR (t_unique=:t_uniques AND f_unique=:f_uniques)");
					$unfriend->bindParam(':status',$status);
					$unfriend->bindParam(':time',$time);
					$unfriend->bindParam(':f_un',$fun);
					$unfriend->bindParam(':t_un',$tun);
					$unfriend->bindParam(':f_unique',$_SESSION['IdSer']);
					$unfriend->bindParam(':t_unique',$user_unq);
					$unfriend->bindParam(':t_uniques',$_SESSION['IdSer']);
					$unfriend->bindParam(':f_uniques',$user_unq);
					$unfriend->execute();
				}
				else{
					$time=time();
					$send_request = $user_home->runQuery("INSERT INTO friends(f_unique,t_unique,time) VALUES (:f_unique,:t_unique,:time)");
					$send_request->bindParam(':f_unique',$_SESSION['IdSer']);
					$send_request->bindParam(':t_unique',$user_unq);      
					$send_request->bindParam(':time',$time);                     
					$send_request->execute();
					
				}
			
        }
								
		if(isset($_POST['cancel_request'])){
			$cancel = $user_home->runQuery("DELETE FROM friends WHERE (f_unique=:f_unique AND t_unique=:t_unique) OR (t_unique=:t_uniques AND f_unique=:f_uniques)");
            $cancel->bindParam(':f_unique',$_SESSION['IdSer']);
            $cancel->bindParam(':t_unique',$user_unq);
            $cancel->bindParam(':t_uniques',$_SESSION['IdSer']);
            $cancel->bindParam(':f_uniques',$user_unq);
            $cancel->execute();
			
			
			
			
        }
		
		if(isset($_POST['not_accept'])){
			$delete = $user_home->runQuery("DELETE FROM friends WHERE (f_unique=:f_unique AND t_unique=:t_unique) OR (t_unique=:t_uniques AND f_unique=:f_uniques)");
            $delete->bindParam(':f_unique',$_SESSION['IdSer']);
            $delete->bindParam(':t_unique',$user_unq);
            $delete->bindParam(':t_uniques',$_SESSION['IdSer']);
            $delete->bindParam(':f_uniques',$user_unq);
            $delete->execute();
        }                    
      
		if(isset($_POST['accepted'])){
            $status=1;
			$accept = $user_home->runQuery("UPDATE friends SET status=:status WHERE (f_unique=:f_unique AND t_unique=:t_unique) OR (t_unique=:t_uniques AND f_unique=:f_uniques)");
			$accept->bindParam(':status',$status);
			$accept->bindParam(':f_unique',$_SESSION['IdSer']);
			$accept->bindParam(':t_unique',$user_unq);
			$accept->bindParam(':t_uniques',$_SESSION['IdSer']);
			$accept->bindParam(':f_uniques',$user_unq);
			$accept->execute();
                                  
			$time=time();$type='request';$read_by=0;
			$send_request = $user_home->runQuery("INSERT INTO noticefication(t_id,f_id,n_tm,type,read_by) VALUES (:t_id,:f_id,:n_tm,:type,:read_by)");
			$send_request->bindParam(':t_id',$_SESSION['IdSer']);
			$send_request->bindParam(':f_id',$user_unq);      
			$send_request->bindParam(':n_tm',$time);                     
			$send_request->bindParam(':type',$type);                     
			$send_request->bindParam(':read_by',$read_by);                     
			$send_request->execute();
		} 
      
      echo $BY;
                            
?>

</head>
	<body>
	 <!--   <div id="Profile-afc">
			<?php /*
				echo '<div id="ProfileTp" style="background-image:url(\''.((isset($userRow['cover_image']) &&  !($userRow['cover_image']=="")) ? SITE_URL.'  /'.$userRow['cover_image'] : '').'\');height:305px;position: relative;">
				<div style="position: absolute;background:rgba(30, 29, 29, 0.33);left: 0;right: 0;top: 0;bottom: 0;z-index: 1;"></div>'.((isset($userRow['profile_pic']) && !($userRow['profile_pic']=="")) ?  '<span class="avatar avatar-160x160" style="box-shadow: 0px 0px 12px #fff;background-image:url(\''.SITE_URL.'profile_pic_image/'.$userRow['profile_pic'].'\')"></span>' : '<a><span class="avatar avatar-160x160" style="background-color: #fff;background-image:url(\'https://vignette.wikia.nocookie.net/bungostraydogs/images/1/1e/Profile-icon-9.png\')"></span></a>').'<span class="avatar-name">'.$userRow['user_name'].'</span>';		

				echo ($userRow['position']) ? '<span class="avatar-briefcase"><i class="fa fa-briefcase"></i>'.$userRow['position'].'</span>' : '';
				
					
			  if($user_home->is_logged_in()){
					if($_SESSION['IdSer'] == $_GET['id']){
						echo '<form method="GET" action="profile-edit"><input type="submit" class="button-pink" value="Edit Profile"/> <i class="fa fa-pencil"></i></form>';
					}
					else{
						echo '<div style="display:block;">';	
							$stmt = $user_home->runQuery("SELECT * FROM friends WHERE (f_unique=:f_unique AND t_unique=:t_unique) OR (t_unique=:t_uniques AND f_unique=:f_uniques)");
							$stmt->execute(array(":f_unique"=>$_GET['id'],":t_unique"=>$_SESSION['IdSer'],":t_uniques"=>$_GET['id'],":f_uniques"=>$_SESSION['IdSer']));
							$userRowsss=$stmt->fetch(PDO::FETCH_ASSOC);
							if($stmt->rowCount() == 1){
								if($userRowsss['status'] == '1'){
									echo '<form method="GET" action="message.php"><input type="hidden" name="to" value="'.$userRow['user_unq'].'"/><input type="submit" class="button-pink" value="Send Message"/> <i class="fa fa-envelope"></i></form>';
									
									echo '<form method="POST"><input type="submit" style="text-transform:capitalize;" name="submit_frnd" value="cancel connection"><i class="fa fa-exclamation-triangle"></i></form>';
								
									if($userRowsss['noti'] == 0 && $userRowsss['t_unique'] == $_GET['id']){
										$noti=1;$type='request';$f_id=$_SESSION['IdSer'];$t_id=$_GET['id'];
										$stmt = $user_home->runQuery("UPDATE friends SET noti=:noti WHERE frnd_id=:frnd_id");	
										$stmt->execute(array(":noti"=>$noti,":frnd_id"=>$userRowsss['frnd_id']));
										$stmt = $user_home->runQuery("UPDATE noticefication SET read_by=:read_by WHERE type=:type AND t_id=:t_id AND f_id=:f_id");
										$stmt->execute(array(":read_by"=>$noti,":type"=>$type,":t_id"=>$userRowsss['t_unique'],":f_id"=>$_SESSION['IdSer']));
									}
								}
								else if($userRowsss['status'] == '2'){
									echo '<form method="POST"><input type="submit" name="submit_request" value="Send Request"><i class="fa fa-paper-plane"></i></form>';
								}
								else{
									if($userRowsss['f_unique'] == $_SESSION['IdSer']){
											echo '<form method="POST"><input type="submit" name="cancel_request" value="Cancel Request"><i class="fa fa-times"></i></form>';
									}
									else{
										echo '<form method="POST"><input style="text-transform:capitalize;" type="submit" name="not_accept" value="Ignore"><i class="fa fa-times"></i></form>';	
										echo '<form method="POST"><input style="text-transform:capitalize;" type="submit" name="accepted" value="Accept"><i class="fa fa-check"></i></form>';	
									}	
								}	
							}
							else{
									echo '<form method="POST"><input type="submit" name="submit_request" value="Send Request"><i class="fa fa-paper-plane"></i></form>';
                                    
							}
						echo '</div>';	
					}
			  }	
            ?>	
					
			</div>
			<div id="ProfileBtm">	
				
				<div id="ProfileBtmB">
					<div class="RwBxr" style="margin:10px 0 0;"> 
        				<div class="RwBxr-65"> 
        					 <div class="ResBxr">
        					 	 <h2>About Me</h2> 
                                    <div style="overflow:hidden;">    
        								<div id="LabFr"> 
        									<?php 
        									function ChangeDOB($a){
        										$Mnt = array(
        											'01'=>'January',
        											'02'=>'February',
        											'03'=>'March',
        											'04'=>'April',
        											'05'=>'May',
        											'06'=>'June',
        											'07'=>'July ',
        											'08'=>'August',
        											'09'=>'September',
        											'10'=>'October',
        											'11'=>'November',
        											'12'=>'December',
        										);
        										$B = explode("-",$a);
        										//echo '<div>DOB: <b>'.$B[2].'-'.$Mnt[$B[1]].'-'.$B[0].'</b></div>';	
        										echo $B[2].'-'.$Mnt[$B[1]].'-'.$B[0];	
        									}
        										
        									echo (($userRow['date_of_birth'] != '0000-00-00') ? ' '.ChangeDOB($userRow['date_of_birth']) : '').'';
        										
        									if($userRow['gender'] == '1'){
        										echo '<div><i class="fa fa-mars" aria-hidden="true"></i>Gender: <b>Male</b></div>';
        									}
        									else if( $userRow['gender'] == '2'){
        										echo '<div><i class="fa fa-venus" aria-hidden="true"></i>Gender: <b>Female</b></div>';
        									}
                                            ?>  
        								</div>
        							</div>		
        
        							<div style="padding: 5px;">		
        									<div>
        										<?php 
        											if($userRow['about_me'] != ''){
        												echo ''.$userRow['about_me'].'';
        											}
        											else{
        												if($_SESSION['IdSer'] == $_GET['id']){
        													echo '<h2 id="AbtRt">Write Something About YourSelf <a href="/edit-profile">Edit</a></h2>';
        												}
        												else{
        													
        												}
        											}
        										?>
        									</div>			
        							   </div>
        					 	   </div>
					           </div>		

					
					 	 <div class="RwBxr-35">
					 	  <div class="ResBxr"> 
					 	  	<h2>Contact</h2> 
					 	  	 <div id="CnTRx">
								
								
								<?php 
									echo '<div style="text-align:center;" id="CenterTxtNw">';	
									
									echo ( $userRow['email'] != '' ? '<div id="CenterTxtNws"><i class="fa fa-envelope-o" aria-hidden="true"></i><b>'.$userRow['email'].'</b></div>' : '');
									echo ($userRow['facebook_username'] != '' ? '<div><a id="face" href="'.$userRow['facebook_username'].'"><i class="fa fa-facebook"  aria-hidden="true"></i> <b>Follow Me On Facebook</b></a></div>' : '');
									echo ($userRow['tweeter_username'] != '' ? '<div><a id="eat" href="https://twitter.com/'.$userRow['tweeter_username'].'"><i  class="fa fa-twitter" aria-hidden="true"></i> <b>Follow Me On Twitter</b></a></div>' : '');
									echo ($userRow['instagram_username'] != '' ? '<div><a id="inst" href="https://www.instagram.com/'.$userRow['instagram_username'].'"><i  style="line-height: 28px;" class="fa fa-instagram" aria-hidden="true"></i> <b>Follow Me On Instagram</b></a></div>' : '');
								?>
								</div>
					 	  	</div> 
					 	</div> 
					</div>
					<div class="RwBxr"></div>	
			</div>
			
			
			<?php

				echo '<h2 class="recent_txt" style="margin: 10px 0;padding: 0;font-size: 15px;font-weight: 600;color: #666;text-transform: uppercase;">
						Recent Connections
					</h2>';
				
					$status='1';$user_unq =$_GET['id'];
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
			
					$lst = implode (",",$Ar);$Lf = rtrim($Dta,",");
					
					if($Lf){
						$user_unq =$_GET['id'];
						$stmt= $user_home->runQuery("SELECT * FROM users WHERE user_unq IN ($Lf) ORDER BY `users`.`created_at` DESC");
						$stmt->execute();
						$userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
					}
					
				echo '<div id="MyFilm" style="position:relative;width:100%;">';				
					$Cnt=0;
					if(!empty($userRow)){
						foreach($userRow as $val){
							if($Cnt < 6){
								$img='https://d4nl1s1t1bp20.cloudfront.net/160x160/ca86e800945bcbf0055d84319cbd1384.png';
							
								echo '<div class="MyFilm"><a href="/@'.$val['user_unq'].'"><div class="MyFilmT" style="background-image:url(\''.( $val['profile_pic'] ? 'profile_pic_image/'.$val['profile_pic'].'' : $img ).'\');"></div></a><div class="MyFilmB"><a href="/@'.$val['user_unq'].'">'.$val['user_name'].'</a></div></div>';
							}
							$Cnt++;	
						}
					}
					else{
						echo 'No connections available';	
					}
				
					if($Cnt == 0){
						if($_GET['id'] == $_SESSION['IdSer']){
							echo '<a class="view_text" style="position: absolute;top:-28px;right: 8px;text-decoration: none;color: #666;font-weight: 600;cursor: pointer;" href="/my-connections">View All Connections ('.$Cnt.')</a>';
						}	
						else{
							echo '<a class="view_text" style="position: absolute;top:-28px;right: 8px;text-decoration: none;color: #666;font-weight: 600;cursor: pointer;" href="/@'.$_GET['id'].'/connections">View All Connection ('.$Cnt.')</a>';
						}
					}	
					
				echo '</div><div style="clear:both;"></div>';
				
				
				echo '<h2 class="recent_txt" style="margin: 10px 0;padding: 0;font-size: 15px;font-weight: 600;color: #666;text-transform: uppercase;">
						Recent Projects
					</h2>';
				
				
					$ay='Complete';
					$stmt = $user_home->runQuery("
							SELECT 	
								f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
								f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
								f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total  
							FROM 
								films 
							WHERE 
								created_by=:created_by
							ORDER BY `created` DESC	
					");
					$stmt->execute(array(":created_by"=>$_GET['id']));
					$userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				
				echo '<div id="MyFilm" style="position:relative;width:100%;">';				
					$Cnt=0;
					if(!empty($userRow)){
						foreach($userRow as $val){
							if($Cnt < 6){
								$img='webimg/film-or-movie-camera-logo-design-vector-20451057.jpg';
							
								echo '<div class="MyFilm"><a href="/film/'.$val['url'].'"><div class="MyFilmT" style="background-image:url(\''.( $val['film_poster'] ? 'film_banner/'.$val['film_poster'].'' : $img ).'\');"></div></a><div class="MyFilmB"><a href="/film/'.$val['url'].'">'.$val['f_name'].'</a></div></div>';
							}
							$Cnt++;	
						}
					}
					else{
						echo 'No films available';	
					}
				    
					if($Cnt > 0){
						if($_GET['id'] == $_SESSION['IdSer']){
							echo '<a class="view_text" style="position: absolute;top:-28px;right: 8px;text-decoration: none;color: #666;font-weight: 600;cursor: pointer;" href="/@'.$_GET['id'].'/film">View My Projects ('.$Cnt.')</a>';
						}	
						else{
							echo '<a style="position: absolute;top:-28px;right: 8px;text-decoration: none;color: #666;font-weight: 600;cursor: pointer;" href="/@'.$_GET['id'].'/film">View My Projects ('.$Cnt.')</a>';
						}
					}	
				echo '</div>';
				
				*/
			?>
			
			
		</div>
	</div>		
	</div>-->
	
<?php 
    $user_unq =$_GET['id'];
    $stmt= $user_home->runQuery("SELECT occupation,user_name,country_id,profile_pic,cover_image,user_unq,date_of_birth,gender,about_me,email,facebook_username,tweeter_username,instagram_username FROM users WHERE user_unq=:user_unq");
    $stmt->execute(array(":user_unq"=>$user_unq));
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
    function ChangeDOB($a){
		$Mnt = array(
			'01'=>'January',
			'02'=>'February',
			'03'=>'March',
			'04'=>'April',
			'05'=>'May',
			'06'=>'June',
			'07'=>'July ',
			'08'=>'August',
			'09'=>'September',
			'10'=>'October',
			'11'=>'November',
			'12'=>'December',
		);
		$B = explode("-",$a);
		echo $B[2].'-'.$Mnt[$B[1]].'-'.$B[0];	
	}
?>
<div class="profile_information">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-9">
                    <div id="PostsBx">
                        <div class="inner-area">
                            <div class="col-sm-3 inner-left"> 
                                <?php 
                                if($userRow['profile_pic']!==""){  ?>
                                    <img id="get_img" src="/profile_pic_image/<?php echo $userRow['profile_pic']; ?>" alt="">
                    <?php       }else{
                                    echo'<img  id="get_img" src="/profile_pic_image/profile-default.png" alt="">';  
                                }
                                
                                ?>
                                
                            </div>
                            <div class="col-sm-9 inner-right">
                                <h3 id="name"> <?php echo $userRow['user_name']; ?></h3>
                                <div class="form-area">
                                <?php
                                if($user_home->is_logged_in()){
                					if($_SESSION['IdSer'] == $_GET['id']){
                						echo '<form method="GET" action="profile-edit">
                						<input type="submit" class="button-pink" value="Edit Profile"/> <i class="fa fa-pencil"></i>
                						</form>';
                						
                						if($reg_type=="email"){
                						
                						    echo '<div class="edit_pass button-pink"><a href="/profile-edit#change_password"><i class="fa fa-gear"></i> Account Settings</a></div>';
                					
                						}
                					    
                					    
                					}else{
                				    
                				    
                				    
                				    
                				    
            						echo '<div style="display:block;">';	
            							$stmt = $user_home->runQuery("SELECT * FROM friends WHERE (f_unique=:f_unique AND t_unique=:t_unique) OR (t_unique=:t_uniques AND f_unique=:f_uniques)");
            							$stmt->execute(array(":f_unique"=>$_GET['id'],":t_unique"=>$_SESSION['IdSer'],":t_uniques"=>$_GET['id'],":f_uniques"=>$_SESSION['IdSer']));
            							$userRowsss = $stmt->fetch(PDO::FETCH_ASSOC);

            					

            							if($stmt->rowCount() == 1){
            							    
            								if($userRowsss['status'] == '1'){
            									//echo '<form method="GET" action="message.php"><input type="hidden" name="to" value="'.$userRow['user_unq'].'"/><input type="submit" class="button-pink" value="Send Message"/> <i class="fa fa-envelope"></i></form>';

            								

            							if($userRowsss['msg']==""){
            								echo '<input type="hidden" name="to" id="to" value="'.$userRow['user_unq'].'"/><button type="button" class="button-pink" data-toggle="modal" id="send_first_mess" data-target="#myModal"><i class="fa fa-envelope"></i> Send Message</button>';

            							}else{
            								echo '<form method="GET" action="message.php"><input type="hidden" name="to" value="'.$userRow['user_unq'].'"/><input type="submit" class="button-pink" value="Send Message"/> <i class="fa fa-envelope"></i></form>';
            										}


            									
            									echo '<form method="POST"><input type="submit" style="text-transform:capitalize;" name="submit_frnd" value="cancel connection"><i class="fa fa-exclamation-triangle"></i></form>';
            								
            									if($userRowsss['noti'] == 0 && $userRowsss['t_unique'] == $_GET['id']){
            										$noti=1;$type='request';$f_id=$_SESSION['IdSer'];$t_id=$_GET['id'];
            										$stmt = $user_home->runQuery("UPDATE friends SET noti=:noti WHERE frnd_id=:frnd_id");	
            										$stmt->execute(array(":noti"=>$noti,":frnd_id"=>$userRowsss['frnd_id']));
            										$stmt = $user_home->runQuery("UPDATE noticefication SET read_by=:read_by WHERE type=:type AND t_id=:t_id AND f_id=:f_id");
            										$stmt->execute(array(":read_by"=>$noti,":type"=>$type,":t_id"=>$userRowsss['t_unique'],":f_id"=>$_SESSION['IdSer']));
            									}
            								}
            								else if($userRowsss['status'] == '2'){
            							    echo '<form method="POST"><input type="submit" name="submit_request" value="Send Request"><i class="fa fa-paper-plane"></i></form>';
            								}
            								else{
            									if($userRowsss['f_unique'] == $_SESSION['IdSer']){
            								echo '<form method="POST"><input type="submit" name="cancel_request" value="Cancel Request"><i class="fa fa-times"></i></form>';
            									}
            									else{
            										echo '<form method="POST"><input style="text-transform:capitalize;" type="submit" name="not_accept" value="Ignore"><i class="fa fa-times"></i></form>';	
            										echo '<form method="POST"><input style="text-transform:capitalize;" type="submit" name="accepted" value="Accept"><i class="fa fa-check"></i></form>';	
            									}	
            								}	
            							}
            							else{
            									echo '<form method="POST"><input type="submit" name="submit_request" value="Send Request"><i class="fa fa-paper-plane"></i></form>';
                                                
            							}
            						echo '</div>';	
            					}
                					
                					
                					
                					
                            }
                            ?>
                                </div>
                                
                                <ul class="Location">
                                    
                                    <!--<li><span>DOB : </span> <p> <?php	//echo (($userRow['date_of_birth'] != '0000-00-00') ? ' '.ChangeDOB($userRow['date_of_birth']) : '').'';  ?></p></li>-->
                                    <li><p id="occupation"> <?php $occupation = str_replace(',', ", ", $userRow['occupation']); 
                                    echo $occupation;  ?></p></li>
                                    <li><p> <?php echo $userRow['country_id'];  ?></p></li>
                                </ul>
                                <ul class="social">
                             
                                    <li><a href="<?php if($userRow['facebook_username']!==""){ echo "https://www.facebook.com/".$userRow['facebook_username']; }else{ echo "javascript:void(0);"; }?>"><i class="fa fa-facebook"></i> </a></li>
                                    <li><a href="<?php if($userRow['tweeter_username']!==""){ echo "https://www.twitter.com/".$userRow['tweeter_username']; }else{ echo "javascript:void(0);"; }?>"> <i class="fa fa-twitter"></i></a></li>
                                    <li><a href="<?php if($userRow['instagram_username']!==""){ echo "https://www.instagram.com/".$userRow['instagram_username']; }else{ echo "javascript:void(0);"; }?>"> <i class="fa fa-instagram"></i></a></li>
                                </ul>
                            </div>
                            <div class="inner-about">
                                    <p><span>About me : </span>  <?php echo $userRow['about_me'];  ?></p></div>
                        </div>
                          
                    </div>
                </div>
                <div class="col-lg-3">
                
                    <div id="Right-Side-Section">
                      
                       <h4> Latest Projects</h4>
                         <?php 
                           
        			            $stmt = $user_home->runQuery("
        			                SELECT
        			                    * 
        			                FROM 
        			                    films 
        			                WHERE created_by=:created_by
        			                ORDER BY id DESC LIMIT 5
        			             ");
        			            //$status = 0;
        			            //$stmt->execute();
        			            $stmt->execute(array(":created_by"=>$_GET['id']));
        			            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        			            
        			 ?>
                       <?php if(!empty($projects)){
                       ?>
                       
                        <ul id="Right-Side-Ajax">
                          
                            
                              <?php
        	                $i = 1;
        	                foreach($projects as $project){ 
        	                
        	                
        	                $film_name = $project['f_name'];
        	                $country = $project['f_cnty'];
        	                $language = str_replace(',', ", ", $project['f_lng']);
        	                $stage = $project['f_stg'];
        	                $genre = str_replace(',', ", ", $project['f_genre']);
        	                
        			    ?>
                        
                                <li>
                                    
                                     <a href="view-film.php?id=<?php echo $project['url']; ?>">
                                         <h3> <strong>Title</strong> : <?php echo $film_name; ?> </h3>
                                         <h3> <strong>Country </strong>:  <?php echo $country; ?> </h3>
                                         <h3><strong>Language </strong>: <?php echo $language; ?></h3>
                                         <h3><strong>Stage </strong>: <?php echo $stage; ?></h3>
                                         <h3><strong>Genre </strong>: <?php echo $genre; ?></h3>
                                         
                                     </a>
                                </li> 
                        <?php  } ?>       
                        </ul>
                        <?php }else{  ?> 
                        
                        	<div class="data_blank">			
                				<span  class="mess">Film Not Available</span>
                			</div>
                        
                       <?php } ?>
                    </div> 
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Send New Message</h4>
        </div>
        <div class="modal-body">
            <div id="msg_response"></div>
            
            <img id="put_img" src="" alt="">
            <h3 id="put_name"></h3>
            <p id="put_occupation"></p>
            <input type="hidden" name="to" value="" id="friend">
            <textarea id="msg"> </textarea>
            <button id="first_mess" class="" type="button"> Send Message</button>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>

  </div>
</div>



	<?php include 'footer.php';?>

<script>
function UpdateStatus(){

var t_unique = '<?php echo $unfrnd['t_unique'] ?>';

  $.ajax ({
      type: "POST",
      url:  'unfriend_ajax.php',
      data:  {t_unique:t_unique},
      dataType: 'json',
      success: function(data) {
            if(data==true){
                
                
            }
  },
  error: function(data) {
    console.log('Error: ' + data);
    return false;
  }
});
}

document.title = "<?php echo $_GET['id'];?> Profile Page";
</script>

<script>
// send first message put friend name

$("#send_first_mess").click(function(){
    var to = $("#to").val();
    $("#friend").val(to);
    var src1 = $('#get_img').prop('src');
    $("#put_img").attr("src", src1);
    
    var name = $("#name").text();
    var occupation = $("#occupation").text();
    //alert(name);
    
    $("#put_name").text(name);
    $("#put_occupation").text(occupation);
    
});


// send first message
$("#first_mess").click(function(){
    
    var to = $("#friend").val();
    var msg = $("#msg").val();
    var from = '<?php echo $_SESSION['IdSer']; ?>';
  

    $.ajax ({
        type: "POST",
        url:  'send_first_message.php',
        data:  {to:to,msg:msg,from:from,},
        dataType: 'json',
        success: function(data) {
    
            $("#msg").val('');
            if(data['data']=="yes"){
       
                $("#msg_response").text('Message send successfully');
                $("#msg_response").css({ 'color': 'green'});
                
                setTimeout(function(){
                 
                    window.location.href = '/profile_info.php?id=<?php echo $_GET['id']; ?>';
                }, 3000);
            }else{
                $("#msg_response").text('Please try again');
                $("#msg_response").css({ 'color': 'red'});  
            }
        },
        error: function(data) {
            
            console.log('Error');
            return false;
        }
    });
    
});

</script>



</body>

	
</html>