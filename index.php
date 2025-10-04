<?php include 'header.php';
    
   /* if($user_home->is_logged_in()){ 
        $user_home->redirect('/@'.$_SESSION['IdSer']);
    }
    */
    
	$MsgEr = '';

if(isset($_POST)){
	if($_POST['sign_name_f'] != '' && $_POST['sign_name_l'] != '' && $_POST['sign_email'] != '' && $_POST['sign_password'] != ''){
      $f_name    =   trim($_POST['sign_name_f']);
      $l_name    =   trim($_POST['sign_name_l']);
      $pass      =   trim($_POST['sign_password']);
      $email     =   trim($_POST['sign_email']);
      
      $stmt = $user_home->runQuery("
          SELECT * FROM users WHERE email=:email
      ");
      $stmt->execute(array(":email"=>$email));
      $rwdt = $stmt->fetch(PDO::FETCH_ASSOC);
      if($stmt->rowCount() == 1){
         $Err = '<div class="Err-Msg">Email Address already exit</div>';
      }
      else{
        $user_home->newregister($f_name,$l_name,$pass,$email);
      } 
    }
	else if($_POST['sign_name'] == '' || $_POST['sign_email'] == '' || $_POST['sign_password'] == ''){
        // $Err = '<div style="float: left;background: #f56363;width: 100%;margin-bottom:10px;" class="Err-Msg">Form Filed Are Empty</div>';
	}

    if($_POST['login_email'] != '' && $_POST['login_password'] != ''){
       $email = $_POST['login_email'];$pass  = $_POST['login_password'];
       if($user_home->newlogin($email,$pass)){
            //$Pt = SITE_URL.'profile_info.php?id='.$_SESSION['IdSer'].'';	
            $Pt = SITE_URL;
    		echo '<script> window.location.href = "'.$Pt.'"; </script>';
       }
    }   
}


      $stmts= $user_home->runQuery("SELECT * FROM admin_manage where type='filmclub'");
      $stmts->execute();
      $userRow=$stmts->fetchAll(PDO::FETCH_ASSOC);

      $stmt_about= $user_home->runQuery("SELECT * FROM admin_manage where id=7");
      $stmt_about->execute();
      $userRow_about=$stmt_about->fetch(PDO::FETCH_ASSOC);


    echo $BY;


?>
<style>
div#Resp-Mob-Lg {
    display: none;
}
.sign_form .main_div .col-sm-12 {
    float: left;
    width: 100%;
}
.btn.btn-success{
	color: #fff !important;
}

.btn.btn-success:hover{
	color: #000 !important;
}

.benifit .thumb img {
    background: #337ab7;
    padding: 20px;
    border-radius: 100%;
    object-fit: contain;
}


  @media (min-width:320px) and (max-width:479px) {
 .sign_form {
    padding: 0;
}
.sign_form .left_sec img {
    max-width: 100%;
}
.sign_form .left_sec {
    display: none;   
}
.sign_form .right_sec {
    border-left: none;
    padding: 0px 0 20px;
    margin-top: 20px;
}
.right_sec form {
    float: left;
    width: 100%;
}

.reg_left_sec {
    padding-right: 15px;
    width: 100%;
}
.reg_right_sec {
    padding-left: 15px;
    width: 100%;
}
 

.navbar .navbar-header{text-align:center;}
.navbar .navbar-header .navbar-brand{display: inline-block;float: none;}
.navigation .navbar-toggle{display:none;}
div#Resp-Mob-Lg {
    display: block;
}
element {
    text-transform: capitalize;
}


}
/**/
  @media (min-width:480px) and (max-width:639px) {
.sign_form {
    padding: 0;
}
.sign_form .left_sec img {
    max-width: 100%;
}
.sign_form .left_sec {
    display: none;   
}
.sign_form .right_sec {
    border-left: none;
    padding: 0px 0 20px;
    margin-top: 20px;
}
.right_sec form {
    float: left;
    width: 100%;
}

.reg_left_sec {
    padding-right: 15px;
    width: 100%;
}
.reg_right_sec {
    padding-left: 15px;
    width: 100%;
}


.navbar .navbar-header{text-align:center;}
.navbar .navbar-header .navbar-brand{display: inline-block;float: none;}
.navigation .navbar-toggle{display:none;}
div#Resp-Mob-Lg {
    display: block;
}
element {
    text-transform: capitalize;
}

}

