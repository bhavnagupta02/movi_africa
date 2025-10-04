<?php include 'header.php';

    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    
	if($user_home->is_logged_in()){
		$status='0';
	if($_GET['to'] != ''){
		$stmt = $user_home->runQuery("SELECT f_unique,t_unique,time,status,msg,msg_tm,msg_by FROM friends WHERE (f_unique=:f_unique AND t_unique=:t_unique ) OR (f_unique=:f_uniques AND t_unique=:t_uniques ) AND msg_to!=:status ORDER BY msg_tm DESC");
		$stmt->execute(array(":f_unique"=>$_SESSION['IdSer'],":t_unique"=>$_GET['to'],":f_uniques"=>$_GET['to'],":t_uniques"=>$_SESSION['IdSer'],":status"=>$status)); 
		$Row=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() == 0){
			$Pt = SITE_URL.'message.php';
            echo '<script>
                window.location.href = "'.$Pt.'";
            </script>';
		}
		$status_as='1';	
		$stmt = $user_home->runQuery("UPDATE friends SET status_as=:status_as WHERE msg_by=:f_un AND msg_to=:msg_to");
		$stmt->bindParam(':status_as',$status_as);
		$stmt->bindParam(':f_un',$_SESSION['IdSer']);
		$stmt->bindParam(':msg_to',$_GET['to']);
		$stmt->execute();
	}	

	if($_SESSION['IdSer'] == $_GET['to']){
		$Pt = SITE_URL.'message.php';
        echo '<script>
            window.location.href = "'.$Pt.'";
        </script>';
	}
		
		
	$pa=array();$Raa=array();$Dta='';
		
		
	$status_ew=0;$status='1';$msg_tm='';
	$stmt = $user_home->runQuery("SELECT f_unique,t_unique,time,status,msg,msg_tm,msg_by FROM friends WHERE (f_unique=:f_unique OR t_unique=:t_unique ) AND ( msg_tm!=:msg_tm OR status=:status ) ORDER BY msg_tm DESC");
	$stmt->execute(array(":f_unique"=>$_SESSION['IdSer'],":t_unique"=>$_SESSION['IdSer'],":status"=>$status,":msg_tm"=>$msg_tm)); 
	$all_post = $stmt->fetchAll(PDO::FETCH_ASSOC);
    	foreach($all_post as $ap){
    			$To='';
    		if($_SESSION['IdSer'] == $ap['f_unique']){
    		    
    		    $date_time = date('j F, Y', $ap['msg_tm']);
    			array_push($pa,array("c"=>$ap['t_unique'],"t"=>$ap['msg_tm'],"m"=>$ap['msg'],'date_time'=>$date_time));
    			$To = $ap['t_unique'];
    			$Dta.="'".$ap['t_unique']."',";
    		}
    		else if($_SESSION['IdSer'] == $ap['t_unique']){
    		    
    		    $date_time = date('j F, Y', $ap['msg_tm']);
    		    
    			array_push($pa,array("c"=>$ap['f_unique'],"t"=>$ap['msg_tm'],"m"=>$ap['msg'],'date_time'=>$date_time));
    			$To = $ap['f_unique'];
    			$Dta.="'".$ap['f_unique']."',";
    		}
    	
    	}
    	if($Dta){	
    		$Lf = rtrim($Dta,",");
    		$Arr = json_encode($pa,TRUE);
    	}

    	if($Lf){
			$user_unq =$_GET['id'];
			$stmt= $user_home->runQuery("SELECT user_unq,user_name,email,profile_pic FROM users WHERE user_unq IN ($Lf)");
			$stmt->execute();
			$userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$io=array();
			foreach($userRow as $oi){
				
				if($oi['profile_pic']!=""){
				    $profile_pic = $oi['profile_pic'];
				}else{
				    $profile_pic = "profile-default.png";
				}
				
				$io[$oi['user_unq']] = array('n'=>$oi['user_name'],'e'=>$oi['email'],'p'=>$profile_pic);	
			}
                
    
    		$JsA = json_encode($io,TRUE);	
    		
    		$stmt = $user_home->runQuery("SELECT message,timer,f_un,t_un FROM message WHERE (f_un=:f_un AND t_un=:t_un) OR (f_un=:f_una AND t_un=:t_una) ORDER BY `message`.`timer` DESC");
    		$stmt->execute(array(":f_un"=>$_SESSION['IdSer'],":t_un"=>$_GET['to'],":f_una"=>$_GET['to'],":t_una"=>$_SESSION['IdSer']));
    		$allst = $stmt->fetchAll(PDO::FETCH_ASSOC);
    		foreach($allst as $apnw){
    		    
    		    $date_time = date('j F, Y', $apnw['timer']);
    		    
    			array_push($Raa,array('m'=>$apnw['message'],'t'=>$apnw['timer'],'s'=>$apnw['f_un'],'date_time'=>$date_time ));
    		}	
    		$Ay = json_encode($Raa,TRUE);
    	}
	    echo $BY;
	    
	    $no_data = "";
