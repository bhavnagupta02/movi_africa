<?php
session_start();
require_once 'main-class.php';
$user_home = new USER();

if($user_home->is_logged_in()){ 
    $user_home->redirect('index.php');
}

    $user_email = base64_decode($_GET['token']);
    $stmt = $user_home->runQuery("SELECT user_id,email,reset_status FROM users WHERE email=:email_id");

    $stmt->bindparam(":email_id",$user_email);
    $stmt->execute();


    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
    

    if($stmt->rowCount() == 1){

        if(isset($_POST['submit'])){

            if($userRow['reset_status']=='1'){

                
                $password = md5($_POST['password']);
                $reset_status = 0; 

                $user_id = $userRow['user_id'];

                $stmt2 = $user_home->runQuery("UPDATE users SET reset_status=:reset_status,password=:password WHERE user_id=:user_id");
            
                $stmt2->bindparam(":user_id",$user_id);
                $stmt2->bindparam(":reset_status",$reset_status);
                $stmt2->bindparam(":password",$password);
                
                if($stmt2->execute()){
                    $_SESSION['succ_message'] = "Password change successfully";
                }else{
                    $_SESSION['error_message'] = "Please try again";
                } 
            }else{
                $_SESSION['error_message'] = "Reset Password link expired";
            }    
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
    <title>Reset Password</title>

    <!-- Bootstrap -->
    <link href="css-new/bootstrap.min.css" rel="stylesheet">
    <link href="css-new/style.css" rel="stylesheet">
    <link href="css-new/font-awesome.min.css" rel="stylesheet">
   
    <link rel="icon" href="images/icon.png" type="image/png" sizes="16x16">
    

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


    .error {
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
 
  <div class="password_forgot">
    <span class="success_message">
        <?php if(isset($_SESSION["succ_message"])) { echo $_SESSION["succ_message"]; unset($_SESSION["succ_message"]); }?> 
    </span>
    <span class="error_message">
        <?php if(isset($_SESSION["error_message"])) { echo $_SESSION["error_message"]; unset($_SESSION["error_message"]);}?> 
    </span>
    <div class="error"></div>
    
    <h2>Reset Password</h2>
    
    <form method="post" action="" >

   
        <div class="forgot_email_sec">
            <div class="form-group">
                <input class="form-control" required id="new_password" placeholder="Password" type="password" name="password" autocomplete="off"> 
            </div>
         
         
            <div class="form-group">
                <input class="form-control" required id="repeat_new_password" placeholder="Confirm Password" type="password" name="repeat_new_password" autocomplete="off"> 
            </div>
         
        </div>
   
   
    <div class="form-group">
   <button class="btn btn-primary" name="submit" id="submit">Submit</button>
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
 

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script>
    var allowsubmit = false;
    $(function(){
        //on keypress 


        //$('#new_password,#repeat_new_password').keyup(function(e){
        $('#new_password,#repeat_new_password').on('keyup focusout blur keydown', function(e) {
            //get values 
            var password = $('#new_password').val();
            var repeat_new_password = $(this).val();
           //alert(password.length);
            //check the strings
            if(password == repeat_new_password){
     
                //if both are same remove the error and allow to submit
                $('.error').text('');
                allowsubmit = true;
                 $('#submit').prop('disabled', false);
            }else{

                //if not matching show error and not allow to submit
                $('.error').text('Password not matching');
                allowsubmit = false;
            
              $('#submit').prop('disabled', true);

            }
            
            if(password.length==repeat_new_password.length){
                allowsubmit = true;
                $('#submit').prop('disabled', false);
            }else{
                allowsubmit = false;
                $('#submit').prop('disabled', true);
            }
            
        });
        
       
    });
    </script>
 </body>
</html>