@media (min-width:640px) and (max-width:767px) {
  .sign_form {
    padding: 0;
}
  .sign_form .left_sec {
    display: none;   
}
.sign_form .right_sec {
    border-left: none;
    padding: 0px 0 20px;
    margin-top: 20px;
}
.reg_left_sec {
    padding-right: 15px;
    width: 50%;
}
.reg_right_sec {
    padding-left: 15px;
    width: 50%;
}


.navbar .navbar-header{text-align:center;}
.navbar .navbar-header .navbar-brand{display: inline-block;float: none;}
.navigation .navbar-toggle{display:none;}
div#Resp-Mob-Lg {
float: left;
width: 100%;
margin: 5px 5px;
display: block;
}
div#Resp-Mob-Lg .form-group {
    width: 50%;
    float: left;
    padding-right: 20px;
}
div#Resp-Mob-Lg .form-group.outer_fg {
    padding-right: 10px;
    padding-left: 15px;
}

}
/*----*/
@media (min-width:768px) and (max-width:991px) {
  .sign_form {
    padding: 0;
}
.sign_form .left_sec img {
    max-width: 325px;
}
.sign_form .right_sec {
margin-bottom: 30px;
}
.reg_left_sec {
    padding-right: 15px;
    width: 50%;
}
.reg_right_sec {
    padding-left: 15px;
    width: 50%;
}


.navbar .navbar-header{text-align:center;}
.navbar .navbar-header .navbar-brand{display: inline-block;float: none;}
.navigation .navbar-toggle{display:none;}

}

</style>

