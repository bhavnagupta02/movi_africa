<?php include 'header.php';
{ 
    
    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    
    
    
?>
<style>
.directory {
    font-size:12px;
    color:#4f9fcf;
}  
</style>
<?php
    
	$industry_name = $_GET['id'];
	
	if($_GET['id'] != '' && $_GET['type'] == ''){

		$d=$_GET['id'];
		$e=$_GET['user'];
		
		$link="&id=$d&user=$e";	
		$result = $user_home->runQuery("
				SELECT 	
					f_name  
				FROM
					films 
				WHERE 
					f_genre LIKE CONCAT('%', :industry_name, '%')  AND created_by = :created_by
		");
		$result->execute(array(":industry_name"=>$industry_name,":created_by"=>$e));
		$RwCnt = $result->rowCount();
		
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
		
		$TotPage=intval($RwCnt/$PerPage);

				
				
				$stmt = $user_home->runQuery("
				SELECT 	
				f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
				f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
				f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
				FROM 
					films 
				WHERE 
					f_genre LIKE  CONCAT('%', :industry_name, '%') AND created_by = :created_by LIMIT $Start,$PerPage
					
			");

			$stmt->execute(array(":industry_name"=>$industry_name,":created_by"=>$e));
			$userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}	
	else if($_GET['type'] == 'filter'){
				
				$Nm = $_GET['OvrHnL'];
				$Fp = $_GET['FltSg'];
				$Sg = $_GET['OvrHnLsnd'];
				$Ov = $_GET['OvrHnR'];
			
			if($_GET['id'] != ''){
				$Gid=$_GET['id'];
				$user=$_GET['user'];
				$link="&user=$user&FltSg=$Fp&OvrHnL=$Nm&OvrHnLsnd=$Sg&OvrHnR=$Ov&type=filter&id=$Gid";
			}
			else{
				$user=$_GET['user'];
				$link="&user=$user&FltSg=$Fp&OvrHnL=$Nm&OvrHnLsnd=$Sg&OvrHnR=$Ov&type=filter";
			}
				
				$Ay = array(
					"Film Name"=>"f_name",
					"Country"=>"f_cnty",
					"Language"=>"f_lng",
					"Producer"=>"p_name",
					"Director"=>"d_name",
					"Writer"=>"w_name",
					"Actor"=>"a_name"
				);
				
				$D = array(":Ay"=>$_GET['OvrHnR'],":created_by"=>$_GET['user']);
			
			
			
			
				if($Fp == 2){
					$Fpw='AND film_premiere_date >= :film_premiere_date';
					$D[":film_premiere_date"] = $Date; 
				}
				else if($Fp == 3){
					$Fpw='';
				}
				$Date = date("Y-m-d H:i:s");

			
					if($Sg == 'All'){
						$Sgw='';
					}
					else{
						$Sgw=' AND f_stg = :f_stg';
						$D[":f_stg"] = $Sg; 
					}
			
				if($_GET['OvrHnR'] != ''){
					
					if($_GET['id'] != ''){	
						$stmt = $user_home->runQuery("
							SELECT 	
							f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
							f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
							f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
							FROM 
								films 
							WHERE 
								$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') AND f_genre LIKE CONCAT('%', :f_genre, '%') AND created_by = :created_by $Sgw $Fpw
						");
						
						$D[':f_genre'] = $_GET['id'];	
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
								$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') AND created_by = :created_by $Sgw $Fpw
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
					$TotPage=intval($RwCnt/$PerPage);
	
					if($_GET['id'] != ''){
						$stmt = $user_home->runQuery("
							SELECT 	
							f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
							f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
							f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
							FROM 
								films 
							WHERE 
								$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') AND f_genre LIKE CONCAT('%', :f_genre, '%') AND created_by=:created_by $Sgw $Fpw  LIMIT $Start,$PerPage
						");
						$D[':f_genre'] = $_GET['id'];	
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
								$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%')  AND created_by=:created_by $Sgw $Fpw LIMIT $Start,$PerPage
						");
					}	
						$stmt->execute($D);
						$userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
		else{
				
				if($_GET['id'] != ''){
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
					$D[':f_genre'] = $_GET['id'];
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
					$TotPage=intval($RwCnt/$PerPage);
				
				if($_GET['id'] != ''){
					$stmt = $user_home->runQuery("
						SELECT 	
						f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
						f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
						f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
						FROM 
							films 
						WHERE 
							f_genre LIKE CONCAT('%', :f_genre, '%') AND created_by=:created_by $Sgw $Fpw  LIMIT $Start,$PerPage
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
		}
	}	
	else{
		$link='&user='.$_GET['user'].'';
		$ay=$_GET['user'];
		$result = $user_home->runQuery("
				SELECT 	
					f_name  
				FROM
					films 
				WHERE 
					created_by = :created_by
		");
		$result->execute(array(":created_by"=>$ay));
		$RwCnt = $result->rowCount();
	
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
	
	$TotPage=intval($RwCnt/$PerPage);
	
	$stmt = $user_home->runQuery("
			SELECT 	
				f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
				f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
				f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
			FROM 
				films 
			WHERE 
				created_by = :created_by LIMIT $Start,$PerPage
	");
	$stmt->execute(array(":created_by"=>$ay));
	

	$userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	
}

    echo $BY;

?>


   <div class="cover" style="display:none;">
		<h2 style="text-transform: capitalize;"> 
			
		</h2>
		<div></div>
   </div>


<div id="film-banner">
	<div>
		<h2>

<?php

	  $user_unq =$_GET['user'];
      $stmt= $user_home->runQuery("SELECT user_name,profile_pic,cover_image,user_unq,date_of_birth,gender,about_me,email,skype_username,mobile,position FROM users WHERE user_unq=:user_unq");
      $stmt->execute(array(":user_unq"=>$user_unq));
      $SaerRow=$stmt->fetch(PDO::FETCH_ASSOC);
	
	

	if($_SESSION['IdSer'] == $_GET['user']){
		echo 'My';
	}
	else{
		echo $SaerRow['user_name'];
	}
?>
	Project</h2>
	</div>	
</div>


<div id="Desk-Bxr">
    <div class="col-md-3">
        

	

	
	
	
		<div id="MyProfile">
			<div class="img" style="background-image:url('/profile_pic_image/<?php echo ($SaerRow['profile_pic'] ? $SaerRow['profile_pic']:'profile-default.png' );?>');">
			</div>
			<span><?php echo $SaerRow['user_name'];?></span>
			<div class="AbTns"> 
				<a href="/@<?php echo $SaerRow['user_unq'];?>">View Profile</a>
				<a href="/@<?php echo $SaerRow['user_unq'];?>/connections">View Network</a>
			</div>	
		</div>
		  
		
    </div>

	<div class="col-md-9">
       <section class="feature_listing" style="padding:0;">
         <div class="">
          <div class="row">
				<div id="PadBxr">
					
				<div id="UP-Bxr">	
					<b>Upcoming Premieres</b>
						<div id="toggles">
						  	<div class="switch switch--horizontal switch--no-label switch--expanding-inner">
								  <input value="3" id="radio-m" type="radio" name="seventh-switch" <?php echo ($_GET['FltSg'] == '3' ? 'checked="checked"' : '');?>/>
								  <label for="radio-m">Off</label>
								  <input id="radio-n" value="2" type="radio" name="seventh-switch" <?php echo ($_GET['FltSg'] == '2' ? 'checked="checked"' : '');?>/>
								  <label for="radio-n">On</label>
								  <span class="toggle-outside"><span class="toggle-inside"></span></span>
							</div>
  						</div>
				</div>	
					
					<div id="OvrHnR"> <i class="fa fa-search" aria-hidden="true"></i> <input value="<?php echo $_GET['OvrHnR'];?>" type="text" placeholder="<?php echo $_GET['OvrHnR'];?>"/> </div>
					<div id="OvrHnL"> <div> <b><span><?php echo ($_GET['OvrHnL'] ? $_GET['OvrHnL'] : 'Film Name');?></span> <i class="fa fa-angle-down" aria-hidden="true"></i></b>  <ul><li>Film Name</li><li>Country</li><li>Language</li><li>Producer</li><li>Director</li><li>Writer</li></ul></div> </div>
					
					<div id="OvrDta" style="float: right;margin-right: 10px;background: #efefef;padding: 0 0 0 8px;border-radius: 3px;height: 32px;"> <b style="line-height: 30px;font-size: 13px;text-transform: uppercase;margin-right: 5px;color: #666;">Stage</b>
					<div id="OvrHnLsnd" style="border:0;border-left: 1px solid #ccc;height: 32px;"> <div><b><span><?php echo ($_GET['OvrHnLsnd'] ? $_GET['OvrHnLsnd'] : 'All');?></span> <i class="fa fa-angle-down" aria-hidden="true"></i></b>  <ul><li>All</li><li>Script</li><li>Pre-Production</li><li>Production</li><li>Post-Production</li><li>Complete</li></ul> </div></div>
					</div>
					
					
				</div>
			<div style="clear:both;"></div>

           <div class="main_div" id="FlmBx" style="max-width:100%;">
        <?php 	if(!empty($userRow)){ 
					foreach ($userRow as $userRows) {   
					
						$Ls = json_decode($userRows['TxtVlu'],TRUE);

					?>
							<div class="col-sm-12 BxDvr" style="padding:0;">
								<div class="BxDvrIn">
									<a class="ABack" href="/film/<?php echo $userRows['url'];?>">
										<div class="relative" style="height:180px;position: relative;background-size:cover;background-position:center;background-image:url('<?php if($userRows['film_cover'] == ''){echo '/film_logo/defualt.jpg';} else{echo '/film_logo/'.$userRows['film_cover'];}?>');">
											
											
											
<?php



if($userRows['film_premiere_date'] >= date("Y-m-d H:i:s")){
	$DT = explode(" ",$userRows['film_premiere_date']);
	
	
	$D = explode("/",$DT[0]);
	$T = explode(":",$DT[1]);

	if($T[0] > 12){$T[2]='PM';$T[0]=$T[0] - 12;}
	else{ $T[2]='AM'; if($T[0] == 0 || $T[0] == 00){ $T[0] = 12; }}
													
	$M = array(
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

	echo '<div id="FPD"><span>Film Premiere</span><i class="fa fa-calendar" aria-hidden="true"></i><b>'.$D[2].' '.$M[$D[1]].' '.$D[0].'</b> <i class="fa fa-clock-o" aria-hidden="true"></i><b>'.$T[0].':'.$T[1].' '.$T[2].'</b></div>';
}
											?>
										</div>
									</a>
									
									<div class="DvrBx">
										<div class="DvrBxT">
											<a href="/film/<?php echo $userRows['url']; ?>"><?php echo  $userRows['f_name'];?></a>
										
											<?php 
												if($_SESSION['IdSer'] == $userRows['created_by']){ echo '<a style="float: right;font-size: 13px;font-weight: 600;" href="/manage-film?id='.$userRows['url'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>'; } ?>
										</div>
									  <div class="DvrBxL">
										<div class="DvrBxB">
									       <p><?php 
												echo ($userRows['f_plot'] != '' ? $userRows['f_plot'] : '-----' ); 
											?></p> 
										</div>
										<div class="DvrBxC">
											<?php
												$array = explode(',',$userRows['f_genre']);
												$i=0;$y=0;
												foreach($array as $ay){
												$i++;
													if($i < 4){	
														echo '<a href="/@'.$_GET['user'].'/film?user='.$_GET['user'].'&id='.$ay.'">'.$ay.'</a>';
													}else{
														$y++;	
													}	
												}
												$sum = $x+$y;
											?>
										</div>
									   </div> 
									   <div class="DvrBxR">
										<div class="DvrBxRT">
											<div>
												<div class="DvrBxRTT">
												<b>Producer</b>
											<?php 
												$i=0;
												foreach(explode(',',$userRows['f_procd']) as $ay){
													$i++;
													if($i < 2){
														echo '<a href="/@'.$ay.'">'.$Ls[$ay].'</a>';	
													}	
												}  
											?>
												</div>
												
											</div>
											<div class="DvrBxRTT"> 
											<b>Writer</b>
												<div>
													<?php 
														$i=0;
														foreach(explode(',',$userRows['f_drct']) as $ay){
															$i++;
															if($i < 2){
																echo '<a href="/@'.$ay.'">'.$Ls[$ay].'</a>';	
															}	
														}  
													?>
												</div>
												
											</div>
											<div class="DvrBxRTT"> 
											    <b>Director</b>
												<div>	
													<?php 
														$i=0;
														foreach(explode(',',$userRows['f_wrtr']) as $ay){
															$i++;
															if($i < 2){
																echo '<a href="/@'.$ay.'">'.$Ls[$ay].'</a>';	
															}	
														}  
													?>
												</div>
												
											</div>
										</div>
										<div class="DvrBxRB">
											
											<div>
												<b>Country</b>
												<span>
													<?php 
							$i=0;
							foreach(explode(',',$userRows['f_cnty']) as $ay){
									$i++;
									if($i < 2){
										echo '<a href="">'.$ay.'</a>';	
									}	
							}  
						?>
												</span>
												
												
											</div>
											
											<div>
												<b>Language</b>
												<span>
													<?php 
														$i=0;
														foreach(explode(',',$userRows['f_lng']) as $ay){
															$i++;
															if($i < 2){
																echo '<a href="">'.$ay.'</a>';	
															}	
														}  
													?>
												</span>
											</div>
											<div>
												<b>Stage</b>
												<span><?php echo $userRows['f_stg'];?></span>
											</div>
											<div>
												<b>Budget (USD)</b>
												<span><?php echo $userRows['f_budget'];?></span>
											</div>
											<div>
												<b>Money Raised (USD)</b>
												<span><?php echo $userRows['f_amt_raes'];?></span>
											</div>
											
											
										</div>
											
											
	
									   </div>		
									</div>
								</div>
							</div>
							
						
						
						
						
        <?php 	}

		
		
				}
				else{ 
		?>		
				
				
	<div style="text-align:center;">			
		<span style="display: block;font-weight: 600;font-size: 22px;margin-top: 10px;text-transform: uppercase;" class="mess">Film Not Available On Our Directory</span>
	</div>
        <?php } ?>
		
		
             </div>
			 <div id="Pagination"></div>
            </div>
         </div>
        </section> 
    </div>    
</div>

<?php include 'footer.php';?>
	<script>
	    document.title = "Film";
		var type = '<?php echo $_GET['type'];?>';
		var Ky = '<?php echo $_GET['id'];?>';
		var user = '<?php echo $_GET['user'];?>';
		var User = '<?php echo $_GET['user'];?>';
		var pagenw ='<?php echo $_GET['page'];?>';	
		var FltSg=3,OvrHnL='Film Name',OvrHnLsnd='All',OvrHnR='';
		
		if(type){
			FltSg='<?php echo $_GET['FltSg'];?>',OvrHnL='<?php echo $_GET['OvrHnL'];?>',OvrHnLsnd='<?php echo $_GET['OvrHnLsnd'];?>',OvrHnR='<?php echo $_GET['OvrHnR'];?>';
		}
		
		
		
		
		
		
				function FltrCl(k){
				
					var i = '<div style="text-align:center;padding:20px;"><img src="/images/mgt.gif"/></div>';
					$("#FlmBx").html(i);
				
					var saveData = $.ajax({
						  type: 'POST',
						  url: Page,
						  data: k,
						  dataType: "text",
						  success: function(resultData) {
								$("#MbrBx-Lst").html('');
								var Jsn = JSON.parse(resultData);
								var Usr = "<?php echo $_SESSION['IdSer'];?>";
							
							var Img = '/film_logo/defualt.jpg';
							
							
							
							var Data='',m=0,n=0;
							
							
							var Js=Jsn['js'];
							for(var i=0;i<Js.length;i++){
								var Lst = JSON.parse(Js[i]['TxtVlu']);
								var Cvr='/film_logo/'+Js[i]['film_cover'];
								if(Js[i]['film_cover'] == '') Cvr=Img;
								
							var FPT='';
							if(new Date(Js[i]['film_premiere_date']) >= new Date()){
								function formatDate(date){
								  var hours = date.getHours();
								  var minutes = date.getMinutes();
								  var ampm = hours >= 12 ? 'pm' : 'am';
								  hours = hours % 12;
								  hours = hours ? hours : 12; // the hour '0' should be '12'
								  minutes = minutes < 10 ? '0'+minutes : minutes;
								  var strTime = '<b>'+hours + ':' + minutes + ' ' + ampm+'</b>';
								  return '<i class="fa fa-calendar" aria-hidden="true"></i><b> '+date.getMonth()+1 + "/" + date.getDate() + "/" + date.getFullYear() + '</b> <i class="fa fa-clock-o" aria-hidden="true"></i>' + strTime;
								}
								 FPT='<div id="FPD"><span>Film Premiere</span>'+formatDate(new Date(Js[i]['film_premiere_date']))+'</div>';
							}
							
							Data+='<div class="col-sm-12 BxDvr" style="padding:0;"><div class="BxDvrIn"><a class="ABack" href="/film/'+Js[i]['url']+'"><div class="relative" style="position:relative;height:180px;background-size:cover;background-position:center;background-image:url(\''+Cvr+'\');">'+FPT+'</div></a><div class="DvrBx"><div class="DvrBxT"><a href="/film/'+Js[i]['url']+'">'+Js[i]['f_name']+'</a>';
								
							if(Usr == Js[i]['created_by']) Data+='<a style="float: right;font-size: 13px;font-weight: 600;" href="/manage-film?id='+Js[i]['url']+'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>';
								
							Data+='</div><div class="DvrBxL"><div class="DvrBxB"><p>'+(Js[i]['f_plot'] != '' ? Js[i]['f_plot'] : '-----' )+'</p></div><div class="DvrBxC">';
								
							Js[i]['f_genre'] = Js[i]['f_genre'].split(",");
								for(var m=0;m<Js[i]['f_genre'].length;m++) if(m < 3) Data+='<a href="/@'+user+'/film?id=user='+user+'&'+Js[i]['f_genre'][m]+'">'+Js[i]['f_genre'][m]+'</a>';
							
							Data+='</div></div><div class="DvrBxR"><div class="DvrBxRT"><div class="DvrBxRTT"><b>Producer</b><div>';
								Js[i]['f_procd'] = Js[i]['f_procd'].split(",");
								for(var m=0;m<Js[i]['f_procd'].length;m++) if(m < 1) Data+='<a href="/@'+Js[i]['f_procd'][m]+'">'+Lst[Js[i]['f_procd'][m]]+'</a>';
								Data+='</div></div><div class="DvrBxRTT"><b>Writer</b><div>';
								Js[i]['f_wrtr'] = Js[i]['f_wrtr'].split(",");
								for(var m=0;m<Js[i]['f_wrtr'].length;m++) if(m < 1) Data+='<a href="/@'+Js[i]['f_wrtr'][m]+'">'+Lst[Js[i]['f_wrtr'][m]]+'</a>';
								Data+='</div></div><div class="DvrBxRTT"><b>Director</b><div>';
								Js[i]['f_drct'] = Js[i]['f_drct'].split(",");
								for(var m=0;m<Js[i]['f_drct'].length;m++) if(m < 1) Data+='<a href="/@'+Js[i]['f_drct'][m]+'">'+Lst[Js[i]['f_drct'][m]]+'</a>';								
								Data+='</div></div></div><div class="DvrBxRB"><div><b>Country</b><span>';
								Js[i]['f_cnty'] = Js[i]['f_cnty'].split(",");
								for(var m=0;m<Js[i]['f_cnty'].length;m++) if(m < 1) Data+='<a>'+Js[i]['f_cnty'][m]+'</a>';
								Data+='</span></div><div><b>Language</b><span>';
								Js[i]['f_lng'] = Js[i]['f_lng'].split(",");
								for(var m=0;m<Js[i]['f_lng'].length;m++) if(m < 1) Data+='<a>'+Js[i]['f_lng'][m]+'</a>';
								Data+='</span></div><div><b>Stage</b><span>'+Js[i]['f_stg']+'</span></div><div><b>Budget (USD)</b><span>'+Js[i]['f_budget']+'</span></div><div><b>Money Raised (USD)</b><span>'+Js[i]['f_amt_raes']+'</span></div></div></div></div></div></div>';
							
						  }
						   if(Data) $("#FlmBx").html(Data);
						   else $("#FlmBx").html('<div style="text-align:center;padding:40px;">No Match Found</div>');
			
							TotPage=Jsn['cnt']['t'],Start=Jsn['cnt']['s'],End=Jsn['cnt']['e'],CrntPage=Jsn['cnt']['c'],Lft=0,Rgt=0,Pagination='',NcrL=CrntPage-1,Ncr=TotPage-2,NcrR=CrntPage+1;
							if(Ky) l='&FltSg='+FltSg+'&OvrHnL='+OvrHnL+'&OvrHnLsnd='+OvrHnLsnd+'&OvrHnR='+OvrHnR+'&type=filter&id='+Ky+'&user='+user+'';
							else l='&FltSg='+FltSg+'&OvrHnL='+OvrHnL+'&OvrHnLsnd='+OvrHnLsnd+'&OvrHnR='+OvrHnR+'&type=filter&user='+user+'';
							PgTl(l);
						}  
					});
					saveData.error(function() { alert("Something went wrong"); });
				}
				
		$("#OvrHnL div b").on('click',function(){
			var c = $("#OvrHnL div ul");
			c.show();
			$("#OvrHnL div ul li").off().on('click', function(){
				var txt = $(this).html();
					OvrHnL=txt;
					var v = {type:'FltrMy',FltSg:FltSg,OvrHnL:OvrHnL,OvrHnLsnd:OvrHnLsnd,OvrHnR:OvrHnR,user:User};
					var Ky = '<?php echo $_GET['id'];?>';
					if(Ky != ''){
						v['id']=Ky;
					}
					FltrCl(v);
				$("#OvrHnL div b span").html(txt);
				c.hide();
			});
		
			$(document).mouseup(function(e){		
				if (!c.is(e.target) && c.has(e.target).length === 0) c.hide();
			});
		});
		$("#OvrHnLsnd div b").on('click',function(){
			var c = $("#OvrHnLsnd div ul");
			c.show();
			$("#OvrHnLsnd div ul li").off().on('click', function(){
				var txt = $(this).html();
				OvrHnLsnd=txt;
				var v = {type:'FltrMy',FltSg:FltSg,OvrHnL:OvrHnL,OvrHnLsnd:OvrHnLsnd,OvrHnR:OvrHnR,user:User};
				var Ky = '<?php echo $_GET['id'];?>';
				if(Ky != ''){
					v['id']=Ky;
				}
				FltrCl(v);
				$("#OvrHnLsnd div b span").html(txt);
				c.hide();
			});
		
			$(document).mouseup(function(e){		
				if (!c.is(e.target) && c.has(e.target).length === 0) c.hide();
			});
		});
		$("#OvrHnR input").on('keyup',function(){
					var v = $(this).val();
					OvrHnR=v;
					var v = {type:'FltrMy',FltSg:FltSg,OvrHnL:OvrHnL,OvrHnLsnd:OvrHnLsnd,OvrHnR:OvrHnR,user:User};
					var Ky = '<?php echo $_GET['id'];?>';
					if(Ky != ''){
						v['id']=Ky;
					}
					FltrCl(v);
		});
		$(".switch--horizontal input").change(function(){
			FltSg = $(this).val();
			var v = {type:'FltrMy',FltSg:FltSg,OvrHnL:OvrHnL,OvrHnLsnd:OvrHnLsnd,OvrHnR:OvrHnR,user:User};
			var Ky = '<?php echo $_GET['id'];?>';
			if(Ky != ''){
				v['id']=Ky;
			}
			FltrCl(v);
		});
		
		var TotPage=<?php echo $TotPage;?>,Start=<?php echo $Start;?>,End=<?php echo $End;?>,CrntPage=<?php echo $CrntPage;?>,Lft=0,Rgt=0;
		var Pagination='',NcrL = CrntPage-1,Ncr = TotPage-2,NcrR = CrntPage+1;
		
		
	function PgTl(l){
		Pagination='';
		if(pagenw > 1) Pagination+='<a href="/@'+user+'/film?page='+(+pagenw - 1)+''+l+'">Prev</a>';
		for(var i=1;i<=TotPage;i++){
			if(TotPage > 10){
				if(i < CrntPage && CrntPage != 2){	
					if(i < 3){
						Pagination+='<a href="/@'+user+'/film?page='+i+''+l+'">'+i+'</a>';
					}
					else if(2 < NcrL && Lft==0){
						Pagination+='<span>...</span>';
						Lft=1;
					}
				}	
				else if(CrntPage == i){
						if(i > 1 && i != 3) Pagination+='<a href="/@'+user+'/film?page='+(i-1)+''+l+'">'+(i-1)+'</a>';
						Pagination+='<a href="/@'+user+'/film?page='+i+''+l+'" style="background-color:#1da1f2;color:#fff;">'+i+'</a>';
						if(Ncr > i) Pagination+='<a href="/@'+user+'/film?page='+(i+1)+''+l+'">'+(i+1)+'</a>';
				}
				else if(CrntPage < i){
					if(NcrR < Ncr && Rgt==0){
						Pagination+='<span>...</span>';
						Rgt=1;
					}
					else if(Ncr < i){
						 Pagination+='<a href="/@'+user+'/film?page='+i+''+l+'">'+i+'</a>';
					}
				}	
				else{
					
				}
			}
			else{
				if(CrntPage == i) Pagination+='<a href="film.php?page='+i+''+l+'" style="background-color:#1da1f2;color:#fff;">'+i+'</a>';
				else Pagination+='<a href="film.php?page='+i+''+l+'">'+i+'</a>';
			}	
		}
		if(TotPage != pagenw) Pagination+='<a href="film.php?page='+(+pagenw + 1)+''+l+'">Next</a>';
		$("#Pagination").html(Pagination);
	}	
	var l="<?php echo $link;?>";
	PgTl(l);
</script>
</body>
</html>


<?php } ?>