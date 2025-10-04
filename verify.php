<?php
session_start();
require_once 'main-class.php';
$user_home = new USER();


	if($user_home->is_logged_in()){
		 $user_home->redirect('index.php');
	}

	$stmt = $user_home->runQuery("SELECT * FROM users WHERE user_id=:uid");
	$stmt->execute(array(":uid"=>$_SESSION['user_id']));
	$rwdt = $stmt->fetch(PDO::FETCH_ASSOC);


$MsgEr = '';
if(isset($_GET['user_mail'])){
	if($_GET['user_mail'] != ''){
		$stmt = $user_home->runQuery("SELECT user_name,created_at,verify,token,email,token_type FROM users WHERE email=:email");
		$stmt->execute(array(":email"=>$_GET['user_mail']));
		$rwdt = $stmt->fetch(PDO::FETCH_ASSOC);
		$Tmt = $rwdt['token_type'];
		$UsrNm = $rwdt['user_name'];
		if($stmt->rowCount() == 1){
			if($rwdt['token'] == $_GET['token']){
				   $MsgSu='Your Account has been verified Now login <a href="/">Click Here</a>';
					$Tm=time();	
						$verify=1;	
						 $stmt = $user_home->runQuery("UPDATE users SET verify=:verify WHERE email=:email");
						 $stmt->execute(array(":verify"=>$verify,":email"=>$rwdt['email']));
			}
			else{
				if($rwdt['verify'] == 0){
					
					$token_type = time(); 

					
					
					if( ($Tmt+60) <= $token_type){
						$stmt = $user_home->runQuery("UPDATE users SET token_type=:token_type WHERE email=:email");
						 $stmt->execute(array(":token_type"=>$token_type,":email"=>$rwdt['email']));
					}
						 
					 $Bhvn = 'https://www.africafilmclub.com/verify.php?user_mail='.$rwdt['email'].'&token='.$rwdt['token'].'';
				    
				        $Tot = $_GET['user_mail'];
						$MsgSu=' <b> Thank you for signing up! </b> We have sent you an activation email. Please check your email inbox and click the link in the email to complete the sign up process.';
						$Hdr='We\'re required to put websites on hold if we can\'t verify the email address on file.';
						$subject='Please verify your email address';
						$Msg='Please Click Here To verify your email address <br/><br/> <a href="'.$Bhvn.'" style="border-radius:3px;color:#00a63f;text-decoration:none;background-color:#00a63f;border-top:14px solid #00a63f;border-bottom:14px solid #00a63f;border-left:14px solid #00a63f;border-right:14px solid #00a63f;display:inline-block;border-radius:3px" target="_blank">
						    <font style="font-size:18px;line-height:22px" face="\'Boing-Bold\', \'Arial Black\', Arial, sans-serif" color="#FFFFFF">
						            Verify Email Address
						    </font></a>';
						
						$httpReferer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;		
							
							
						if( (($Tmt + 60) <= $token_type) || ($httpReferer == 'https://www.africafilmclub.com/index.php' || $httpReferer = 'https://www.africafilmclub.com/' || $httpReferer = 'https://www.africafilmclub.com')){
						
							$user_home->send_mail($Tot,$subject,$Hdr,$Msg,$UsrNm);
							$MsgSu.='<div id="timer" style="display:none;">If You haven\'t received the mail <a href="https://www.africafilmclub.com/verify.php?user_mail='.$rwdt['email'].'">Click Here</a></div>';
						}
						else{
							$MsgSu.='<div id="timer">Please Wait For 1 Minute</div>';
							$Chng='If You have not received the mail <a href="https://www.africafilmclub.com/verify.php?user_mail='.$rwdt['email'].'">Click Here</a>';
						}
							
				}
				else if($rwdt['verify'] == 1){
					$MsgSu='Account already had verified For login <a href="/">Click Here</a>';	
				}
			}	
		}
		else{
			$user_home->redirect('/');
			$MsgSu='Account already had verified For login <a href="/">Click Here</a>';	
		}
	}
	else{
		$user_home->redirect('/');
		
	}
}
else{
	 $user_home->redirect('/');
}
	
?>	


