<?php include 'header.php';
	

    if($user_home->is_logged_in()){ 
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
	
	$MsgEr = '';

      $stmts= $user_home->runQuery("SELECT * FROM admin_manage where type='filmclub'");
      $stmts->execute();
      $userRow=$stmts->fetchAll(PDO::FETCH_ASSOC);

      $stmt_about= $user_home->runQuery("SELECT * FROM admin_manage where id=6");
      $stmt_about->execute();
      $userRow_about=$stmt_about->fetch(PDO::FETCH_ASSOC);


    if(isset($_POST['about_submit'])){

        $user_id = $_SESSION['user_id'];
        $user_unq = $_SESSION['IdSer'];

        $fav_film = $_POST['fav_film'];
        $biggest_challenge = $_POST['biggest_challenge'];
        $investing = $_POST['investing'];
        $created =date('Y-m-d H:i:s');      

        $stmt = $user_home->runQuery("INSERT INTO aboutus(fav_film,biggest_challenge,investing,created,user_id,user_unq) VALUES (:fav_film,:biggest_challenge,:investing,:created,:user_id,:user_unq)");

        $stmt->bindParam(':fav_film',$fav_film);
        $stmt->bindParam(':biggest_challenge',$biggest_challenge);
        $stmt->bindParam(':investing',$investing);
        $stmt->bindParam(':created',$created);
        $stmt->bindParam(':user_id',$user_id);
        $stmt->bindParam(':user_unq',$user_unq);
        if($stmt->execute()){
          $msg = 'Send succcesfully';     
    }else{
          $msg = 'Something went wrong'; 
    }
  }



    echo $BY;


?>

<title>About Us</title>
<style>
.about_form{}
.about_form .form-group{margin: 0;}
.about_form .form-group label{font-size: 13px;margin: 0;}

.sign_form{
	font-family: "Poppins", sans-serif;
}

.sign_form .left_sec h2{font-size: 24px;letter-spacing: 1px;}

.sign_form .left_sec p{font-size: 17px;line-height: 21px;}

.sign_form .right_sec button {
    background: transparent;
    border: 2px solid #fff;
    border-radius: 0;
    color: #fff !important;
    display: inline-block;
    font-size: 11px;line-height:13px;
    margin: 0;
    padding: 5px 20px;border-radius: 5px;
    text-decoration: none;transition: unset !important;
}



.sign_form .right_sec button:hover{background: #fff none repeat scroll 0 0;border-color: #fff;color:#111 !important;}


.sign_form .right_sec{height: 300px;

vertical-align: middle;
border-left: 2px solid #e3e3e3;

float: right;
padding: 12px 36px;
}
.col-sm-12.about_form {
    color: #fff;
    font-size: 17px;
}
select.sel_opt {
   color: #fff;
    padding: 4px;
    background-color: #32517c;
    width: 30%;
    border-color: #ccc;
}
/*------- RESPONSIVE --------*/

@media (min-width:320px) and (max-width:479px){
.sign_form .left_sec img {
    max-width: 100%;
}
.sign_form .left_sec {
    display: none;   
}
.sign_form .right_sec {
    border-left: none;
    padding: 20px 0 0;
    margin-top: 20px;
    border-top: 2px solid #e3e3e3;
    height: auto;
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

a.f_pas {
    position: static;
}
 
.sign_form .right_sec h2{
  text-align: center;
}

.sign_form .right_sec button {
    padding: 5px 10px;
    margin-right: 5px;
}

.navigation .navbar-right {
    margin: 0;
    height: 56px;
    padding-top: 5px;
    display: inline-block;
}
}
@media (min-width:480px) and (max-width:639px){
.sign_form .left_sec img {
    max-width: 100%;
}
.sign_form .left_sec {
    display: none;   
}
.sign_form .right_sec {
    border-left: none;
    padding: 20px 0 0;
    margin-top: 20px;
    border-top: 2px solid #e3e3e3;
    height: auto;
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
a.f_pas {
    position: static;
} 
.sign_form .right_sec h2{
  text-align: center;
}
.sign_form .right_sec button {
    padding: 5px 10px;
    margin-right: 5px;
}
.navigation .navbar-right {
    margin: 0;
    height: 56px;
    padding-top: 5px;
    display: inline-block;
}
}


</style>
<link href="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css" rel="stylesheet"/>
<section class="sign_form">
 <div class="container">
  <div class="row">
   <div class="main_div">
   <div class="col-sm-6 left_sec">
   <img src="webimg/<?php echo $userRow_about['col1']; ?>" alt="img"/>
    <h2><?php echo $userRow_about['col2']; ?></h2>
	<p><?php echo $userRow_about['col3']; ?></p>
   </div>
  <div class="col-sm-6 right_sec" style="margin:0;">   
	<h2>Survey</h2>
    <form class="" method="post" enctype="multipart/form-data">
    <div class="col-sm-12 about_form">
   <div class="form-group">
    <label for="fav_film">What is your favourite film industry in Africa ?</label>
      <select name="fav_film" class="sel_opt" placeholder="Select">                  
           <option value=""></option>
           <?php
				foreach(array('Algeria','Angola','Benin','Botswana','Burkina Faso','Burundi','Cameroon','Cape Verde','Central African Republic','Chad','Comoros','Congo-Brazzaville','Congo-Kinshasa','Cote d\'Ivoire','Djibouti','Egypt','Equatorial Guinea','Eritrea','Ethiopia','Gabon','Gambia','Ghana','Guinea','Guinea Bissau','Kenya','Lesotho','Liberia','Libya','Madagascar','Malawi','Mali','Mauritania','Mauritius','Morocco','Mozambique','Namibia','Niger','Nigeria','Rwanda','Senegal','Seychelles','Sierra Leone','Somalia','South Africa','South Sudan','Sudan','Swaziland','São Tomé and Príncipe','Tanzania','Togo','Tunisia','Uganda','Western Sahara','Zambia','Zimbabwe') as $v){
					echo '<option value="'.$v.'">'.$v.'</option>';
				}
			?>
        </select>                  
        </div>
        <div class="form-group">
    <label for="biggest_challenge">What do you think is the biggest challenge in the African film industry?</label>
      <select name="biggest_challenge" placeholder="Select" class="sel_opt">                  
           <option value=""></option>
           <option value="Funding">Funding</option>
           <option value="Talent">Talent</option>
           <option value="Piracy">Piracy</option>
           <option value="Distribution">Distribution</option>
        </select>                  
        </div>
        <div class="form-group">
    <label for="investing">Would you consider investing in a film project?</label>
      <select name="investing" placeholder="Select" class="sel_opt">                  
           <option value=""></option>
		   <option value="Never">Never</option>
           <option value="No but will consider donating">No but will consider donating</option>
           <option value="Yes, depends on the film">Yes, depends on the film</option>
           <option value="Absolutely">Absolutely</option>
        </select>                  
        </div>
	 </div>
   



	<div class="col-sm-12">
		<button id="about_submit" type="submit" class="button medium mat-blue-outline" name="about_submit" style="">Submit</button>
	</div>
</form>
   </div>
  </div>
  </div>
 </div>
</section>


<section class="benifit">
 <div class="container">
  <div class="row">
   <div class="main_div">
   <h2>Why African Film Club?</h2>
     <?php
               
                foreach ($userRow as $val){
              
					
                  ?>
                 
   	<div class="col-sm-6">
    <div class="thumb">
	<img src="webimg/<?php echo $val['col1']; ?>" alt="img"/>
	</div>
	<h4><?php echo $val['col2']; ?></h4>
	<p><?php echo $val['col3']; ?></p>
	</div>
	 <?php
               }
             ?>

           
  
  </div>
  </div>
 </div>
</section>



			
		<?php } ?> 
	
	<?php include 'footer.php';?>
	<script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/js/standalone/selectize.min.js"></script>
	<script>
		$('select').selectize();
	</script>
	</body>
</html>