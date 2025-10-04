<?php include 'header.php';

   if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    
    echo $BY;
?>


<div id="MainDvr">
	<?php
	  $user_unq =$_GET['id'];
      $stmt= $user_home->runQuery("SELECT user_name,profile_pic,cover_image,user_unq,date_of_birth,gender,about_me,email,skype_username,mobile,position FROM users WHERE user_unq=:user_unq");
      $stmt->execute(array(":user_unq"=>$user_unq));
      $SaerRow=$stmt->fetch(PDO::FETCH_ASSOC);
	
	?>
	
	
	<div id="AppIed-Lft">
		<div id="MyProfile">
			<div class="img" style="background-image:url('/profile_pic_image/<?php echo ($SaerRow['profile_pic'] ? $SaerRow['profile_pic'] : 'profile-default.png')?>');margin:15px auto;">
			</div>
			<span><?php echo $SaerRow['user_name'];?></span>
			<div class="AbTns"> </div>	
		</div>
	</div>	

	<?php 
		$user_unq =$_GET['id'];$status='1';
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
			$stmt= $user_home->runQuery("SELECT * FROM users WHERE user_unq IN ($Lf) ORDER BY `users`.`created_at` DESC LIMIT 0,10");
			$stmt->execute();
			$userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	?>	
	
	
	<div id="AppID" class="LftSide">
        <h1 style="text-align: left;font-size: 17px;color: #999797;letter-spacing: 1px;margin: 10px;display:none;">17 Connections</h1>
		<div style="float: left;width: 100%;margin-top:12px;">
			<div id="OvrHnL"> <b>Sort by</b> <div> <b><span>Recent Added</span> <i class="fa fa-angle-down" aria-hidden="true"></i></b>  <ul><li>Recent Added</li><li>First Name</li><li>Last Name</li></ul></div> </div>
			<div id="OvrHnR"> <i class="fa fa-search" aria-hidden="true"></i> <input type="text" placeholder="Search By Name"/> </div>
		</div>
		<div style="clear:both;"></div>
		<div id="MbrBx-Lst">
			<?php 
			if(!empty($userRow)){
				foreach ($userRow as $val) {
			?>
				<div class="MbrBx-Lst">
					<img src="<?php echo ( $val['profile_pic'] ? '/profile_pic_image/'.$val['profile_pic'].'' : '/profile_pic_image/profile-default.png' ); ?>"/>
					<div class="MbrBx-LstDv">
						<a class="LnkA" href="/@<?php echo $val['user_unq'];?>"><?php echo $val['user_name']; ?></a>
						<span><?php echo $val['email']?></span>
						<span><?php echo $val['country_id']?></span>
							<a class="buton-Lst" href="/@<?php echo $val['user_unq'];?>"> View</a>
					</div>
				</div>
		
	<?php			
				}
			}
			else{
				echo '<p style="text-align:center;line-height:120px;">Member Connection Not Exit</p>';
			}	
	?>
		
		</div> 
		
		<div style="text-align: center;margin-top: 25px;">
			<div id="LoaDv">Load More</div>
		</div>
	</div>
</div>
    <?php include 'footer.php'; ?>				
</body>
	<script>
	    document.title = "Connection Page";
		var Page = "<?php echo SITE_URL; ?>";
		
		
			var PageCurnt=1,Mytype='',ty='SoMbrConVw';
		Mytype={type:'SoMbrConVw',vlu:'Recent Added',usr:'<?php echo $_SESSION['IdSer'];?>','page':2};
		
		
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
								
								for(var i=0;i<Js.length;i++) $("#MbrBx-Lst").append('<div class="MbrBx-Lst"><img src="'+(Js[i]['profile_pic'] ? '/profile_pic_image/'+Js[i]['profile_pic'] : "/profile_pic_image/profile-default.png")+'"><div class="MbrBx-LstDv"><a class="LnkA" href="profile_info.php?id='+Js[i]['user_unq']+'">'+Js[i]['user_name']+'</a><span>'+(Js[i]['email'] ? Js[i]['email'] : "-- Email Not Found --")+'</span><span>'+(Js[i]['country_id'] ? Js[i]['country_id'] : "-- No Country Select --")+'</span><a class="buton-Lst" href="profile_info.php?id='+Js[i]['user_unq']+'">VIEW</a></div></div>');
								PageCurnt=Jsn['cnt']['c'];
								PageCurnt=+PageCurnt+1;
								if(ty == 'SoMbrConVw'){
									v = $("#OvrHnL div b span").html();
								}
								else if(ty == 'SrKyConVw'){
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
				
					var myKeyVals = {type:'SoMbrConVw',vlu:txt,usr:'<?php echo $_GET['id'];?>'};
					
					var saveData = $.ajax({
						  type: 'POST',
						  url: Page,
						  data: myKeyVals,
						  dataType: "text",
						  success: function(resultData) { 
								$("#MbrBx-Lst").html('');
								var Jsn = JSON.parse(resultData);
								var Js=Jsn['js'];
								for(var i=0;i<Js.length;i++) $("#MbrBx-Lst").append('<div class="MbrBx-Lst"><img src="'+(Js[i]['profile_pic'] ? '/profile_pic_image/'+Js[i]['profile_pic'] : "/profile_pic_image/profile-default.png")+'"><div class="MbrBx-LstDv"><a class="LnkA" href="profile_info.php?id='+Js[i]['user_unq']+'">'+Js[i]['user_name']+'</a><span>'+(Js[i]['email'] ? Js[i]['email'] : "-- Email Not Found --")+'</span><span>'+(Js[i]['country_id'] ? Js[i]['country_id'] : "-- No Country Select --")+'</span><a class="buton-Lst" href="profile_info.php?id='+Js[i]['user_unq']+'">VIEW</a></div></div>');
								
								PageCurnt=Jsn['cnt']['c'];
								PageCurnt=+PageCurnt + 1;
								ty='SoMbrConVw';
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
					var myKeyVals = {type:'SrKyConVw',vlu:v,usr:'<?php echo $_GET['id'];?>'};
					var saveData = $.ajax({
						  type: 'POST',
						  url: Page,
						  data: myKeyVals,
						  dataType: "text",
						  success: function(resultData) { 
								$("#MbrBx-Lst").html('');
								var Js = JSON.parse(resultData);
								for(var i=0;i<Js.length;i++) $("#MbrBx-Lst").append('<div class="MbrBx-Lst"><img src="'+(Js[i]['profile_pic'] ? '/profile_pic_image/'+Js[i]['profile_pic'] : "/profile_pic_image/profile-default.png")+'"><div class="MbrBx-LstDv"><a class="LnkA" href="/@'+Js[i]['user_unq']+'">'+Js[i]['user_name']+'</a><span>'+(Js[i]['email'] ? Js[i]['email'] : "-- Email Not Found --")+'</span><span>'+(Js[i]['country_id'] ? Js[i]['country_id'] : "-- No Country Select --")+'</span><a class="buton-Lst" href="profile_info.php?id='+Js[i]['user_unq']+'">VIEW</a></div></div>');
								
								PageCurnt=Jsn['cnt']['c'];
								PageCurnt=+PageCurnt + 1;
								ty='SrKyConVw';
								Mytype={type:ty,vlu:v,usr:'<?php echo $_SESSION['IdSer'];?>','page':PageCurnt};
								
						  }
					});
					saveData.error(function() { alert("Something went wrong"); });
		});
		
		
	</script>
</html>