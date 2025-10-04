<?php include 'header.php';?>

<?php   

    $ErrFb='';
    $ErrTw='';
    $ErrIg='';
 
    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    
    echo $BY;
    $reg_type = $_SESSION['reg_type'];

if($user_home->is_logged_in()){ 
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        
?>  

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>



<?php 
$user_id = $_SESSION['user_id'];
   
    if(isset($_POST['info_submit'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $user_name = $_POST['first_name'].' '.$_POST['last_name'];
        //$headline = $_POST['headline'];
        $occupation=implode(",",$_POST['occupation']);
        //$mobile_no = $_POST['mobile_no']; 
        $about_me = $_POST['about_me'];
        $date_of_birth =date('Y-m-d');      
        $gender = $_POST['gender'];
        $country_id = $_POST['country_id'];
        
        $stmt = $user_home->runQuery("UPDATE users SET user_name=:user_name,first_name=:first_name,last_name=:last_name,occupation=:occupation,about_me=:about_me,date_of_birth=:date_of_birth,gender=:gender,country_id=:country_id WHERE user_id=:user_id");

        $stmt->bindParam(':user_name',$user_name);
        $stmt->bindParam(':first_name',$first_name);
        $stmt->bindParam(':last_name',$last_name);
        $stmt->bindParam(':occupation',$occupation);
        //$stmt->bindParam(':mobile_no',$mobile_no);
        $stmt->bindParam(':about_me',$about_me);
        $stmt->bindParam(':date_of_birth',$date_of_birth);
        $stmt->bindParam(':gender',$gender);
        $stmt->bindParam(':country_id',$country_id);
        $stmt->bindParam(':user_id',$user_id);
        if($stmt->execute()){
			
			$_SESSION['user_name']=$user_name;
			
        	// echo "<meta http-equiv='refresh' content='0'>";
        }
		else{
            $msg = 'something went wrong';
        }
    }
	if(isset($_POST['info_contact'])){
 
 
 
        
        
        $stmt = $user_home->runQuery("UPDATE users SET user_id=:user_id,facebook_username=:facebook_username,tweeter_username=:tweeter_username,instagram_username=:instagram_username,email=:email WHERE user_id=:user_id");

            $people = array("facebook.com","twitter.com","instagram.com");
            
       if($_POST['instagram_username'] != ''){
			if(preg_match("/^[a-zA-Z0-9._]+$/",$_POST['instagram_username'])){
                if (in_array($_POST['instagram_username'], $people)){
                  $ErrIg='Enter valid instagram userid';
                  $Ig = '';
                }
                else{
                  $Ig = $_POST['instagram_username'];
                }
            }
            else{
              $ErrIg='Enter valid instagram userid';
              $Ig = '';
            }
       }
		 else{
              $Ig = '';
        }
        
        if($_POST['tweeter_username'] != ''){
			if(preg_match("/^[a-zA-Z0-9._]+$/",$_POST['tweeter_username'])){
                if (in_array($_POST['tweeter_username'], $people)){
                  $ErrTw='Enter valid twitter userid';
                  $Tw = '';
                }
                else{
                  $Tw = $_POST['tweeter_username'];
                }
            }
            else{
              $ErrTw='Enter valid twitter userid';
              $Tw = '';
            }
        }
        else{
              $Tw = '';
        }
        
        
        if(isset($_POST['email'])){
            $email = $_POST['email'];
        }else{
            $email = $_SESSION['reg_type'];
        }
        
        
		
        $stmt->bindParam(':facebook_username',$_POST['facebook_username']);
        $stmt->bindParam(':tweeter_username',$Tw);
        $stmt->bindParam(':instagram_username',$Ig);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':user_id',$user_id);
        if($stmt->execute()){
        	
		}
		else{
            $msg_contact = 'something went wrong';
        }
    }
	if(isset($_POST['profile_pic_submit'])){

                
      if(!empty($_FILES['profile_pic']['name'])){
     
            $target_dir = "profile_pic_image/";
    
            $profile_up = $target_dir . basename(time().$_FILES["profile_pic"]["name"]);
            $profile_pic =  basename(time().$_FILES["profile_pic"]["name"]);
           
            $imageFileType = strtolower(pathinfo($profile_up,PATHINFO_EXTENSION));
           
            $extensions_arr = array("jpg","jpeg","png","gif");
    
             // Check extension
            if(! in_array($imageFileType,$extensions_arr) ){
                $msg = 'Please choose only jpg,jpeg,png,gif';    
            }else{
                move_uploaded_file($_FILES['profile_pic']['tmp_name'],$profile_up);
            }
			
			
			
			   $stmt = $user_home->runQuery("UPDATE users SET user_id=:user_id,profile_pic=:profile_pic WHERE user_id=:user_id");
			   $stmt->bindParam(':profile_pic',$profile_pic);
			   $stmt->bindParam(':user_id',$user_id);
				if($stmt->execute()){
					$_SESSION['profile_pic'] =$profile_pic;
					echo "<meta http-equiv='refresh' content='0'>";
				}
				else{
					$msg_pic = 'something went wrong';
				}
        }

       
     }
	if(isset($_POST['photo_submit'])){
		if(!empty($_FILES['cover_image']['name'])){
     
            $target_dir = "profile_cover_image/";
    
            $cover_up = $target_dir . basename(time().$_FILES["cover_image"]["name"]);
            $cover_image =  basename(time().$_FILES["cover_image"]["name"]);
           
            $imageFileType = strtolower(pathinfo($cover_up,PATHINFO_EXTENSION));
           
            $extensions_arr = array("jpg","jpeg","png","gif");
    
             // Check extension
            if(! in_array($imageFileType,$extensions_arr) ){
                $msg = 'Please choose only jpg,jpeg,png,gif';    
            }else{
                move_uploaded_file($_FILES['cover_image']['tmp_name'],$cover_up);
            }
        
        $stmt = $user_home->runQuery("UPDATE users SET user_id=:user_id,cover_image=:cover_image WHERE user_id=:user_id");

       $stmt->bindParam(':cover_image',$cover_image);
       $stmt->bindParam(':user_id',$user_id);
        if($stmt->execute()){
            $_SESSION['cover_image'] = $cover_image;
			echo "<meta http-equiv='refresh' content='0'>";
        }
		else{
            $msg_cover = 'something went wrong';
        }
	  }
	}
	if(isset($_POST['pass_submit'])){

   
        $password = $_POST['password']; 
   
        $stmt = $user_home->runQuery("UPDATE users SET user_id=:user_id,password=:password WHERE user_id=:user_id");

        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':user_id',$user_id);
        if($stmt->execute()){
            $msg_pwd = 'password change succcesfully';
        }
		else{
            $msg_pwd = 'something went wrong';
        }
    }

        $stmts= $user_home->runQuery("SELECT * FROM users WHERE user_id=:user_id");
        $stmts->execute(array(":user_id"=>$user_id));
        $userRow=$stmts->fetch(PDO::FETCH_ASSOC);
   /*     echo "<pre>";
        print_r($userRow);
        echo "</pre>";
        die('hi');*/
?>

<style>.col-md-8 {width: 100%;}</style>


<section class="feature_listing">
    <div class="container">
        <div class="row">
    <div class="main_div">
	
				
				
		
		
		
		<div class="col-md-12" id="imagePreviewCvr" style="background-image: url('<?php echo ($userRow['cover_image'] != 'https://coverfiles.alphacoders.com/209/thumb-20908.jpg' ? 'profile_cover_image/'.$userRow['cover_image'] : 'https://coverfiles.alphacoders.com/209/thumb-20908.jpg');?>');margin: 5px;width: calc(100% - 10px);border-radius: 4px;display: block;height: 260px;background-position: center;background-size: cover;position:relative;background-color: #f6f6f6;border: 1px solid #ddd;">
		    <form class="" method="post" enctype="multipart/form-data">
			<h2 class="HdrProFl" style="position: absolute;left: 0;background: #fff;border:solid #32517c;border-width: 1px 1px 1px 0px;line-height: 26px;top: 12px;padding: 1px 4px;font-size: 13px;border-radius: 0 2px 2px 0;width:172px;text-align: left;">Profile cover</h2>
			
			
	
		
			<?php if(isset($msg_cover)  && !empty($msg_cover)  ){
                echo $msg_cover;
            
            }?>  
            
                <div class="col-md-8" style="width: 100%;">
                    <div class="bg-white p20">
                        <div class="text list-features">
							<div class="form-group">
									<div id="CvrBxLd">
										<input type='file' name="cover_image" id="imageUploadCvr"/>
										<label>
											<ul id="ul-cvr">
												<li><label for="imageUploadCvr">Upload Image</label></li>
												<li id="Rmv-c">Remove Image</li>
											</ul>
										</label>
									</div>	

									<!-- <span id="Rmv-p">Remove</span> <span >Remove</span> -->
                          
                            </div> 
							
						</div>
					</div>	
				</div>	
					<div id="HelloCvr">	
				<div class="DvBoxr">	 		
					<button id="photo_submit" type="submit" class="button medium mat-blue-outline" name="photo_submit">Upload</button>
				</form>
				<button id="photo_submit_cancel" type="button">Cancel</button>
			</div>
		</div>
        </div>
	
	
        <div class="col-md-6">
			<div class="BxMyLv" style="height: 229px;">
				<h2>Update Profile pic</h2>
				<form class="" method="post" enctype="multipart/form-data">
					<div class="col-md-8" style="width:100%;">
						<div class="bg-white p20" style="text-align: center;">
							<div class="text list-features">
									<div  id="DvProf" class="avatar-upload">
										<div class="avatar-edit">
											<input type='file' name="profile_pic" id="imageUpload"/>
											<label>
												<ul>
													<li><label for="imageUpload">Upload Image</label></li>
													<li id="Rmv-c">Remove Image</li>
												</ul>
											</label>
										</div>
										<div class="avatar-preview">
											<div id="imagePreview" style="background-image: url('<?php echo ($userRow['profile_pic'] != 'https://vignette.wikia.nocookie.net/bungostraydogs/images/1/1e/Profile-icon-9.png' ? 'profile_pic_image/'.$userRow['profile_pic'] : 'https://vignette.wikia.nocookie.net/bungostraydogs/images/1/1e/Profile-icon-9.png');?>');">
											</div>
										</div>
									</div>
							</div>
						<div id="ProHmbxr">
							<button id="profile_pic_submit" type="submit" class="button medium mat-blue-outline" name="profile_pic_submit">Upload</button>

						</form>
							<button id="profile_pic_submit_cnl" type="button" class="button medium mat-blue-outline" name="profile_pic_submit">Cancel</button>
						</div>

						</div>   
					</div>
			</div>

			
			
			<div class="BxMyLv">
			<h2>Contact Information</h2>
           <?php if(isset($msg_contact) && !empty($msg_contact)){ echo $msg_contact; } ?>  
            <form class="" method="post" enctype="multipart/form-data">
                <div class="col-md-8">
                    <div class="bg-white p20">
                        <div class="text list-features">
						
						
						
						
                            <div class="form-group social-span">
								<i class="fa fa-facebook" aria-hidden="true"></i>
                                <input type="text" name="facebook_username" class="field-element" id="facebook_username" size="80" value="<?php echo $userRow['facebook_username']; ?>" placeholder="Facebook profile url"  >
                                <?php echo $ErrFb;?>
                            </div>

							<div class="form-group social-span" style="margin-left: 2%;">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                <input type="text" name="tweeter_username" class="field-element" id="tweeter_username" size="80" value="<?php echo $userRow['tweeter_username']; ?>" placeholder="Twitter username"  >
								 <?php echo $ErrTw;?>
                            </div>

							<div class="form-group social-span">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                                <input type="text" name="instagram_username" class="field-element" id="instagram_username" size="80" value="<?php echo $userRow['instagram_username']; ?>" placeholder="Instagram username"  >
								 <?php echo $ErrIg;?>
                            </div>
							<?php if($_SESSION['reg_type']=="email"){ ?>
                            <div class="form-group social-span" style="margin-left: 2%;">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                <input type="text" class="field-element" id="email" name="email" value="<?php echo $userRow['email'];?>" placeholder="email">
                            </div>
                            <?php } ?>

                             <div class="form-group hide">
                               <label for="about_me">SHARE MY CONTACT INFORMATION WITH:</label>   
                             <select name="share_contact_info">
                              <option value=""></option> 
                              <option  <?php if ($userRow['share_contact_info']==1){echo 'selected';}?> value="1">Everybody</option>
                              <option  <?php if ($userRow['share_contact_info']==2){echo 'selected';}?> value="2">Rockethub Members</option>
                              <option  <?php if ($userRow['share_contact_info']==3){echo 'selected';}?> value="3">Network Connections</option>
                              <option  <?php if ($userRow['share_contact_info']==4){echo 'selected';}?> value="4">Private</option>
                             </select> 
                             </div>

                            <div class="clear" style="clear:both"></div>
   
							<button id="info_contact" type="submit" class="button medium mat-blue-outline" name="info_contact" style="color:#4f9fcf;margin-bottom:20px;">Save</button>
						</div>
					</div>
				</div>
            </form>
			</div>
			
			<?php  if($reg_type=="email"){  ?>
			<div class="BxMyLv" id="change_password">

                <h2>Change Password</h2>
                   
               <?php if(isset($msg_pwd)  && !empty($msg_pwd)  ){
                    echo $msg_pwd;
                
                } ?>  
                <form class="validatedForm" method="post" enctype="multipart/form-data">
                    <div class="col-md-8">
                        <div class="bg-white p20">
                            <div class="text list-features">
                                 <div class="form-group" style="margin:0 0 10px;">
                                    <input type="password" class="field-element" id="password" name="password" value="" placeholder="New Password">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="repeat_new_password" class="field-element" id="repeat_new_password" size="80" value="" placeholder="Repeat New Password"  >
                                    <div class="error">
                                     </div>
                                </div>
    
    							<button id="pass_submit" type="submit" class="button medium mat-blue-outline" name="pass_submit" style="color:#4f9fcf;margin-bottom:20px;">Save</button>
    						</div>
    					</div> 
    				</div>	
                </form>
            </div>
            <?php } ?>
        
        
        
    </div>
			
		  
        
    
		
		<div class="col-md-6">
			<div class="BxMyLv" style="overflow:unset;float:left;">
			<h2>Personal Information</h2>
            <?php if(isset($msg)  && !empty($msg)  ){
                echo $msg;
            
            } ?>           
              <form class="" method="post" enctype="multipart/form-data">
                <div class="col-md-8">
                    <div class="bg-white p20">
                        <div class="text list-features">
                            
                           <!--  <div class="form-group">
                               <label for="company_logo">Cover Image</label>
                                <input type="file"name="cover_image"  accept="image/png, image/jpeg">
                          
                            </div> -->

                            <!--<div class="form-group">
                                <label for="company_name">User Name</label>
                                <input style="" style="background:#eee;" type="text" class="field-element" size="80" value="<?php //echo $_SESSION['IdSer']; ?>">
                            </div>-->
             
                            <div class="form-group">
                                <div style="display:inline-block;width:50%;"> 
									<label for="company_name">First Name</label>
									<input type="text" name="first_name" class="field-element" id="first_name" size="80" value="<?php echo $userRow['first_name']; ?>" placeholder="First name"/>
								</div>
                                <div style="display:inline-block;width:49%;"> 
									<label for="company_name">Last Name</label>
									<input type="text" name="last_name" class="field-element" id="last_name" size="80" value="<?php echo $userRow['last_name']; ?>" placeholder="Last name"/>
								</div>
                            </div>

                        <!--    <div class="form-group">
                                <label for="headline">Headline</label>
                                <input type="text" class="field-element" id="headline" name="headline" value="<?php //echo $userRow['headline'];?>" placeholder="headline">
                            </div>-->
                            
                            <div class="form-group">
                                <?php $occupation = explode(",",$userRow['occupation']) ;
                                            ?>
                                <label for="headline">Occupation</label>
                      
                                <select required name="occupation[]" multiple> 
									  <option value="">Select Occupation</option> 
									
								<?php 
					
								$occupationArr = array("Producer","Director","Actor","Investor","Script Writer","Other Professional");
								foreach($occupationArr as $Occupation){   
								
								    
								    $selected = "";
								  
								    
							        if (in_array($Occupation, $occupation)){
                                       echo $selected = "selected";
                                    }
                								    
								    
								?>
								
								
								    <option <?php echo $selected; ?> value="<?php echo $Occupation;?>"><?php echo $Occupation;?></option>
								
									<?php } ?>	
									  
								</select>
								
                                
                            </div>
                            
                            
                            <!--<div class="form-group">
                                <label for="headline">Mobile No</label>
                                <input type="number" pattern="\d{3}[\-]\d{3}[\-]\d{4}" class="field-element" id="mobile_no" name="mobile_no" value="<?php echo $userRow['mobile_no'];?>" placeholder="Mobile No">
                            </div>-->
                            
                            
                            <div class="form-group">
                                <label for="about_me">Short Bio</label>
                                <textarea name="about_me" placeholder="about me"  rows="3" cols="80" class="field-element"><?php echo $userRow['about_me'];?></textarea>
                            </div>
                              
							<div class="form-group">
                               <div style="display: inline-block;width:65%;"> 
								
								<label for="date_of_birth">Date of Birth</label>
                           
                                <div class='input-group date' id='datetimepicker1'>
                                  <input type='text' class="field-element"  name="date_of_birth" placeholder="DD/MM/YYYY" />
                                  <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                  </span>
                                </div>
							   </div>
							   
							   <div style="width: 34%;height:65px;float: right;">
								   <label for="about_me">Gender</label>   
									 <select name="gender" style="">
									  <option value="">select a gender</option> 
									  <option <?php if ($userRow['gender']==1){echo 'selected';}?> value="1">Male</option>
									  <option <?php if ($userRow['gender']==2){echo 'selected';}?> value="2">Female</option>
									 </select> 
							   
							   </div>
							   
                            </div>

                     
                            <div class="form-group">
                                <label for="company_country_id">Country</label>
                                <select name="country_id" id="select-country" required="">
                                    <option value=""> - country - </option>
                                </select>
                            </div>
                  
                          
                           
                            
                           
                           
                           
                    <button id="pass_submit" type="submit" class="button medium mat-blue-outline" name="info_submit" style="color:#4f9fcf;margin-bottom:20px;">Save</button>
                </div>
               
            </form>
        </div>   
        
            </div>
        </div>
		<br style="clear:both;">
	</div>
		
    </div>
		</div>
	</div>	
</section> 


<?php } ?>                  
        
	<link href="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css" rel="stylesheet"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/js/standalone/selectize.min.js"></script>
    <?php include 'footer.php';?>
    <script>
        document.title = "Edit Profile";
		var Cnty=["Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bonaire","Bosnia and Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Cote D'Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador ","Egypt ","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands (Malvinas)","Fed States of Micronesia","Fiji","Finland","France","French Guiana","French Polynesia","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Holy See (Vatican City State)","Honduras","Hungary","Iceland","India","Indonesia","Iran (Islamic Republic of)","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mexico","Moldova, Republic of","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","North Korea","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland ","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russian Federation","Rwanda","Saint Barthelemy","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Martin","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia ","Scotland","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates ","United Kingdom","United States","United States Virgin Islands","Uruguay","Uzbekistan","Vanuatu","Venezuela","Vietnam","Wallis and Futuna Islands","Western Sahara","Yemen","Zambia","Zimbabwe"];
			
        for(var i=0;i<Cnty.length;i++) $('#select-country').append('<option value="'+Cnty[i]+'">'+Cnty[i]+'</option>');

		$("#select-country").val("<?php echo $userRow['country_id'];?>");
    
		$('select').selectize({});
    