?>
	
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.scrollbar/0.2.11/jquery.scrollbar.min.css" rel="stylesheet">
<style> 
body {
background-color: #e9e9e9;
}
#DashBx #DashBx-Lt-T {
	position: relative;
	background: #eee;
}
#DashBx #DashBx-Lt-T-mg {
	height: 60px;
	background: #aaa;
	background-size: cover;
}
.welcome .avatar {
	border-radius: 50%;
	height: 60px;
	width: 60px;
	top: -40px;
	position: absolute;
	left: 8px;
}
.avatar {
	display: inline-block;
	width: 80px;
	height: 80px;
	background-size: cover;
	background-position: center bottom;
}
#DashBxR {
	float: left;
	width: 280px;
	margin: 45px 0 0 10px;
}
div#FooBx {
	display: none;
}
#DashBx #DashBx-Lt-T h2 {
	margin: 0;
	font-size: 14px;
	line-height: 32px;
	text-align: center;
	position: absolute;
	top: -27px;
	left: 72px;
	font-weight: 600;
}
#DashBx #DashBx-Lt ul {
	margin: 0;
	padding: 0;
	list-style: none;
	border-top: 1px solid #ddd;
	background: #f2f2f2;
	margin-top: 22px;
}
#DashBx #DashBx-Lt ul li {
	line-height: 21px;
	padding: 5px;
	border-bottom: 1px solid #ddd;
}
#DashBx #DashBx-Lt ul li a {
}
#DashBx #DashBx-Lt-B {
	padding: 10px;
	overflow: hidden;
	text-align: center;
}
#DashBx #DashBx-Lt-B a {
	font-size: 11px;
	font-weight: 600;
	cursor: pointer;
}
#PstDa {
}
.MsgBxD {
	border-bottom: 1px solid #d3d3d3;
	position: relative;
	padding-left: 60px;
	height: 60px;
}
.MsgBxD .MsgBxD-T {
	padding: 0;
	position: relative;
	padding-top: 2px;
}
.MsgBxD .MsgBxD-T b {
	font-size: 13px;
	padding-left: 1px;
}