<!DOCTYPE html>
<html>
	<head>
		<title>Verify Account</title>
		
		<style>
		
		#timer{}
		#timer div a{}
		
		
				.Err-Msg{
				background: #ff5858;
				color: #fff;
				padding: 6px;
				border-radius: 4px;
				text-align: center;
				text-transform: uppercase;
				margin-bottom: 15px;				
			}
			
			.peer,.peer button{
				width:100%
			}
			
			.Err-Msg a{
				color: #000;
				font-weight: 600;	
			}
			
			#Fotr{text-align: center;margin: 10px;}

			#Cntr-lk{text-align: center;}
			#Cntr-lk a{margin: 0 10px;}
			
			.text-dark{
				font-weight: 600;
			}
			
			#loader{
				transition:all .3s ease-in-out;opacity:1;visibility:visible;position:fixed;height:100vh;width:100%;background:#fff;z-index:90000;}
			#loader.fadeOut{
				opacity:0;visibility:hidden;
			}
			.spinner{
				width:40px;height:40px;position:absolute;top:calc(50% - 20px);left:calc(50% - 20px);background-color:#333;border-radius:100%;-webkit-animation:sk-scaleout 1s infinite ease-in-out;animation:sk-scaleout 1s infinite ease-in-out;
			}
			@-webkit-keyframes sk-scaleout{
				0%{
					-webkit-transform:scale(0);
				}
				100%{
					-webkit-transform:scale(1);opacity:0;
				}
			}
			
			
			
	   
			@keyframes sk-scaleout{
				0%{
					-webkit-transform:scale(0);transform:scale(0);
				}
				100%{
				-webkit-transform:scale(1);transform:scale(1);opacity:0;
				}
			}
			
			#ico-btm{
				position: absolute;
				bottom: 60px;
				left: 70px;right: 70px;
			}
			
			#ico-btm span{
				float: right;
				color: #fff;
				font-size: 12px;
				font-weight: 600;
				line-height: 34px;
			}

			#Fm-Hdr h2{
				margin-bottom: 14px;
				text-align: center;
				color: #5244d4;
				font-size: 30px;
				font-weight: 700;
				line-height: normal;
				text-align:left;
			}	
			
			#Fm-Hdr p{text-align:left;}
			
			form .form-control{
				border: none;
				outline: none;
				margin: 0 3px;
				width: 302px;
				text-align: center;
			}
			
			
			#Fix-IT{
				background: #32517c;
				max-width: 360px;
				border-radius: 4px;
				margin: 60px auto;
				color: #fff;
				width: 100%;
			}
			
			#Fix-IT h2{
				text-align: center;
				font-size: 20px;
				color: #fff;
				line-height: 60px;
			}
			
			#Fix-IT-T{   padding: 0 22px 30px;}
			#Fix-IT-T form{margin: 0px 5px;}
			
			#Fix-IT-B{min-height: 160px;background:#32517c;}
			
			
			.rc-anchor-logo-portrait{margin: 5px 10px;width: 58px;}
			.rc-anchor-normal .rc-anchor-p{
				margin: 2px 28px 0 0;
			}
			
			.rc-anchor-normal-footer {
				display: inline-block;
				height: 74px;
				vertical-align: top;
				width: 74px;
			}
			
			.rc-anchor-normal .rc-anchor-pt {
				margin: 2px 28px 0 0;
				padding-right: 2px;
				position: absolute;
				right: 0px;
				text-align: right;
				width: 276px;
			}
			
			.rc-anchor-normal .rc-anchor-content {height: 74px;width: 206px;}
			
			form .form-group button{width: 212px;margin: 0 46px;text-transform: uppercase;padding: 4px 0px 7px;cursor:pointer;}
			
			
			.rc-anchor-normal .rc-anchor-checkbox-label {width:120px;}
			
			
			.g-recaptcha iframe{border-radius: 8px 8px 10px 10px;}
			
				#Fix-IT-B{
						position: relative;border-radius: 0 0 4px 4px;
					}
					#LgBxIg{position: absolute;left: 50%;width: 102px;height: 48px;margin-left: -49px;top: -28px;}	
					#LgBxIg img{}	
				
					#Cntr-SnWl{padding-top: 35px;text-align: center;}
					#Cntr-SnWl a{background: #aaa;
						width: 212px;
						display: inline-block;
						margin: 5px;
						padding: 5px 0px 7px;
						border-radius: 4px;
						font-weight: 600;
						cursor: pointer;
					}
					#Cntr-lk{}
					#Cntr-lk a{
						display: inline-block;
						margin: 0px;
						font-weight: 600;
						cursor: pointer;
					}
		</style>
		<link href="https://colorlib.com/polygon/adminator/style.css" rel="stylesheet"/>
		
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
			
	</head>
	
	<body class="app">
	
		
		
		
		<div class="peers ai-s fxw-nw h-100vh">
			<div class="peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv">
					
                    
			<div id="Fix-IT">
				
				<h2>Verify Account</h2>

				<div id="Fix-IT-T" style="padding: 0px 20px 50px;">
					<?php echo $MsgSu; ?>
				</div>
				<div id="Fix-IT-B" style="min-height:auto;padding:35px 0 25px;">
					<div id="LgBxIg">
						<img src="<?php echo SITE_URL; ?>images/africa logo01.png"/>
					</div>
				
					<div id="Cntr-lk">
						Click Here For <a class="link" target="_blank" href="index.php"> Login </a>
					</div>				
									
					<div id="Fotr">				
							
					</div>				
				</div>
			</div>
	</div>

					
					
		
		<script type="text/javascript" src="https://colorlib.com/polygon/adminator/vendor.js"></script>
		<script type="text/javascript" src="https://colorlib.com/polygon/adminator/bundle.js"></script>
		<script>
			var Tmt=<?php echo $Tmt;?>,token_type=<?php echo $token_type;?>;
			var Chng = '<?php echo $Chng;?>';

			if($("#timer").css('display') == 'none'){
				let x=0;
				window.setInterval(function(){
					if(token_type == Tmt){
						$("#timer").show();
						x=1;
					}
					Tmt++;	
				}, 1000);
			}
			else if($("#timer").css('display') == 'block'){
				let x=0;
				window.setInterval(function(){
					if(token_type == Tmt){
						$("#timer").html(Chng).show();
						x=1;
					}
					Tmt++;	
				}, 1000);
			}
		</script>
		 
	</body>
</html>
