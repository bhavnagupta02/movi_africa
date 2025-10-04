<?php
session_start();
require_once 'main-class.php';
$user_home = new USER();

if($user_home->is_logged_in()){ 
    $user_home->redirect('index.php');
}

if(isset($_POST['submit'])){
    if($_POST['email'] != ''){

            $user_email = trim($_POST['email']);
            $reg_type = "email";
            $admin_control = 0;
 

            $stmt = $user_home->runQuery("SELECT user_id,email FROM users WHERE email=:email_id AND reg_type=:reg_type AND admin_control=:admin_control ");
            $stmt->bindparam(":reg_type",$reg_type);
            $stmt->bindparam(":email_id",$user_email);
            $stmt->bindparam(":admin_control",$admin_control);
            $stmt->execute();
            
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            $user_id = $userRow['user_id'];
            $reset_status = 1;
            
            if($stmt->rowCount() == 1){
                $stmt2 = $user_home->runQuery("UPDATE users SET reset_status=:reset_status WHERE user_id=:user_id");
            
                $stmt2->bindparam(":user_id",$user_id);
                $stmt2->bindparam(":reset_status",$reset_status);
                if($stmt2->execute()){

                

                    $reset_password = SITE_URL.'reset-password.php?token='.base64_encode($user_email).' ';

                    $to = $user_email;
                    $subject = "Reset Password";
                    
                    $message = "
                    <html>
                    <head>
                    <title>Reset Password</title>
                    </head>
                    <body>
                    <div style='text-align:center; '><img style='max-width: 10%; width: 135px; padding: 0 0 10px 0px; clear: both; margin: 30px auto 0px;' src= '".SITE_URL."images/africa-logo.PNG'></div>
                    <table style='width:100%;'>
                    <tr>
                    <th><h1 style='padding:0 0 0 0;'>Welcome to ".SITE_NAME."</h1></th>
                    </tr>
                    <tr>
                    <th>Reset your password by clicking below the link.</th>
                    </tr>
                    <tr>
                    <th><a style='background: green;color: #fff;text-decoration: none;display: inline-block;margin: 20px 0 0;padding: 2px 25px;border-radius: 30px;text-transform: uppercase;' href='".$reset_password."' >Click here to reset password </a> </th>
                    </tr>
                    </table>
                    </body>
                    </html>
                    ";
                    
                    // Always set content-type when sending HTML email
                    $headers = "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    
                    // More headers
                    $headers .= 'From: '.SITE_NAME.'<'.FROM_EMAIL.'>' . "\r\n";
                    
                    if(mail($to,$subject,$message,$headers)){
                        $_SESSION['succ_message'] = "Reset password link send to your email";
                    }else{
                        $_SESSION['error_message'] = "Please try again";
                    }

                }
            }else{
                $_SESSION['error_message'] = "Email not found";
            }
            
            
            
    }
	else{
        $user_home->redirect('forget-password');
    }	
}
?>	
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Forget Password</title>

    <!-- Bootstrap -->
    <link href="css-new/bootstrap.min.css" rel="stylesheet">
    <link href="css-new/style.css" rel="stylesheet">
    <link href="css-new/font-awesome.min.css" rel="stylesheet">
    <script src='https://www.google.com/recaptcha/api.js'></script> 
    
    
    
    <link rel="icon" href="images/icon.png" type="image/png" sizes="16x16">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        .g-recaptcha iframe{border-radius: 8px 8px 10px 10px;}

    .outer_password_custom {

    text-align: center;

    }
    .outer_password_custom .main_div {

    margin: 0 auto;
    max-width: 302px;
    height: 100vh;
    }

form .form-group button {

    width: 212px;
    margin: 0 46px;
    text-transform: uppercase;
    padding: 4px 0px 7px;
    cursor: pointer;

}

    span.success_message {
        color: green;
    }
    span.error_message {
        color: red;
    }


    </style>

  </head>
  <body>
  

<!--------------- SIGN UP --------------->
<section class="sign_form outer_password_custom">
 <div class="container">
  <div class="row">
   <div class="main_div">
   <!-- <div class="col-sm-6 left_sec">
   <img src="images/africa.png" alt="img"/>
    <h2>Opportunity for African film producers, directors and writers.</h2>
    <p>The Africa Film Club is a platform for people looking to connect with African producers, directors and writers to bring film ideas to the big screen.</p>
   </div> -->
  <div class="password_forgot">
    <span class="success_message">
        <?php if(isset($_SESSION["succ_message"])) { echo $_SESSION["succ_message"]; unset($_SESSION["succ_message"]); }?> 
    </span>
    <span class="error_message">
        <?php if(isset($_SESSION["error_message"])) { echo $_SESSION["error_message"]; unset($_SESSION["error_message"]);}?> 
    </span>
    
    
    <h2>Forget Password</h2>
    
    <form method="post" action="" >

   
        <div class="forgot_email_sec">
            <div class="form-group">
                <input class="form-control" id="exampleInputEmail1" placeholder="Email" type="email" name="email" autocomplete="off" required> 
            </div>
         
        </div>
   
   
    <div class="form-group">
   <button class="btn btn-primary" name="submit">Submit</button>
    </div>
    </form>
   </div>
   
   <div id="">
   <img src="<?php echo SITE_URL; ?>images/africa-logo.PNG"/>
   </div>
    <div id="">
     Already have an account ? <a href="/">Sign In</a>    
   </div>              
                                        


  </div>
  </div>
 </div>
</section>

<!--------------- SIGN UP END --------------->




<!--- FOOTER --->
<!-- <footer class="footer">
 <div class="container">
  <div class="row">
 <p>Copyright © Africa Film Club | All Aright Reserved</p>
  </div>
 </div>
</footer> -->
  

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script>
              grecaptcha.ready(function() {
                  grecaptcha.execute('6Lc3EGIUAAAAAE0mzgcXpx_b4ZhqobGhbnTL0Yy8', {action: 'homepage'}).then(function(token) {
                     ...
                  });
              });
              
          </script>
 </body>
</html>