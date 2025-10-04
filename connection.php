<?php include 'header.php';

    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    
    echo $BY;


//echo '<div id="MainDvr">
	'<div id="AppIed-Lft">
		<div id="MyProfile">
			<div class="img" style="background-image:url(/profile_pic_image/'.( $_SESSION['profile_pic'] ? ''.$_SESSION['profile_pic'].'' : 'profile-default.png').');margin:15px auto;"></div>
			<span>'.$_SESSION['user_name'].'</span>
			<div class="AbTns">
				
			</div>	
		</div>
		<div id="LnkHdr">
			<a href="/my-connections/member">My Network</a> <a href="/my-connections/pending">Pending</a>
		</div>	
	</div>';	

echo '<div class="connections-section">
  <div class="container">
    <div class="row"> 
    <div id="MainDvr" class="col-lg-12 col-md-12 col-sm-12">';


		if($_GET['connection'] == 'pending'){
				$user_unq =$_SESSION['IdSer'];$status='0';
				$stmt= $user_home->runQuery("SELECT 
					users.user_unq,users.user_name,friends.time,users.email,users.country_id,users.profile_pic,users.occupation  
					FROM users
					LEFT JOIN friends ON users.user_unq = friends.t_unique
					WHERE friends.f_unique=:t_unique AND friends.status=:status");
				$stmt->execute(array(":t_unique"=>$user_unq,":status"=>$status));
				$userRowFrnd=$stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
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
				$stmt= $user_home->runQuery("SELECT * FROM users WHERE user_unq IN ($Lf) ORDER BY `users`.`created_at` DESC LIMIT 0,10");
				$stmt->execute();
				$userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			
				$user_unq =$_SESSION['IdSer'];$status='0';
				$stmt= $user_home->runQuery("SELECT 
					users.user_unq,users.user_name,friends.time,users.email,users.country_id,users.profile_pic,users.occupation 
					FROM users
					LEFT JOIN friends ON users.user_unq = friends.f_unique
					WHERE friends.t_unique=:t_unique AND friends.status=:status");
				$stmt->execute(array(":t_unique"=>$user_unq,":status"=>$status));
				$userRowFrnd=$stmt->fetchAll(PDO::FETCH_ASSOC);

		
		}
	
	
	if($_GET['connection'] == 'member' || $_GET['connection'] == ''){ 

	echo '<div id="AppID" class="RhtSide">
        <div class="top-section">
		<h1>Request</h1>';
		echo '</div>';	
			if(!empty($userRowFrnd)){
				foreach ($userRowFrnd as $val) {
				echo '<div class="MbrBx-Lst">
				<div class="MbrBx-LstDv">
					<img class="profile-pic" src="/profile_pic_image/'.( $val['profile_pic'] ? $val['profile_pic'] : 'profile-default.png' ).'"/>
					<h2><a class="LnkA" href="/@'.$val['user_unq'].'">'.$val['user_name'].'</a></h2>
					<p><span>'.str_replace(',', ", ", $val['occupation']).'</span>
						<span> '.date('F j, Y', $val['time']).' </span></p>
						<div class="buton-Lst"><a href="/@'.$val['user_unq'].'">View</a></div>
					</div>
				</div>';
					}
			}else{
				echo '<p class="Request">No Request</p>';	
			}	
	
	 
		echo '
		<div class="app-top-section" >
			<div id="OvrHnL"> <p>Sort by</p> <div class="left-add"> <b><span>Recent Added</span> <i class="fa fa-angle-down" aria-hidden="true"></i></b>  <ul><li>Recent Added</li><li>First Name</li><li>Last Name</li></ul></div> </div>
			<div id="OvrHnR"> <i class="fa fa-search" aria-hidden="true"></i> <input type="text" placeholder="Search By Name"/> </div>
		</div>
		
		<div style="clear:both;"></div>
		<div id="MbrBx-Lst">';
				if(!empty($userRow)){
   				    foreach ($userRow as $val) {
				echo '<div class="MbrBx-Lst">
				<div class="MbrBx-LstDv">
					<img class="profile-pic" src="/profile_pic_image/'.( $val['profile_pic'] ? $val['profile_pic'] : 'profile-default.png' ).'"/>
						<h2><a class="LnkA" href="/@'.$val['user_unq'].'">'.$val['user_name'].'</a></h2>
						<p><span>'.str_replace(',', ", ", $val['occupation']).'</span>
						<span>'.$val['country_id'].'</span></p>
							<div class="buton-Lst"><a href="/@'.$val['user_unq'].'">View</a></div>
					</div>
				</div>';
					}
				}
				else{
					echo 'No Member On Your Connection';
				}	
			echo '</div> 
		<div class="loadmore">
			<div id="LoaDv" class="load-more">Load More</div>
		</div>
			</div>';
		}
		else if($_GET['connection'] == 'pending'){
			echo '<div id="AppID">
        
		<h1 style="text-align: left;font-size: 17px;color: #999797;letter-spacing: 1px;margin: 10px;text-align:center;">Pending Request</h1>';
			if(!empty($userRowFrnd)){
				foreach ($userRowFrnd as $val) {
				echo '<div class="MbrBx-Lst">
					<img src="profile_pic_image/'.($val['profile_pic'] ? ''.$val['profile_pic'].'' : 'profile-default.png' ).'"/>
					<div class="MbrBx-LstDv">
						<a class="LnkA" href="/@'.$val['user_unq'].'">'.$val['user_name'].'</a>
						<span>'.str_replace(',', ", ", $val['occupation']).'</span>
						<span> '.date('F j, Y', $val['time']).' </span>
						<a class="buton-Lst" href="/@'.$val['user_unq'].'">View</a>
					</div>
				</div>';
						}
					}
					else{
						echo 'No Pending Request';	
					}	
			echo '</div>';			
			}
echo '</div></div></div></div>';
		include 'footer.php'; ?>				
	
	</body>
	<script>
	    document.title = "My Network";
		var Page = "<?php echo SITE_URL; ?>";
		
		var PageCurnt=1,Mytype='',ty='SoMbrCon';
		Mytype={type:'SoMbrCon',vlu:'Recent Added',usr:'<?php echo $_SESSION['IdSer'];?>','page':2};
		$("#LoaDv").on('click',function(){
					PageCurnt=1;
					var myKeyVals = Mytype;
					var saveData = $.ajax({
						  type: 'POST',
						  url: Page,
						  data: myKeyVals,
						  dataType: "text",
						  success: function(resultData) { 
								var Jsn = JSON.parse(resultData);
								var Js=Jsn['js'];
								var v='';
								for(var i=0;i<Js.length;i++) $("#MbrBx-Lst").append('<div class="MbrBx-Lst"><img src="'+(Js[i]['profile_pic'] ? '/profile_pic_image/'+Js[i]['profile_pic'] : "/profile_pic_image/profile-default.png")+'"><div class="MbrBx-LstDv"><a class="LnkA" href="profile_info.php?id='+Js[i]['user_unq']+'">'+Js[i]['user_name']+'</a><span>'+(Js[i]['occupation'] ? Js[i]['occupation'].replace(/,/g, ", ") : "")+'</span><span>'+(Js[i]['country_id'] ? Js[i]['country_id'] : "")+'</span><a class="buton-Lst" href="profile_info.php?id='+Js[i]['user_unq']+'">VIEW</a></div></div>');
								PageCurnt=Jsn['cnt']['c'];
								PageCurnt=+PageCurnt+1;
								if(ty == 'SoMbrCon'){
									v = $("#OvrHnL div b span").html();
								}
								else if(ty == 'SrKyCon'){
									v = $("#OvrHnR input").val();
								}
								else{
								
								}
								Mytype={type:ty,vlu:v,usr:'<?php echo $_SESSION['IdSer'];?>','page':PageCurnt};
								if(Js.length > 0) $("#LoaDv").show();
								else $("#LoaDv").hide();
						  }
					});
					saveData.error(function() { alert("Something went wrong"); });
		});
		
		$("#OvrHnL div b").on('click',function(){
			var c = $("#OvrHnL div ul");
			c.show();
			$("#OvrHnL div ul li").off().on('click', function() {
				var txt = $(this).html();
					var myKeyVals = {type:'SoMbrCon',vlu:txt,usr:'<?php echo $_SESSION['IdSer'];?>'};
					var saveData = $.ajax({
						  type: 'POST',
						  url: Page,
						  data: myKeyVals,
						  dataType: "text",
						  success: function(resultData) { 
								$("#MbrBx-Lst").html('');
								var Jsn = JSON.parse(resultData);
								var Js=Jsn['js'];
								for(var i=0;i<Js.length;i++) $("#MbrBx-Lst").append('<div class="MbrBx-Lst"><div class="MbrBx-LstDv"><img class="profile-pic" src="'+(Js[i]['profile_pic'] ? 'profile_pic_image/'+Js[i]['profile_pic'] : "/profile_pic_image/profile-default.png")+'"><h2><a class="LnkA" href="profile_info.php?id='+Js[i]['user_unq']+'">'+Js[i]['user_name']+'</a></h2><p><span>'+(Js[i]['occupation'] ? Js[i]['occupation'].replace(/,/g, ", ") : "")+'</span><span>'+(Js[i]['country_id'] ? Js[i]['country_id'] : "")+'</span></p><div class="buton-Lst"><a href="profile_info.php?id='+Js[i]['user_unq']+'">VIEW</a></div></div></div>');
							
								PageCurnt=Jsn['cnt']['c'];
								PageCurnt=+PageCurnt + 1;
								ty='SoMbrCon';
								Mytype={type:ty,vlu:txt,usr:'<?php echo $_SESSION['IdSer'];?>','page':PageCurnt};
							
						  }
					});
					saveData.error(function() { alert("Something went wrong"); });
				
				
				$("#OvrHnL div b span").html(txt);
				c.hide();
			});
		
			$(document).mouseup(function(e){		
				if (!c.is(e.target) && c.has(e.target).length === 0) c.hide();
			});
		});
		
		$("#OvrHnR input").on('keyup',function(){
					var v = $(this).val();
					var myKeyVals = {type:'SrKyCon',vlu:v,usr:'<?php echo $_SESSION['IdSer'];?>'};
				
					var saveData = $.ajax({
						  type: 'POST',
						  url: Page,
						  data: myKeyVals,
						  dataType: "text",
						  success: function(resultData) { 
								$("#MbrBx-Lst").html('');
								var Jsn = JSON.parse(resultData);
								var Js=Jsn['js'];
								for(var i=0;i<Js.length;i++) $("#MbrBx-Lst").append('<div class="MbrBx-Lst"><div class="MbrBx-LstDv"><img class="profile-pic" src="'+(Js[i]['profile_pic'] ? 'profile_pic_image/'+Js[i]['profile_pic'] : "/profile_pic_image/profile-default.png")+'"><!--<div class="MbrBx-LstDv">--><h2><a class="LnkA" href="profile_info.php?id='+Js[i]['user_unq']+'">'+Js[i]['user_name']+'</a></h2><p><span>'+(Js[i]['occupation'] ? Js[i]['occupation'].replace(/,/g, ", ") : "")+'</span><span>'+(Js[i]['country_id'] ? Js[i]['country_id'] : "")+'</span></p><div class="buton-Lst"><a href="profile_info.php?id='+Js[i]['user_unq']+'">VIEW</a></div></div></div>');
								
								PageCurnt=Jsn['cnt']['c'];
								PageCurnt=+PageCurnt + 1;
								ty='SrKyCon';
								Mytype={type:ty,vlu:v,usr:'<?php echo $_SESSION['IdSer'];?>','page':PageCurnt};
								
						  }
					});
					saveData.error(function() { alert("Something went wrong"); });
		});
	</script>
</html>