.MsgBxD .MsgBxD-T a img {
	width: 48px;
	height: 48px;

}
#PstDa h2 {
	font-size: 11px;
	text-align: center;
	margin: 0;
	padding: 5px;
	font-weight: 600;
}
.MsgCt .MsgCt-Tp {
	padding: 2px 3px;
	position: relative;
	line-height: 21px;
}
.MsgCt .MsgCt-Tp b {
}
.MsgCt .MsgCt-Tp span {
	font-size: 10px;
	font-weight: 600;
	display: block;
	line-height: 12px;
}
.MsgCt .MsgCt-Bt {
	border-top: 0;
	padding: 0 5px;
}
#MsgtSd {
	z-index: 5;
	background: #f0f0f0;
	padding: 15px;
}
#MsgtSd #TxtAr-Msg {
	width: 100%;
	resize: none;
	border: 1px solid #aaa;
	border-radius: 3px;
	min-height: 60px;
}
#MsgtSd div {
	overflow: hidden;
	margin-top: 5px;
}
#MsgtSd button {
	float: right;
	border: 1px solid #aaa;
	border-radius: 2px;
	cursor: pointer;
}
#MyProfile {
	height: auto;
	border: 1px solid #ddd;
	border-radius: 3px;
	text-align: center;
	padding: 10px 5px;
	margin: 0 0 12px;
}
#MyProfile div.img {
	background-size: cover;
	background-position: center;
	overflow: hidden;
	border-radius: 100%;
	display: block;
	width: 100px;
	margin: 0 auto;
	position: relative;
	height: 100px;
}
#MyProfile span {
	display: inline-block;
	line-height: 48px;
	font-size: 16px;
}
#MyProfile .AbTns {
	text-align: center;
}
#MyProfile .AbTns a {
	display: inline-block;
	border: 1px solid #337ab7;
	border-radius: 3px;
	font-size: 11px;
	padding: 2px 7px;
	width: 120px;
	margin: 0px 4px;
	text-decoration: none;
	cursor: pointer;
}
#LnkHdr {
	text-align: center;
}
#LnkHdr a {
	display: inline-block;
	color: #333;
	margin: 1px 5px;
	transition: unset;
	font-size: 13px;
	cursor: pointer;
}
#LnkHdr a:hover {
	text-decoration: none;
	color: #2ab4a1;
}
#Msg-DashBx-Rt #Msg-Ct {
	overflow-y: auto;
	bottom: 35px;
	top: 0;
}
#SearchBx {
	padding: 5px;
	border-bottom: 1px solid #ddd;
}
#SearchBx input {
	border: 1px solid #ddd;
	width: 100%;
	padding: 5px;
	border-radius: 2px;
}
.MsgBxD .new-msg {
	position: absolute;
	right: 8px;
	top: 8px;
	color: #add8e6;
	padding-top: 32px;
}
 @media screen and (min-width:1120px) and (max-width:1216px) {
#DashBx {
	width: 1112px;
}
#DashBxR {
	width: 200px;
}
#MyProfile .AbTns a {
	width: 80px;
}
}
 @media screen and (min-width:912px) and (max-width:1119px) {
#DashBx {
	width: 900px;
}
#DashBxR {
	display: none;
}
}
 @media screen and (min-width:320px) and (max-width:911px) {
#DashBx {
	width: 100%;
}
#DashBxL {
	width: 100%;
}

#Msg-DashBx-Rt #Msg-Ct {
	width: 100%;
}
#MsgtSd {
	width: 100%;
}
#DashBxR {
	display: none;
}
}
 @media screen and (min-width:608px) and (max-width:718px) {

.MsgBxD .MsgBxD-T a img {
	width: 28px;
	left: -30px;
	top: 10px;
	height: 28px;
}
#DashBx #Msg-DashBx-Rt {
	width: calc(100% - 160px);
	left: 160px;
}
.MsgBxD {
	padding-left: 34px;
	height: 48px;
}
.MsgBxD .MsgBxD-T b a {
	font-size: 11px;
}
.MsgBxD .MsgBxD-T span {
	bottom: -12px;
	left: 2px;
}
.MsgBxD .MsgBxD-B {
	position: absolute;
	bottom: 0px;
	display: none;
	font-size: 11px;
	left: 4px;
	
}
.MsgBxD .MsgBxD-T b {
	font-size: 11px;
	line-height: 26px;
}
}
 @media screen and (min-width:320px) and (max-width:607px) {
#DashBx #Msg-DashBx-Rt {
	width: 100%;
	left: 0;
}

}
#ShowMsgMb {
	display: none;
	position: fixed;
	left: 0px;
	z-index: 400;
	background: #32517c;
	color: #fff;
	height: 64px;
	width: 32px;
	border-radius: 0 6px 6px 0;
	overflow: hidden;
	top: 50%;
	margin-top: -80px;
	cursor: pointer;
}
</style>

<div class="message-section">
  <div class="container">
    <div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 " id="DashBx">
    <div class="new-designed">
  <div class="col-lg-5" id="DashBxL">
