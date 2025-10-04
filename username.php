<?php
session_start();
require_once 'main-class.php';
$user_home = new USER();

$user_id = $_SESSION['user_id'];

if(isset($_POST['submit'])){
    $user_unq = $_POST['user_unq']; 
    
    if(preg_match("/^[a-zA-Z0-9]+$/",$user_unq)){
        
    $username = $user_home->runQuery("SELECT user_id,user_unq FROM users WHERE user_id!=:user_id and user_unq=:user_unq");
    $username->execute(array(":user_id"=>$user_id,":user_unq"=>$user_unq));
    $userRow6 = $username->fetchAll(PDO::FETCH_ASSOC);

    if(!empty($userRow6)){
        echo 'already exists';
    }
    else{
        $stmt = $user_home->runQuery("UPDATE users SET user_unq=:user_unq WHERE user_id=:user_id");
        $stmt->bindParam(':user_unq',$user_unq);
        $stmt->bindParam(':user_id',$user_id);
        if($stmt->execute()){
            $msg_notify = 'info update succcesfully';
            $_SESSION['IdSer'] = $user_unq;
        }
		else{
            $msg_notify = 'something went wrong';

        }
    }
  }else{
      
      echo '<script>alert("Only Char And Number");</script>';
  }
}



if($_SESSION['IdSer'] != ''){
      $Pt = SITE_URL;
      $user_home->redirect(''.$Pt.'profile_info.php?id='.$_SESSION['IdSer'].'');
      exit();
}
 
//print_r($_SESSION);
 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id" content="<?php echo GMAIL_LOGIN_CLIENT_ID; ?>">
    <title>User Name</title>
    
    <!-- Bootstrap -->
    <link href="<?php echo SITE_URL;?>css/bootstrap.min.css" rel="stylesheet"/>
	<link href="<?php echo SITE_URL;?>css/style.css" rel="stylesheet"/>
    <link href="<?php echo SITE_URL;?>css/font-awesome.min.css" rel="stylesheet"/>
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="<?php echo SITE_URL; ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
    
    
    
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo SITE_URL;?>js/bootstrap.min.js"></script>

    <script src="<?php echo SITE_URL; ?>js/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo SITE_URL; ?>js/bootstrap-datetimepicker.fr.js"></script>
<style>
.user_unique{
      margin: 0;
    padding: 173px 0 50px;
    width: 100%;
    text-align: center;
  }
  .main_div {
    margin: 0 auto;
    max-width: 31%;
}

footer,.navigation{background:#32517c}
footer a{color:#fff;}
footer a:hover{color:#111;}
</style>



  </head>
<body>
<nav class="navbar navbar-inverse navbar-static-top navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="<?php echo SITE_URL;?>images/@logo.png" alt="img"/></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
	    
<style>
 li.li-pdng{}
 li.li-pdng a.li-pdng-a{padding: 10px 15px;}
 li.li-pdng a.li-pdng-a i.fa{font-size:28px;}
</style>

          
            <li class="btn_nav"><a onclick="signOut();" href="logout">Logout</a></li>
  
          </ul>
        </div>
      </div>
</nav>

  
<div class="container">
  <div class="main_div">
  <div class="user_unique">
  <h2>Enter Your Unique Name</h2> This option is for first time  only
   <form method="post" action="" >

     
    <div class="">
    <div class="form-group">
    <label for="username"></label>
      <input type="text" class="form-control" id="user_unq" placeholder="Enter username" name="user_unq"  maxlength="13">
    </div>
  

  
 
    </div>
      
    <div class="form-group">
    <button type="submit" class="btn btn-default" name="submit">Submit</button>
    </div>
    </form>
</div>
</div>
</div>

   <?php include 'footer.php';?>


	</body>

</html>