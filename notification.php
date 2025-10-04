<?php include 'header.php';
   
    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }


           

	
			if($_GET['action'] == 'rating'){
				$Unq=$_GET['to'];
				$url=$_GET['url']; 
				$to=$_SESSION['IdSer']; 
				
				
				$read_by='0';
				$stmt = $user_home->runQuery("SELECT t_id,f_id,n_tm,type,read_by,post_id,post_name,extra FROM noticefication WHERE t_id=:t_id AND f_id=:f_id AND post_id=:post_id AND read_by=:read_by");
				$stmt->execute(array(":t_id"=>$Unq,":f_id"=>$to,":post_id"=>$url,":read_by"=>$read_by));
				$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
				if($stmt->rowCount() == 1){	
				
				
				
					$read_by='1';
					$stmt = $user_home->runQuery("UPDATE noticefication SET read_by=:read_by WHERE t_id=:t_id AND f_id=:f_id AND post_id=:post_id");
					$stmt->bindParam(':read_by',$read_by);
					$stmt->bindParam(':t_id',$Unq);
					$stmt->bindParam(':f_id',$to);
					$stmt->bindParam(':post_id',$url);
					$stmt->execute();
					$user_home->redirect('/@'.$Unq.'');
					 
					
				}	
			}			 
      
	  
	  $user_unq =$_SESSION['IdSer'];
      $stmt= $user_home->runQuery("SELECT user_name,profile_pic,cover_image,user_unq,date_of_birth,gender,about_me,email, 	facebook_username,tweeter_username,instagram_username FROM users WHERE user_unq=:user_unq");
      $stmt->execute(array(":user_unq"=>$user_unq));
      $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
      
		        $user_unq =$_SESSION['IdSer'];
				$stmt_noti= $user_home->runQuery("SELECT 
					 users.user_unq,users.user_name,noticefication.type,noticefication.read_by,noticefication.post_name,noticefication. 	extra,noticefication.n_tm,noticefication.post_id,users.profile_pic 
					FROM users
					LEFT JOIN noticefication ON users.user_unq = noticefication.t_id
					WHERE noticefication.f_id=:f_id  ORDER BY `noticefication`.`n_tm` DESC LIMIT 5 ");
				$stmt_noti->execute(array(":f_id"=>$user_unq));
				$userRowFrnd=$stmt_noti->fetchAll(PDO::FETCH_ASSOC);
         
    echo $BY;                       
?>

</head>
	<body>
	<div id="Profile-Not" class="Profile-notification">
    <div class="container">
    <div class="row">

	<div id="AppID" class="col-lg-12 col-md-12 col-sm-12">
	
		<div class="recent-heading">
			<h1>Recent notification</h1> 
		
		</div>
		
		<div style="clear:both;"></div>
		<div id="MbrBx-Lst">
		    <div class="MbrBx-LstDv">
		<?php 
		if(!empty($userRowFrnd)){
			foreach ($userRowFrnd as $val) {
	
				 if($val['type']=='request') {
					$type = "Accepted your friend request.";
				 }
				 else if($val['type']=='rating'){
					$Ag = $val['extra']/2;
					$numberAsString = number_format($Ag,2);
					$type = 'Gave '.$numberAsString.' rating on '.$val['post_name'].'.';
				 }
					
				$Ig = ($val['profile_pic'] ? '/profile_pic_image/'.$val['profile_pic'].'' : '/profile_pic_image/profile-default.png');

				$Tm = '<span class="TmBxr" >'.date('F j, Y', $val['n_tm']).'</span>';		
					 
					 
				if($val['read_by'] == 1){   
					echo '<a href="/@'.$val['user_unq'].'" class="MbrBx-Lst"><img class="profile-pic" src="'.$Ig.'"><h2>'.$val['user_name'].'</h2><p> '.$Tm.'<span>'.$type.'</span></p></a>';
				}
				else{
				if($val['type']=='rating') {
					$rl = '/notification?action=rating&to='.$val['user_unq'].'&url='.$val['post_id'].'';
				}
				else{				
					$rl = '/@'.$val['user_unq'].'';
				}
					
					echo '<a href="'.$rl.'" class="MbrBx-Lst">
					    <img class="profile-pic" src="'.$Ig.'">
					    <h2>'.$val['user_name'].'</h2>
					    <p>'.$Tm.'<span>'.$type.'</span>
					    </p>
					    </a>
					    ';
				} 
			}
		
		    echo '</div>';
		}
		
		
else{
	echo '<p class="no-Notification">No Notification</p>';
}		
		?>
		
		<div class="loadmore">
            <div id="LoaDv" class="load-more">   Load More</div>
          </div>
     
	</div>
	
<!--	<div id="AppIed">
	
		<div id="MyProfile">
			<div class="img" style="background-image:url('/profile_pic_image/<?php //echo ($_SESSION['profile_pic'] ? $_SESSION['profile_pic'] : 'profile-default.png')?>');">
			</div>
			<span><?php //echo $_SESSION['user_name'];?></span>
			<div class="AbTns">
				<a href="/@<?php //echo $_SESSION['IdSer'];?>">Edit Profile</a>	
				<a href="/my-connections">My Network</a>	
			</div>	
		</div>
		
		<div id="LnkHdr">
			<a href="/aboutus">About</a> 
			<a href="/terms">Terms</a> 
			<a href="/privacy">Privacy</a>
			<a href="/contact">Contact</a>							
		</div>	
	</div>-->	

			
			
		</div>
	
	</div>			
	</div>		
	</div>
	<?php include 'footer.php';?>
	

<script>
var cnt = 1;

$("#LoaDv").on('click',function(){
    loadmore();
});

function loadmore(){
    
  $.ajax ({
      type: "POST",
      url:  '/',
      data:  {Noticecount:cnt},
      dataType: 'json',
      success: function(data) {
         var js = data;
         var datas = '';
         if( JSON.parse(js['data']).length == 0){  
             console.log("hello");  
         }else{
            var ps = JSON.parse(js['data']);
              
            for(var i=0;i<ps.length;i++){
               datas+='<a href="/@'+ps[i]['user_unq']+'" class="MbrBx-Lst"><img class="profile-pic" src="/profile_pic_image/profile-default.png"><h2>'+ps[i]['user_name']+'</h2><p> <span class="TmBxr">'+ps[i]['date']+'</span><span>Accepted your friend request.</span></p></a>';  
            } 
          
            $("#MbrBx-Lst div.MbrBx-LstDv").append(datas);
            cnt = js['cnt'] + 1; 
         }

         
          // {\"user_unq\":\"test1386\",\"user_name\":\"test13 singh\",\"type\":\"request\",\"read_by\":\"1\",\"post_name\":\"\",\"extra\":\"\",\"n_tm\":\"1569476050\",\"post_id\":\"\",\"profile_pic\":\"\"}
          
              
          
  },
  error: function(data) {
    console.log('Error: ' + data);
    return false;
  }
 });

    
}




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

        document.title = "Notification";
		var h = document.documentElement.clientHeight - 150;
		$("#Profile").css('min-height',h);
    </script>
	</body>

	
</html>