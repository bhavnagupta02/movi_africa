<?php include 'header.php';
{ 

    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    
	$industry_name = $_GET['id'];
	

	if($_GET['id'] != '' && $_GET['type'] == ''){
		$d=$_GET['id'];
		$link="&id=$d";	
		$ay='Complete';
		$result = $user_home->runQuery("
				SELECT 	
					f_name  
				FROM
					films 
				WHERE 
					f_genre LIKE CONCAT('%', :industry_name, '%')  AND f_stg = :f_stg
		");
		$result->execute(array(":industry_name"=>$industry_name,":f_stg"=>$ay));
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
				f_genre LIKE  CONCAT('%', :industry_name, '%') AND f_stg = :f_stg LIMIT $Start,$PerPage
		");
		$ay='Complete';
		$stmt->execute(array(":industry_name"=>$industry_name,":f_stg"=>$ay));
		$userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		
		
	}	

	else if($_GET['type'] == 'filter'){

				$Nm = $_GET['OvrHnL'];
				$Ov = $_GET['OvrHnR'];
				
				$stg='Complete';
				$D = array(":Ay"=>$_GET['OvrHnR'],":f_stg"=>$stg);
			
				

			if($_GET['id'] != ''){
				$Gid=$_GET['id'];
				$link="&OvrHnL=$Nm&OvrHnR=$Ov&type=filter&id=$Gid";
				$D[":f_genre"] = $Gid; 
			}
			else{
				$link="&OvrHnL=$Nm&OvrHnR=$Ov&type=filter";
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
				
				

			if($_GET['id'] != ''){
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
						$Ay[$Nm] LIKE  CONCAT('%', :Ay, '%') AND f_stg=:f_stg AND f_genre LIKE CONCAT('%', :f_genre, '%') LIMIT $Start,$PerPage
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



}
else{
	$link='';
	$ay='Complete';
	$result = $user_home->runQuery("
			SELECT 	
				f_name  
			FROM
				films 
			WHERE 
				f_stg = :f_stg
	");
	$result->execute(array(":f_stg"=>$ay));
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


    $ay='Complete';
	$stmt = $user_home->runQuery("
			SELECT 	
				f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,
				f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,
				f_rtng,f_run,f_actor,status,rating,rating_total,TxtVlu,like_total,film_premiere_date  
			FROM 
				films 
			WHERE 
				f_stg = :f_stg LIMIT $Start,$PerPage
	");
	$stmt->execute(array(":f_stg"=>$ay));
	$userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


	$Arr = array("Action","Crime","Music","Suspence","Adventure","Documentary","Mystery","Thriller","Animation","Drama","Romance","True Story","Biography","Family","Sci-Fi","War","Comedy","Horror","Sport","Western");
	
	
	echo $BY;

?>

<style>
	#StagSde{background: #f6f6f6;
border-radius: 4px;
border: 1px solid #dedede;}
	#StagSde li:first-child{border: 0;}
	#StagSde li{line-height: 28px;
font-size: 14px;
border-top: 1px solid #dedede;}
	#StagSde li a{text-decoration: none;}
	#StagSde li a:hover{background: #e9e9e9;}
	#StagSde li a p{margin: 0;
padding: 2px 5px;
color: #666;}
</style>


   <div class="cover" style="display:none;">
		<h2 style="text-transform: capitalize;"> 
			
		</h2>
		<div></div>
   </div>

<div id="film-banner">
	<div>
		<h2>Completed film projects</h2>
	</div>	
</div>


<div id="Desk-Bxr" style="position:relative;">
    

<div id="mySidenavStg" class="sidenav-stage">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNavStg()">&times;</a>
  <div id="DataStg">
		
  </div>
</div>

<span id="LeftMenuNw" onclick="openNavStg()">&#9776;</span>
    <div class="col-md-3">
<ul id="StagSde">

<?php

$Arr = array("Action","Crime","Music","Suspence","Adventure","Documentary","Mystery","Thriller","Animation","Drama","Romance","True Story","Biography","Family","Sci-Fi","War","Comedy","Horror","Sport","Western");

sort($Arr);

foreach($Arr as $v){
	$svg = '';
	echo '<li><a href="/film/complete?id='.$v.'"><span>'.$svg.'</span> <p>'.$v.'</p></a></li>';
}

?>

						
							

  
  
</ul>
    </div>
	<div class="col-md-9">
       <section class="feature_listing" style="padding:0;">
         <div class="">
          <div class="row">
				<div style="float: left;width: 100%;margin: 10px 0;">
					
					<div id="OvrHnR"> <i class="fa fa-search" aria-hidden="true"></i> <input type="text" value="<?php echo $_GET['OvrHnR'];?>" placeholder="Search By Name"/> </div>
					<div id="OvrHnL"> <div> <b><span><?php echo ($_GET['OvrHnL'] ? $_GET['OvrHnL'] : 'Film Name');?></span> <i class="fa fa-angle-down" aria-hidden="true"></i></b>  <ul><li>Film Name</li><li>Country</li><li>Language</li><li>Producer</li><li>Director</li><li>Writer</li></ul></div> </div>
					
				</div>
			<div style="clear:both;"></div>
		   <div class="main_div" id="FlmBx" style="max-width:100%;">
        <?php 	if(!empty($userRow)){ 
					foreach ($userRow as $userRows) {   
					
						$Ls = json_decode($userRows['TxtVlu'],TRUE);

					?>
							<div class="col-sm-12 BxDvr" style="padding:0;">
								<div class="BxDvrIn">
									<a class="ABack" href="/film/<?php echo $userRows['url']; ?>">
										<div class="relative" style="height:180px;position: relative;background-size:cover;background-position:center;background-image:url('<?php if($userRows['film_cover'] == ''){echo '/film_logo/defualt.jpg';} else{echo '/film_logo/'.$userRows['film_cover'];}?>');">

										</div>
									</a>
									

									
									<div class="DvrBx">
										<div class="DvrBxT">
											<a href="/film/<?php echo $userRows['url']; ?>"><?php echo  $userRows['f_name'];?></a>
										
											<?php 
												if($_SESSION['IdSer'] == $userRows['created_by']){ echo '<a style="float: right;font-size: 13px;font-weight: 600;" href="manage-film.php?id='.$userRows['url'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>'; } ?>
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
														echo '<a href="/@'.$ay.'">'.$ay.'</a>';
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
														echo '<a href="/@='.$ay.'">'.$Ls[$ay].'</a>';	
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
																echo '<a href="profile_info.php?id='.$ay.'">'.$Ls[$ay].'</a>';	
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
				
				
				<span style="display: block;font-weight: 600;font-size: 22px;margin-top: 10px;text-transform: uppercase;" class="mess">Film Not Available On Our Directory</span></div>
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
	    document.title = "Film Directory";
		var OvrHnL='Film Name',OvrHnR='';
		var pagenw ='<?php echo $_GET['page'];?>';	
		var type = '<?php echo $_GET['type'];?>';
		var Ky = '<?php echo $_GET['id'];?>',StagSde=<?php echo json_encode($Arr);?>;

		if(type){
			FltSg='<?php echo $_GET['FltSg'];?>',OvrHnL='<?php echo $_GET['OvrHnL'];?>',OvrHnR='<?php echo $_GET['OvrHnR'];?>';
		}
		
		
		for(var i=0;i<StagSde.length;i++) $('#mySidenavStg #DataStg').append('<a href="/film/complete?id='+StagSde[i]+'">'+StagSde[i]+'</a>');
		
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
								var Cvr='film_logo/'+Js[i]['film_cover'];
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
							
							
							
							
								Data+='<div class="col-sm-12 BxDvr" style="padding:0;"><div class="BxDvrIn"><a class="ABack" href="view-film.php?id='+Js[i]['url']+'"><div class="relative" style="position:relative;height:180px;background-size:cover;background-position:center;background-image:url(\''+Cvr+'\');">'+FPT+'</div></a><div class="DvrBx"><div class="DvrBxT"><a href="view-film.php?id='+Js[i]['url']+'">'+Js[i]['f_name']+'</a>';
								
								if(Usr == Js[i]['created_by']) Data+='<a style="float: right;font-size: 13px;font-weight: 600;" href="manage-film.php?id='+Js[i]['url']+'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>';
								
								
								
								
								
								Data+='</div><div class="DvrBxL"><div class="DvrBxB"><p>'+(Js[i]['f_plot'] != '' ? Js[i]['f_plot'] : '-----' )+'</p></div><div class="DvrBxC">';
								
								Js[i]['f_genre'] = Js[i]['f_genre'].split(",");
								for(var m=0;m<Js[i]['f_genre'].length;m++) if(m < 3) Data+='<a href="/film/complete?id='+Js[i]['f_genre'][m]+'">'+Js[i]['f_genre'][m]+'</a>';
							
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
								Data+='</span></div><div><b>Stage</b><span>'+Js[i]['f_stg']+'</span></div><div><b>Budget (USD)</b><span>'+Js[i]['f_budget']+'</span></div></div></div></div></div></div>';
							
						  }
						   if(Data) $("#FlmBx").html(Data);
						   else $("#FlmBx").html('<div style="text-align:center;padding:40px;">No Match Found</div>');
						   
						 
						   
						   TotPage=Jsn['cnt']['t'],Start=Jsn['cnt']['s'],End=Jsn['cnt']['e'],CrntPage=Jsn['cnt']['c'],Lft=0,Rgt=0,Pagination='',NcrL=CrntPage-1,Ncr=TotPage-2,NcrR=CrntPage+1;
							if(Ky) l='&OvrHnL='+OvrHnL+'&OvrHnR='+OvrHnR+'&type=filter&id='+Ky+'';
							else l='&OvrHnL='+OvrHnL+'&OvrHnR='+OvrHnR+'&type=filter';
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
					var v = {type:'FltrCld',OvrHnL:OvrHnL,OvrHnR:OvrHnR};
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
		

		$("#OvrHnR input").on('keyup',function(){
					var v = $(this).val();
					OvrHnR=v;
					var v = {type:'FltrCld',OvrHnL:OvrHnL,OvrHnR:OvrHnR};
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
		if(pagenw > 1) Pagination+='<a href="/film/complete?page='+(+pagenw - 1)+''+l+'">Prev</a>';
		for(var i=1;i<=TotPage;i++){
			if(TotPage > 10){
				if(i < CrntPage && CrntPage != 2){	
					if(i < 3){
						Pagination+='<a href="/film/complete?page='+i+''+l+'">'+i+'</a>';
					}
					else if(2 < NcrL && Lft==0){
						Pagination+='<span>...</span>';
						Lft=1;
					}
				}	
				else if(CrntPage == i){
						if(i > 1 && i != 3) Pagination+='<a href="/film/complete?page='+(i-1)+''+l+'">'+(i-1)+'</a>';
						Pagination+='<a href="/film/complete?page='+i+''+l+'" style="background-color:#1da1f2;color:#fff;">'+i+'</a>';
						if(Ncr > i) Pagination+='<a href="/film/complete?page='+(i+1)+''+l+'">'+(i+1)+'</a>';
				}
				else if(CrntPage < i){
					if(NcrR < Ncr && Rgt==0){
						Pagination+='<span>...</span>';
						Rgt=1;
					}
					else if(Ncr < i){
						 Pagination+='<a href="/film/complete?page='+i+''+l+'">'+i+'</a>';
					}
				}	
				else{
					
				}
			}
			else{
				if(CrntPage == i) Pagination+='<a href="/film/complete?page='+i+''+l+'" style="background-color:#1da1f2;color:#fff;">'+i+'</a>';
				else Pagination+='<a href="/film/complete?page='+i+''+l+'">'+i+'</a>';
			}	
		}
		if(TotPage != pagenw) Pagination+='<a href="/film/complete?page='+(+pagenw + 1)+''+l+'">Next</a>';
		$("#Pagination").html(Pagination);
	}	
	var l="<?php echo $link;?>";
	PgTl(l);
	
	
	function openNavStg() {
	  document.getElementById("mySidenavStg").style.width = "250px";
	}

	function closeNavStg() {
	  document.getElementById("mySidenavStg").style.width = "0";
	}
</script>
	
	</body>
</html>
<?php } ?>