<?php 
if($Lf){
?>

<div id="ShowMsgMb"><i class="fa fa-envelope" aria-hidden="true"></i> <i class="fa fa-th-list" aria-hidden="true"></i></div>
<div id="Msg-DashBx-Ctr">
    <div class="recent-search">
    <h2>Recent</h2>
<div id="SearchBx"><input onkeyup="FtchLc()" placeholder="Search" type="text"/></div></div>
	<div id="PstDa">
		
	</div>
</div>
</div>
<div id="Msg-DashBx-Rt" class="col-lg-7">
    <div id="Msg-Ct"></div>
<?php	
	if($_GET['to'] != ''){
		echo '<div id="MsgtSd"><textarea id="TxtAr-Msg" placeholder="Write a message"></textarea> <div class="button"> <button>Send</button> </div></div>';
	}
	else{
		echo '<h2 style="text-align: center;text-transform: uppercase;font-size: 24px;">Select Your Friend And Talk</h2>';
	}
?>
	
</div>
</div>
<?php
}
else{
	$no_data = '<div class="DashBxL"><h1 class="connection" >First Make Some Connection</h1></div>';
}
?>



    <!--<div id="DashBxR">
    	<div id="MyProfile">
    		<div class="img" style="background-image:url('/profile_pic_image<?php //echo $_SESSION['profile_pic'];?>');"></div>
    		<span><?php //echo $_SESSION['user_name'];?></span>
    		<div class="AbTns">
    			<a href="/@<?php //echo $_SESSION['IdSer'];?>">Edit Profile</a>	
    			<a href="/my-connections">My Network</a>	
    		</div>	
    	</div>
    	
    	<div id="LnkHdr">
    	 <a href="/aboutus">About</a> 
    		<a href="/terms">Terms</a> <a href="/privacy">Privacy</a> <a href="/contact">Contact</a>			 		 			 
    	</div>	
    </div>-->

</div>
<?php echo $no_data; ?>

</div>
</div>
</div>
</div>

<?php } ?>		
	
<script>

		document.title = "Message Page";
		var Page = "<?php echo SITE_URL; ?>";
		var Usr = "<?php echo $_SESSION['IdSer']; ?>";
		var Ur = "<?php echo $_SESSION['user_name']; ?>";
		var To = "<?php echo $_GET['to']; ?>";
		var Js = <?php echo $Arr;?>;
		var JsA = <?php echo $JsA;?>;
		var PstDa='<h2>Message Friend List</h2><div id="insert-after"></div>';
		var Ay = <?php echo $Ay;?>;
		var MsgCt='';
		var userpic="<?php   if($_SESSION['profile_pic']!=""){ echo $_SESSION['profile_pic']; }else{ echo "profile-default.png"; }   ?>";
		if(To == '') window.location.href = Page+'message.php?to='+Js[0]['c'];	
		var MsgPageNt=1;
		var ToMsg = "<?php echo $_GET['to'];?>",Tmer = <?php echo time();?>;

			
			var c = $("#Msg-DashBx-Ctr");
			var x = window.matchMedia("(max-width:607px)");
			
			 if (x.matches) { 
			 

					$("#ShowMsgMb").show();
					$(document).mouseup(function(e){		
						if (!c.is(e.target) && c.has(e.target).length === 0) c.hide().css('width','0px;');
					});
					$("#ShowMsgMb").on('touch click',function(e){
						c.show().css('width','0px;');
					});	
			}
			else{
				
					$("#ShowMsgMb").hide();
			}
		
		
function TxtArCal(){
    var user_session = "<?php echo $_SESSION['IdSer']; ?>";
  
	var saveData = $.ajax({
	  type: 'POST',
	  url: Page+'',
	  data: {'ToMsg':ToMsg,'Tmer':Tmer,'type':'MsgShw'},
	  dataType: "text",
	  success: function(resultData){
			var Js = JSON.parse(resultData);
			var Sj = JSON.parse(Js['d']);
			for(var i in Sj){
			
				if(Sj[i]['s'] == Usr) Im = '<img src="profile_pic_image/'+userpic+'">';
				else Im = '<img src="profile_pic_image/'+JsA[Sj[i]['s']]['p']+'">';
				
				if(user_session==Sj[i]['current_user']){
				    var msg_right = "right";
				}else{
				    var msg_right = "";
				}
			
				$("#Msg-Ct").append('<div class="MsgCt '+msg_right+'" data-id="msg-'+Sj[i]['t']+'">'+Im+'<div class="message-right"><div class="message-area"><div class="MsgCt-Tp"><b>'+(Sj[i]['s'] == Usr ? Ur : JsA[Sj[i]['s']]['n'])+'</b> </div><div class="MsgCt-Bt">'+Sj[i]['m']+'</div></div><div class="time-area"><span>'+Sj[i]['date_time']+'</span></div></div></div>');
			}
			
			var objDiv = document.getElementById("Msg-Ct");
			objDiv.scrollTop = objDiv.scrollHeight;
			//Tmer=Js['date_time'];
			Tmer=Js['t'];
	  }
});
saveData.error(function() { alert("Something went wrong"); });	
}
 
