<?php 
include 'header.php';

        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
	/*
    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    */

	if(isset($_POST['contact_submit'])){
		
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $created = date('Y-m-d H:i:s');
	
        $name = $_POST['name'];
        $email = $_POST['email'];
		
		   $stmt = $user_home->runQuery("INSERT INTO contact(name,email,subject,message,created) VALUES (:name,:email,:subject,:message,:created)");
				$stmt->bindParam(':name', $name);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':subject', $subject);
				$stmt->bindParam(':message', $message);
				$stmt->bindParam(':created', $created);
		
		
		if($stmt->execute()){
			  $msg = 'Message Send succcesfully';     
		}
		else{
			  $msg = 'Something went wrong'; 
		}
    }

    echo $BY;	
	
?>  


<style>
#film-banner {
	/*background-image: url('http://school298.spb.ru/images/400/DSC100486335.jpg');*/
	height: 160px;
	width: 100%;
	background-size: cover;
	background-position: center 380px;
	position: relative;
}

#film-banner div {
position: absolute;
left: 50%;
top: 50%;
color: #fff;
max-width: 480px;
width: 100%;
height: 32px;
margin-top: -22px;
margin-left: -240px;
text-align: center;
  color: black;
}

#film-banner div h2{
	margin:0;padding:0;
}

#Cont-Bx{
	background: #f6f6f6;
	border-radius: 4px;
	border: 1px solid #ddd;
	padding-top: 5px;
	margin: 0 5px;
	width: calc(100% - 10px);
	overflow:hidden;
}

.form-group .field-element {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    background: #fafafa;
    color: #000;
    font-family: sans-serif;
    font-size: 12px;
    line-height: normal;
    box-sizing: border-box;
    border-radius: 2px;
}

#Cont-Bx .form-group .FgBxr{
	display: inline-block;
width: 49%;
margin: 0 3px;
}

#Cont-Bx .text.list-features{
    padding: 20px 20px 0;
}

#Cont-Bx #contact_submit{
	margin-bottom: 20px;
	margin-left: 21px;
	font-size: 12px;
	font-weight: 600;
	z-index: 2;
	position: relative;
	display: inline-block;
	border-radius: 3px;
	text-align: center;
	border: 0;
	height: 25px;
	line-height: 24px;
	background: #d8d8d8;
	color: #4b4f56 !important;
	width: 80px;
}

/*------- RESPONSIVE --------*/

@media (min-width:320px) and (max-width:479px) {
#film-banner {
    background-position: inherit;
}
}

@media (min-width:480px) and (max-width:639px) {
#film-banner {
    background-position: inherit;
}
}
@media (min-width:640px) and (max-width:767px) {
#film-banner {
    background-position: inherit;
}
}


</style>

<title>Contact Us</title>

<link href="https://fonts.googleapis.com/css?family=Muli:300,400,600%7CPoppins:300,400,600"/>

<section class="Contact_listing">
 <div class="container">
  <div class="row">

        <div class="col-md-12">
            <h2>Contact Us</h2>

<form class="" method="post" enctype="multipart/form-data">
<div class="form-group">
<label for="company_name">Name</label>
<input type="text" class="field-element" id="company_name" value="" name="name" placeholder="Name" required="required">
</div>
<div class="form-group">
<label for="company_name">Email</label>
<input type="text" class="field-element" id="company_name" value="" name="email" placeholder="Email" required="required">
</div>
<div class="form-group">
<label for="company_name">Subject</label>
<input type="text" class="field-element" id="company_name" name="subject" placeholder="subject" required="required">
</div>
<div class="form-group">
<label for="company_description">Message</label>
<textarea class="field-element" id="message" name="message" rows="5" placeholder="Description of message..."></textarea>
</div>
<div class="form-group">
<button id="contact_submit" type="submit" class="button medium mat-blue-outline" name="contact_submit" >Submit</button>
</div>
</form>

        </div>  
  

  </div>
 </div>
</section>


	
	<?php include 'footer.php';?>
  <script>
      document.title = "Contact Form";
  </script>
	</body>
</html>