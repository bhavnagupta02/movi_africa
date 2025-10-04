<?php
session_start();
require_once 'main-class.php';
$user_home = new USER();

/*
	$stmt = $user_home->runQuery("SELECT * FROM users WHERE user_id=:uid");
	$stmt->execute(array(":uid"=>$_SESSION['user_id']));
	$rwdt = $stmt->fetch(PDO::FETCH_ASSOC);

	if($user_home->is_logged_in()){ 
		$user_home->redirect('dashboard');
	}
*/

$MsgEr = '';
		
		$stmt = $user_home->runQuery("SELECT * FROM security_2fa WHERE device_cookies=:user_id AND token=:token AND login = 0 AND 2fa_status = 0");
		$stmt->execute(array(":user_id"=>$_GET['email'],":token"=>$_GET['token']));
		$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
		if($stmt->rowCount() == 1){
			
			$Msg='Enter That Code On Authentication Page To First Time Login : <code>'.$userRow['code'].'</code>';
			
			$user_home->send_mail($_GET['email'],'Authentication Code','Code Will Expire Within 7 Day',$Msg);
			
			$cookie_name=str_replace(".","_",$userRow['device_cookies']);
			
			
			if($_COOKIE[$cookie_name] != ''){
						
			}
			
			$Auth = $_COOKIE[$cookie_name];
		}		

			if(isset($_POST)){
				if($_POST['auth_code'] != ''){		
					   // $Auth,$userRow['device_cookies'],$userRow['token'],$_POST['auth_code']
					$stmt = $user_home->runQuery("SELECT * FROM security_2fa WHERE device_cookies=:user_id AND token=:token AND login = 0 AND 2fa_status = 0 AND code = :code");
					$stmt->execute(array(":user_id"=>$_GET['email'],":token"=>$_GET['token'],":code"=>$_POST['auth_code']));
					$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
					if($stmt->rowCount() == 1){
						// Code Found And Match Then
						$stmt = $user_home->runQuery("UPDATE security_2fa SET device_cookies=:device_cookies,login='1',2fa_status='1',token='Done',Code='Sent',active=:active 
						WHERE 
						token=:token_gt AND device_cookies=:email");
						
						$Tm=time();
						
						$stmt->execute(array(":device_cookies"=>$Auth,":token_gt"=>$_GET['token'],":email"=>$_GET['email'],":active"=>$Tm));
						
						$stmt2 = $user_home->runQuery("SELECT * FROM users WHERE email=:email_id");
			            $stmt2->execute(array(":email_id"=>$_GET['email']));
			            $YrRow=$stmt2->fetch(PDO::FETCH_ASSOC);
						
					//	echo "Starting session with".$YrRow['user_id'];
						
							$_SESSION['user_id'] 	 			=  $YrRow['user_id'];
							$_SESSION['user_name']       		=  $YrRow['user_name'];
							$_SESSION['email']    	 			=  $YrRow['email'];
							$_SESSION['status']      			=  $YrRow['status'];
							$_SESSION['last_seen']      		=  $YrRow['last_seen'];
							$_SESSION['profile_pic']      		=  $YrRow['profile_pic'];	
							$_SESSION['profile_pic']      		=  $YrRow['profile_pic'];	
							 $_SESSION['IdSer'] = $YrRow['user_unq'];	
							
							
							//echo '<br>';
						//echo "Session Started.";	
							 $user_home->redirect('index.php');
						     //print_r($_SESSION);	
					}
					else{
						// Code Not Match 
						
					}		
				}		
			}
?>	


<!DOCTYPE html>
<html>
	<head>
		<title>Authentication Code</title>
		
		<style>
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
			}	#Fix-IT p{
	            color:#fff !important;
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
				background: #3e3e5f;
				width: 360px;
				border-radius: 4px;
				margin: 60px auto;
			}
			
			#Fix-IT h2{
				text-align: center;
				font-size: 20px;
				color: #fff;
				line-height: 60px;
			}
			
			#Fix-IT-T{padding: 0 22px 30px;}
			#Fix-IT-T form{margin: 0px 5px;}
			
			#Fix-IT-B{min-height: 160px;background: #fff;}
			
			
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
					#LgBxIg{position: absolute;left: 50%;width: 48px;height: 48px;margin-left: -32px;top: -28px;}	
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
						color: #111;
						font-size: 11px;
						margin: 0px;
						font-weight: 600;
						cursor: pointer;
					}
		</style>
				
		
		
		<link href="https://colorlib.com/polygon/adminator/style.css" rel="stylesheet"/>
		<script src='https://www.google.com/recaptcha/api.js'></script>	
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script>
    			  $(document).ready(function(){
					$(".round_text").focus(function(){
						//alert(3);
						$(this).parent().toggleClass('is_focused');
					});
					$(".round_text").blur(function(){
						//alert(2);
						$(this).parent().toggleClass('is_focused');
					});
				});
			  
</script>
	</head>
	
	<body class="app" style="background-image:url('http://www.rockethub.com/images/mat-welcome.jpg');background-size:cover;background-repeat:no-repeat;background-attachment:fixed;">
		<div id="loader"><div class="spinner"></div></div>
		
		<script type="text/javascript">
			window.addEventListener('load', () => {
				const loader = document.getElementById('loader');
				setTimeout(() => {
					loader.classList.add('fadeOut');
				}, 300);
			});
		</script>
		
		<div class="peers ai-s fxw-nw h-100vh">
			<div class="peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv">
					
                    
			<div id="Fix-IT">
				
				<h2>Authentication Code</h2>
				<p style="text-align:center;">We Send You At Your Email Address</p>
			<div id="Fix-IT-T">
				
<?php echo $MsgEr; ?>
				<form method="POST">
					
					<div class="form-group form_round">
						
						<input type="text" class="form-control round_text" name="auth_code" style="-webkit-box-shadow: unset; box-shadow: unset;" placeholder="Authentication Code"/>
					</div>
					
					<div class="form-group">
						<div class="peers ai-c jc-sb fxw-nw">
							<div class="peer">
								<button class="btn btn-primary">Submit Code</button>
							</div>
						</div>
					</div>
					
				</form>	

			</div>
				
				<div id="Fix-IT-B" style="min-height: auto;padding: 35px 0 10px;">
					<div id="LgBxIg">
						<img src="<?php echo SITE_URL; ?>images/logo-web.png"/>
					</div>
					<div id="Cntr-lk">
						
					</div>	
				</div>		
				
			</div>
	</div>
</div>
					
					
		
		<script type="text/javascript" src="https://colorlib.com/polygon/adminator/vendor.js"></script>
		<script type="text/javascript" src="https://colorlib.com/polygon/adminator/bundle.js"></script>
		<script src="https://www.google.com/recaptcha/api.js?render=6Lc3EGIUAAAAAE0mzgcXpx_b4ZhqobGhbnTL0Yy8"></script>
		  <script>
			  grecaptcha.ready(function() {
				  grecaptcha.execute('6Lc3EGIUAAAAAE0mzgcXpx_b4ZhqobGhbnTL0Yy8', {action: 'homepage'}).then(function(token) {
					 ...
				  });
			  });
			  
		  </script>
	</body>
</html>