$(document).ready(function() {
  $(function() {
    var dateNow = "<?php echo $userRow['date_of_birth'];?>";
    if(dateNow =='0000-00-00'){
        dob = "1950-01-01";
    }else{
        dob = dateNow;
    }
  
	  $( "#datetimepicker1" ).datetimepicker({
		format: 'DD/MM/YYYY',
		defaultDate:dob
	  });
  });
});


        var allowsubmit = false;
        $(function(){
            //on keypress 
            $('#repeat_new_password').keyup(function(e){
                //get values 
                var password = $('#password').val();
                var repeat_new_password = $(this).val();
             
                //check the strings
                if(password == repeat_new_password){
                    //if both are same remove the error and allow to submit
                    $('.error').text('');
                    allowsubmit = true;
                     $('#pass_submit').prop('disabled', false);
                }else{
                    //if not matching show error and not allow to submit
                    $('.error').text('Password not matching');
                    allowsubmit = false;
                
                  $('#pass_submit').prop('disabled', true);

                }
            });
            
           
        });


$(document).ready(function() {
  $(function() {
    $('#datetimepicker2').datetimepicker();
    $('#datetimepicker3').datetimepicker({
      useCurrent: false //Important! See issue #1075
    });
    $("#datetimepicker2").on("dp.change", function(e) {
      $('#datetimepicker3').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker3").on("dp.change", function(e) {
      $('#datetimepicker2').data("DateTimePicker").maxDate(e.date);
    });
  });
});