function UpdateMsg(r){
	var j={},t={};
	
	
	
	for(var i=0;i<r.length;i++){
		if(!j[r[i]['user_unq']]) j[r[i]['user_unq']]={};
		j[r[i]['user_unq']]['t']=r[i]['msg_tm'];
		j[r[i]['user_unq']]['m']=r[i]['msg'];
		j[r[i]['user_unq']]['p']=r[i]['profile_pic'];
		j[r[i]['user_unq']]['n']=r[i]['user_name'];
		t[r[i]['msg_tm']]=r[i]['user_unq'];
		
		
		// ar
		j[r[i]['user_unq']]['date_time']=r[i]['date_time'];
	}
	
	for(var k in t){
		if($("#MsgBxD-"+t[k]).attr('data-value') != j[t[k]]['t']){
			if(t[k] == ToMsg){	
				TxtArCal();
			}
			
			// <div class="MsgBxD" id="MsgBxD-Sharvi" data-key="Sharvi" data-value="1568099101"><div class="MsgBxD-T"><a href="https://africafilmclub.com/message.php?to=Sharvi"><div class="profile-image"><img src="profile_pic_image/profile-default.png"></div><div class="MsgBxD-B"><h3> Sharvi jain </h3> <span>10 September, 2019</span><p>ggg</p></div></a></div></div> 
			
			
			$("#MsgBxD-"+t[k]).css('display','block');
			$("#MsgBxD-"+t[k]).attr('data-value',j[t[k]]['t']);
			
			
			
			$("#MsgBxD-"+t[k]+' .MsgBxD-B p').html(j[t[k]]['m']);
			
			
			// alert($("#MsgBxD-"+t[k]+' .MsgBxD-B p').html());
			
			//$("#MsgBxD-"+t[k]+' .MsgBxD-B span').attr('data-livestamp',j[t[k]]['t']);
			
			
			//alert(j[t[k]]['date_time']);
			
			
			
			$("#MsgBxD-"+t[k]).insertAfter('#insert-after');	
		}
		  if(!$("#MsgBxD-"+t[k]+' .new-msg').length) $("#MsgBxD-"+t[k]).append('<i class="fa new-msg fa-envelope" aria-hidden="true"></i>');
	}
	

	
	
} 
</script>	
	
	<?php include 'footer.php';?>
	
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/livestamp/1.1.2/livestamp.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.scrollbar/0.2.11/jquery.scrollbar.min.js"></script>
	<script>
	    var user_session = "<?php echo $_SESSION['IdSer']; ?>";
		for(var i=0;i<Ay.length;i++){
			var Im='';
			
			if(Ay[i]['s'] == Usr) Im = '<img src="profile_pic_image/'+userpic+'">';
			else{
				if(JsA[Ay[i]['s']]['p'] == ''){
					Im = '<img src="https://vignette.wikia.nocookie.net/bungostraydogs/images/1/1e/Profile-icon-9.png"/>';
				}
				else{	
					Im = '<img src="profile_pic_image/'+JsA[Ay[i]['s']]['p']+'"/>';
				}
			}
			
                if(user_session==Ay[i]['s']){
                    var msg_right = "right";
                }else{
                    var msg_right = "";
                }
			
			MsgCt='<div class="MsgCt '+msg_right+'" data-id="msg-'+Ay[i]['t']+'">'+Im+'<div class="message-right"><div class="message-area"><div class="MsgCt-Tp"><b>'+(Ay[i]['s'] == Usr ? Ur : JsA[Ay[i]['s']]['n'])+'</b> </div><div class="MsgCt-Bt">'+Ay[i]['m']+'</div></div><div class="time-area"><span >'+Ay[i]['date_time']+'</span></div></div></div>';
			
			
			$("#Msg-Ct").prepend(MsgCt);
			
		}
		
		
		
		
		$("#MsgtSd button").on('click',function(){
			// usr,type,msg,msgsnd
			
			if($("#MsgtSd textarea").val() == ''){
				alert('Enter The Message');
				return false;
			}
			
			var user_session = "<?php echo $_SESSION['IdSer']; ?>";
           
			
			var myKeyVals = { usr:Usr,msg:$("#MsgtSd textarea").val(),type:'msgsnd',to:To};
			var saveData = $.ajax({
				  type: 'POST',
				  url: Page+'',
				  data: myKeyVals,
				  dataType: "text",
				  success: function(resultData){
						var Js = JSON.parse(resultData);
						var Sj = JSON.parse(Js['d']);
						for(var i in Sj){
							if(Sj[i]['s'] == Usr) Im = '<img src="profile_pic_image/'+userpic+'">';
							else Im = '<img src="profile_pic_image/'+JsA[Sj[i]['s']]['p']+'">';
								
    					    if(user_session==Sj[i]['current_user']){
            				    var msg_right = "right";
            			        
            				}else{
            				    var msg_right = "";
            				}
            				
						    
							$("#Msg-Ct").append('<div class="MsgCt '+msg_right+'" data-id="msg-'+Sj[i]['t']+'">'+Im+'<div class="message-right"><div class="message-area"><div class="MsgCt-Tp"><b>'+(Sj[i]['s'] == Usr ? Ur : JsA[Sj[i]['s']]['n'])+'</b></div><div class="MsgCt-Bt">'+Sj[i]['m']+'</div></div><div class="time-area"><span >'+Sj[i]['date_time']+'</span></div></div></div>');
						}
						//Tmer=Js['date_time'];
						Tmer=Js['t'];
						// alert($("#MsgBxD-"+To).parent().attr('id'));
						
						$("#MsgBxD-"+To+' .MsgBxD-T span').attr('data-livestamp',Js['date_time']);
						$("#MsgBxD-"+To+' .MsgBxD-B p').html($("#MsgtSd textarea").val());
						$("#MsgtSd textarea").val('');
						var objDiv = document.getElementById("Msg-Ct");
						objDiv.scrollTop = objDiv.scrollHeight;
						
						var index= $("#MsgBxD-"+To).index();
						$data = $("#MsgBxD-"+To);
						$data.insertAfter($("#MsgBxD-"+To).parent().find("div").eq(0));
						
				  }
			});
			saveData.error(function() { alert("Something went wrong"); });	
			
		});
		
		
		
		var mug='';
		for(var i=0;i<Js.length;i++){
			var Msg='Start Chat With Hiii';
			
			mug='https://vignette.wikia.nocookie.net/bungostraydogs/images/1/1e/Profile-icon-9.png';
			if(JsA[Js[i]['c']]['p']) mug='profile_pic_image/'+JsA[Js[i]['c']]['p']+'';
			
	
			if(Js[i]['m'] != ''){
				Msg=Js[i]['m'];
	
				PstDa+='<div class="MsgBxD" id="MsgBxD-'+Js[i]['c']+'" data-key="'+Js[i]['c']+'" data-value="'+Js[i]['t']+'"><div class="MsgBxD-T"><a href="'+Page+'message.php?to='+Js[i]['c']+'"><div class="profile-image arjun2"><img src="'+mug+'"/></div><div class="MsgBxD-B"><h3> '+JsA[Js[i]['c']]['n']+' </h3> '+ ( (Js[i]['t'] != 0) ? '<span>'+Js[i]['date_time']+'</span>': '' )+'<p>'+Msg+'</p></div></a></div></div>';
				
			}
			else{
			    
			    PstDa+='<div style="display:none;" class="MsgBxD" id="MsgBxD-'+Js[i]['c']+'" data-key="'+Js[i]['c']+'" data-value="'+Js[i]['t']+'"><div class="MsgBxD-T"><a href="'+Page+'message.php?to='+Js[i]['c']+'"><div class="profile-image arjun1"><img src="'+mug+'"/></div><div class="MsgBxD-B"><h3> '+JsA[Js[i]['c']]['n']+' </h3> '+ ( (Js[i]['t'] != 0) ? '<span>'+Js[i]['date_time']+'</span>': '' )+'<p>'+Msg+'</p></div></a></div></div>';
			
				
			// old	
			//PstDa+='<div style="display:none;" class="MsgBxD" id="MsgBxD-'+Js[i]['c']+'" data-key="'+Js[i]['c']+'" data-value="'+Js[i]['t']+'"><div class="MsgBxD-T"><b><a href="'+Page+'message.php?to='+Js[i]['c']+'"><img src="'+mug+'"/>'+JsA[Js[i]['c']]['n']+'</b></a> '+ ( (Js[i]['t'] != 0) ? '<span>'+Js[i]['date_time']+'</span>': '' )+'</div><div class="MsgBxD-B">'+Msg+'</div></div>';
			}
		}
		
		$("#PstDa").html(PstDa);	
	
		function FtchLc(){
			var PstDa='';
		
			if($('#SearchBx input').val().length > 1){
				for(var i=0;i<Js.length;i++){
					
					mug='https://vignette.wikia.nocookie.net/bungostraydogs/images/1/1e/Profile-icon-9.png';
					if(JsA[Js[i]['c']]['p']) mug='profile_pic_image/'+JsA[Js[i]['c']]['p']+'';
					
					var query = jQuery('#SearchBx input').val();
					var stringToCheck=JsA[Js[i]['c']]['n'];
						if (stringToCheck.substr(0,query.length).toUpperCase() == query.toUpperCase()){
							var Msg='Start Chat With Hiii';
							if(Js[i]['m'] != ''){
								Msg=Js[i]['m'];
							}
							PstDa+='<div class="MsgBxD" id="MsgBxD-'+Js[i]['c']+'" data-key="'+Js[i]['c']+'" data-value="'+Js[i]['t']+'"><div class="MsgBxD-T"><a href="'+Page+'message.php?to='+Js[i]['c']+'"><div class="profile-image"><img src="'+mug+'"/></div><div class="MsgBxD-B"><h3>'+JsA[Js[i]['c']]['n']+'</h3> '+ ( (Js[i]['t'] != 0) ? '<span >'+Js[i]['date_time']+'</span>': '' )+'<p>'+Msg+'</p></div></a></div></div>';
						}
						else{
							PstDa+='<div class="MsgBxD" style="display:none;" id="MsgBxD-'+Js[i]['c']+'" data-key="'+Js[i]['c']+'" data-value="'+Js[i]['t']+'"><div class="MsgBxD-T"><a href="'+Page+'message.php?to='+Js[i]['c']+'"><div class="profile-image"><img src="'+mug+'"/></div><div class="MsgBxD-B"><h3>'+JsA[Js[i]['c']]['n']+'</h3> '+ ( (Js[i]['t'] != 0) ? '<span >'+Js[i]['date_time']+'</span>': '' )+'<p>'+Msg+'</p></div></a></div></div>';
						}
				}
					$("#PstDa").html(PstDa);				
			}
			else{
				for(var i=0;i<Js.length;i++){
					
					mug='https://vignette.wikia.nocookie.net/bungostraydogs/images/1/1e/Profile-icon-9.png';
					if(JsA[Js[i]['c']]['p']) mug='profile_pic_image/'+JsA[Js[i]['c']]['p']+'';
			
					var Msg = 'Start Chat With Hiii';
						if(Js[i]['m'] != ''){
							Msg=Js[i]['m'];
							PstDa+='<div class="MsgBxD" id="MsgBxD-'+Js[i]['c']+'" data-key="'+Js[i]['c']+'" data-value="'+Js[i]['t']+'"><div class="MsgBxD-T"><a href="'+Page+'message.php?to='+Js[i]['c']+'"><div class="profile-image"><img src="'+mug+'"/></div><div class="MsgBxD-B"><h3>'+JsA[Js[i]['c']]['n']+'</h3> '+ ( (Js[i]['t'] != 0) ? '<span>'+Js[i]['date_time']+'</span>': '' )+'<p>'+Msg+'</p></div></a></div></div>';
						}
						else{
							PstDa+='<div style="display:none;" class="MsgBxD" id="MsgBxD-'+Js[i]['c']+'" data-key="'+Js[i]['c']+'" data-value="'+Js[i]['t']+'"><div class="MsgBxD-T"><a href="'+Page+'message.php?to='+Js[i]['c']+'"><div class="profile-image"><img src="'+mug+'"/></div><div class="MsgBxD-B"><h3>'+JsA[Js[i]['c']]['n']+'</h3> '+ ( (Js[i]['t'] != 0) ? '<span>'+Js[i]['date_time']+'</span>': '' )+'<p>'+Msg+'</p></div></a></div></div>';
						}
				}

				$("#PstDa").html(PstDa);
			}	
		}

var h = document.documentElement.clientHeight - 107;
$("#DashBxL").css('height',h);


var h = document.documentElement.clientHeight - 209;
$("#Msg-Ct").css('height',h);

var objDiv = document.getElementById("Msg-Ct");
objDiv.scrollTop = objDiv.scrollHeight;


</script>



	</body>
</html>