<title>Home Page</title>
<section class="sign_form">
 <div class="container">
  <div class="row">
   <div class="main_div">
   <div class="col-sm-6 left_sec">
   <img src="webimg/<?php echo $userRow_about['col1']; ?>" alt="img"/>
    <h2><?php echo $userRow_about['col2']; ?></h2>
	<p><?php echo $userRow_about['col3']; ?></p>
   </div>
    <div class="col-sm-6 right_sec">
          <div class="col-sm-12 login">
                  <div id="Resp-Mob-Lg">
                  
                    <img src="webimg/<?php echo $userRow_about['col1']; ?>" alt="img"/>
                    <h2><?php echo $userRow_about['col2']; ?></h2>
                	<p style="color: #fff;text-align: center;"><?php echo $userRow_about['col3']; ?></p>
                  
                  
                    <?php  if(!$user_home->is_logged_in()){ ?>
                      <form method="POST">
                           <div class="form-group">
                              <input placeholder="Email" class="form-control" type="text" name="login_email" required>
                            </div>
                            <div class="form-group outer_fg">
                              <input placeholder="Password" class="form-control" type="password" name="login_password" required>
                              <a class="f_pas" href="forget-password">Forget Your Password? </a>
                            </div>
                        
                      
                            <button type="submit" style="text-transform: capitalize;" class="btn btn-success">Log in</button>
                      </form>
                    <?php  } ?>
                  </div>  
        
           </div>
    <?php  if(!$user_home->is_logged_in()){ ?>

   
   
            <div class="col-sm-12">
            	<h2><?php echo $userRow_about['col4']; ?></h2><br>
            	
            	 <?php echo $Err;?>
        	 </div>
            <form method="POST">
        	<div class="col-sm-12 fname">
        	<div class="col-sm-6 reg_left_sec">
        	<div class="form-group">
        	<input class="form-control" id="exampleInputname" autocomplete="new-password" autocomplete="false"  placeholder="First Name" name="sign_name_f" type="name" value="<?php echo $_POST['sign_name_f'];?>" required> 
        	</div></div>
        	<div class="col-sm-6 reg_right_sec">
        	<div class="form-group">
        	<input class="form-control" id="exampleInputname" autocomplete="new-password" autocomplete="false"  placeholder="Last Name" name="sign_name_l" type="name" value="<?php echo $_POST['sign_name_l'];?>" required> 
        	</div></div>
        	</div>
        	<div class="col-sm-12">
        	<div class="form-group">
        	<input class="form-control" id="exampleInputEmail" autocomplete="false" value="<?php echo $_POST['sign_email'];?>" placeholder="Email" type="email" name="sign_email" required> 
        	</div>
        	</div>
        	<div class="col-sm-12">
        	<div class="form-group">
        	<input class="form-control" id="exampleInputpass" autocomplete="new-password" placeholder="Password" type="password" name="sign_password" value="<?php echo $_POST['sign_password'];?>" required> 
        	</div>
        	</div>
        	<div class="col-sm-12 inner_shrink">
              <input type="checkbox" name="vehicle3" value="Boat" checked><?php echo $userRow_about['col6']; ?><br>
        	</div>
        	<div class="col-sm-12 btn_signup">
            <button class="btn btn-default" type="submit" name=""><?php echo $userRow_about['col5']; ?></button>
            	
        	</div>
        	</form>
        	<div class="right-login">
            	<p class="or_custom"><span>OR</span></p>
            	<div id="Cntr-SnWl" class="CntrSnWl">
            	<div class="fb-login-button" data-width="260px" onlogin="checkLoginState();" data-max-rows="1" data-size="medium" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false"></div>
            	</div>
            	<div class="CntrSnWl">
            		<div id="my-signin2"></div>  
            	</div>
            </div>
        	
        	
        	
        <?php }else{  ?>
             <div class="col-sm-12 user-inforamation">
                 <div class="info-user">
                    <div class="profile-pic">
                    <?php if($_SESSION['profile_pic']!=""){ ?>  
                         
                         <img src="profile_pic_image/<?php echo $_SESSION['profile_pic']; ?>" alt="" >
                         
                    <?php }else{  ?>
                   	
                        <img src="/profile_pic_image/profile-default.png" alt="" >
                   <?php } ?>     
                    </div>
                     
                     
                     <h2><?php //echo ucfirst($_SESSION['user_name']);?></h2>
                     <div class="user_info">
                        <?php /* if($_SESSION['email']!=""){ ?>    
                	    <span><strong>Email : </strong><?php echo ucfirst($_SESSION['email']);?></span>
                	    <?php }  */?>
                	</div>
                  </div>
            	<!--<h2><?php //echo ucfirst($_SESSION['user_name']);?></h2>
            	<div class="user_info">
            	    <span><strong>Email :</strong><?php //echo ucfirst($_SESSION['email']);?></span>
            	</div>-->
            	 
        	 </div>
        
       <?php } ?>
   </div>
  </div>
  </div>
 </div>
</section>


<section class="benifit">
 <div class="container">
  <div class="row">
   <div class="main_div">
   <h4><?php echo $userRow_about['col7']; ?> </h4>
   <div class="col-lg-12">
     <?php
               
                foreach ($userRow as $val){
              
					
                  ?>
                 
   	<div class="col-sm-3">
    <div class="thumb">
	<img src="webimg/<?php echo $val['col1']; ?>" alt="img"/>
	</div>
	<h5><?php echo $val['col2']; ?></h5>
	<p><?php echo $val['col3']; ?></p>
	</div>
	 <?php
               }
             ?>

           
  
  </div>
  </div>
  </div>
 </div>
</section>


	
	<?php include 'footer.php';?>
	
	</body>
</html>