$(document).ready(function() {
  $(function() {
    $('#datetimepicker4').datetimepicker();
    $('#datetimepicker5').datetimepicker({
      useCurrent: false //Important! See issue #1075
    });
    $("#datetimepicker4").on("dp.change", function(e) {
      $('#datetimepicker5').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker5").on("dp.change", function(e) {
      $('#datetimepicker4').data("DateTimePicker").maxDate(e.date);
    });
  });
});




$(document).ready(function() {
  $(function() {
    $( "#datetimepicker6" ).datetimepicker();
    //$('#datetimepicker1').datepicker("show");
   
   
  });
});
			function readURL(input) {
					
					
					$("#ProHmbxr").show();
					var Od = $('#imagePreview').css('background-image');
					
					$("#profile_pic_submit_cnl").on('click',function(){
						$('#imagePreview').css('background-image',Od);	
						$("#ProHmbxr").hide();
					});
					
					if (input.files && input.files[0]){
						var reader = new FileReader();
						reader.onload = function(e) {
							$('#imagePreview').css('background-image', 'url('+e.target.result +')');
							$('#imagePreview').hide();
							$('#imagePreview').fadeIn(650);
							$("#In-Rmvp").val("");
						}
						reader.readAsDataURL(input.files[0]);
					}
				}

				$("#imageUpload").change(function() {
					readURL(this);
				});
				
				$("#HelloCvr").hide();
				$("#ProHmbxr").hide();
				
				function readURLCvr(input) {
					
					$("#HelloCvr").show();
					var Od = $('#imagePreviewCvr').css('background-image');
					
					$("#photo_submit_cancel").on('click',function(){
						$('#imagePreviewCvr').css('background-image',Od);	
						$("#HelloCvr").hide();
					});		
					
					
					if (input.files && input.files[0]) {
						var reader = new FileReader();
						reader.onload = function(e) {
							$('#imagePreviewCvr').css('background-image', 'url('+e.target.result +')');
							$('#imagePreviewCvr').hide();
							$('#imagePreviewCvr').fadeIn(650);
						}
						reader.readAsDataURL(input.files[0]);
						$("#In-Rmvc").val("");
					}
				}

				$("#imageUploadCvr").change(function() {
					readURLCvr(this);
				});
				
				
                $("#CvrBxLd label").on('click',function(){
					var c = $("#CvrBxLd label ul");var txt='';
					c.show();
					$("#CvrBxLd label ul li").off().on('click', function(){
						txt = $(this).html();
						var myKeyVals = {type:'RemoveCvr'};
						if(txt == 'Remove Image'){
							$('#imagePreviewCvr').css('background-image', 'url(https://coverfiles.alphacoders.com/209/thumb-20908.jpg)');
							$('#imagePreviewCvr').hide();
							$('#imagePreviewCvr').fadeIn(650);
							var saveData = $.ajax({
								  type: 'POST',
								  url: Page,
								  data: myKeyVals,
								  dataType: "text",
								  success: function(resultData) { 
									
								  }
							});
							saveData.error(function() { alert("Something went wrong"); });
						}
					});
					
					$(document).click(function(e){		
						if(txt == 'Remove Image'){
							c.hide();
						}
					});	
					
					$(document).mouseup(function(e){		
						if (!c.is(e.target) && c.has(e.target).length === 0) c.hide();
					});
				});
				
				$("#DvProf label").on('click',function(){
					var c = $("#DvProf label ul");
					var txt='';
					c.show();
					$("#DvProf label ul li").off().on('click', function(){
						txt = $(this).html();
						var myKeyVals = {type:'RemovePic'};
						if(txt == 'Remove Image'){
						$('#imagePreview').css('background-image', 'url(https://vignette.wikia.nocookie.net/bungostraydogs/images/1/1e/Profile-icon-9.png)');
						$('#imagePreview').hide();
						$('#imagePreview').fadeIn(650);
							var saveData = $.ajax({
								  type: 'POST',
								  url: Page,
								  data: myKeyVals,
								  dataType: "text",
								  success: function(resultData) { 
									
								  }
							});
							saveData.error(function() { alert("Something went wrong"); });
						}
					});
					
					
						
					
					$(document).click(function(e){		
						if(txt == 'Remove Image'){
							c.hide();
						}
					});	
					
					
					
					$(document).mouseup(function(e){		
						if (!c.is(e.target) && c.has(e.target).length === 0) c.hide();
					});
				});
				
				
				
				
				
				

			</script>
			
    </body>
</html>
