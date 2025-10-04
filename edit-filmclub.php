<?php include 'header.php';

if(!$user_home->is_logged_in()){ 
	$user_home->redirect(SITE_URL);
}

{ 
  
   $stmts= $user_home->runQuery("SELECT * FROM admin_manage where type='filmclub'");
      $stmts->execute();
      $userRow_filmclub=$stmts->fetchAll(PDO::FETCH_ASSOC);

      $id=$_GET['id'];

      $stmtp= $user_home->runQuery("SELECT * FROM admin_manage where id=:id");
      $stmtp->execute(array(":id"=>$id));
      $userRow=$stmtp->fetch(PDO::FETCH_ASSOC);
  
	 if(isset($_POST['fil_club_update'])){
       
        if(!empty($_FILES['col1']['name'])){
     
            $target_dir = "webimg/";
    
            $cover_up = $target_dir . basename(time().$_FILES["col1"]["name"]);
            $col1 =  basename(time().$_FILES["col1"]["name"]);
           
            $imageFileType = strtolower(pathinfo($cover_up,PATHINFO_EXTENSION));
           
            $extensions_arr = array("jpg","jpeg","png","gif");
    
             // Check extension
            if(! in_array($imageFileType,$extensions_arr) ){
                $msg = 'Please choose only jpg,jpeg,png,gif';    
            }else{
                move_uploaded_file($_FILES['col1']['tmp_name'],$cover_up);
            }
      
      	  }else{

      	  	$col1=$userRow['col1'];
      	  }
      	  
        $col2 = $_POST['col2'];
        $col3 = $_POST['col3'];
     
        
       $stmt = $user_home->runQuery("UPDATE admin_manage SET col1=:col1,col2=:col2,col3=:col3 WHERE id=:id");

        
        $stmt->bindParam(':col1',$col1);
        $stmt->bindParam(':col2',$col2);
        $stmt->bindParam(':col3',$col3);
       
         $stmt->bindParam(':id',$id);
        if($stmt->execute()){
        	$msg = 'Updated successfully';
        }
		else{
            $msg = 'something went wrong';
        }
    }

	
	  $stmtp= $user_home->runQuery("SELECT * FROM admin_manage where id=:id");
      $stmtp->execute(array(":id"=>$id));
      $userRow=$stmtp->fetch(PDO::FETCH_ASSOC);
  
	
	
     



   
echo $BY;

?>

<style>
body{background-color:#efefef;}

.feature_listing .main_div .col-md-6{padding: 0px;}

.feature_listing .main_div .col-md-6 div.BxMyLv{
	background: #f6f6f6;
	margin: 8px 5px 0px;
	border-radius: 4px;
	overflow: hidden;
	border: 1px solid #ddd;
}

h2.HdrProFl,.feature_listing .main_div .col-md-6 h2{margin: 0px;
font-size: 16px;
text-transform: uppercase;
line-height: 40px;
padding: 0;}

h2.HdrProFl::before,.feature_listing .main_div .col-md-6 h2::before{
	height:0;
}


#CvrBxLd{position: relative;padding-top: 42px;}
#CvrBxLd #imageUploadCvr{display: none;}
#CvrBxLd #imageUploadCvr + label{position: absolute;

left: 104px;

margin-left: -17px;

background: #ffffff none repeat scroll 0 0;

border: 1px solid #fc5c0f;

border-radius: 100%;

box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.12);

cursor: pointer;

display: inline-block;

font-weight: normal;

top: 10px;

height: 34px;

margin-bottom: 0;

transition: all 0.2s ease-in-out 0s;

width: 34px;}
#CvrBxLd #imagePreviewCvr{width: 100%;
height: 240px;
background-size: cover;
background-position: center;}


#CvrBxLd #imageUploadCvr + label::after{
	content: "\f040";
	font-family: 'FontAwesome';
	color: #757575;
	position: absolute;
	top: 5px;
	left: 0;
	right: 0;
	text-align: center;
	margin: auto;
}

#HelloCvr{background: rgba(1,1,1,.4);
left: 0;
right: 0;
top: 0;
bottom: 0;
position: absolute;}

#HelloCvr .DvBoxr{position: absolute;
right: 20px;
bottom: 25px;}
#HelloCvr .DvBoxr button{font-size: 12px;
font-weight: 600;
z-index: 2;
position: relative;
display: inline-block;
border-radius: 3px;
text-align: center;
border: 0;
height: 25px;
line-height: 24px;
background: #f5f6f7;
color: #4b4f56;
width: 80px;}
</style>

<div id="film-banner">
	<div>
		<h2>Manage Film Club</h2>
	</div>	
</div>


<section class="feature_listing">
    <div class="container">
        <div class="row">
    <div class="main_div">
	

		<style>	



#film-banner{background-image:url('/images/DSC100486335.jpg');height:160px;width:100%;background-size: cover;
background-position: center 380px;position: relative;}

#film-banner div{
position: absolute;
left: 50%;
top: 50%;
color: #fff;
max-width: 480px;
width: 100%;
height: 64px;
margin-top: -37px;
margin-left: -240px;
text-align: center;
}

#film-banner div h2{margin: 0;
padding: 0;
font-size: 28px;
font-weight: 600;
text-transform: capitalize;}
#film-banner div a{transition: all ease-in-out .3s;color: #fff;border: 1px solid #fff;border-radius: 4px;font-size: 14px;text-decoration: none;padding: 1px 16px;cursor: pointer;font-weight: 600;display: inline-block;
margin-top: 18px;}


				
#ProHmbxr{position: absolute;
margin-top: 4px;
padding: 8px;
left: 0;
right: 0;bottom: -44px;}

button,#ProHmbxr button{font-size: 12px;
font-weight: 600;
z-index: 2;
position: relative;
display: inline-block;
border-radius: 3px;
text-align: center;
border: 0;
height: 25px;
line-height: 24px;
background:#d8d8d8;
color: #4b4f56 !important;
width: 80px;
margin-left: 246px;

}

.field-element {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    background: #fafafa;
    color: #000;
    font-family: sans-serif;
    font-size: 12px;
    line-height: normal;
    box-sizing: border-box;
    border-radius: 2px;
}

.col-md-8 {
    width: 100%;
}

		</style>			
						

						 
				<style>
				.avatar-upload{
					margin: 0 auto;
					position: relative;
					text-align: center;
					width:auto;
				}
				
				.avatar-upload .avatar-edit{
					   position: absolute;
    z-index: 1;
    top: -30px;left:0;
    height: 24px;
				}
				
				.avatar-upload .avatar-edit input {
					display: none;
				}
				
				.avatar-upload .avatar-edit input + label {
				   background: #ffffff none repeat scroll 0 0;
				    border: 1px solid skyblue;
				    cursor: pointer;
				    display: inline-block;
				    font-weight: normal;
				    height: 24px;
				    padding-left: 20px;
				    margin-bottom: 0;
				    transition: all 0.2s ease-in-out 0s;
				    width: 113px;
				    text-align: left;border-radius: 3px;
				}
				
				.avatar-upload .avatar-edit input + label::after {
					       content: "\f040";
						    font-family: 'FontAwesome';
						    color: #757575;
						    position: absolute;
						    left: 5px;
						    right: 0;
						    text-align: left;
						    margin: auto;
						    top: 2px;
				}
				
				.avatar-upload .avatar-preview {
						    border: 1px solid skyblue;
						    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
						    height: 165px;
						    position: relative;
						    background-color: skyblue;
						    width: 234px;
						    float: left;border-radius: 3px;
				}
				
				.avatar-upload .avatar-preview > div {
					width: 100%;
					height: 100%;
					
					background-size: contain;
					background-repeat: no-repeat;
					background-position: center;
				}

                .ryt_sec{
                    margin: 15px 28px;
                }

			</style>


				<style>
								.social-span{position: relative;display: inline-block;width: 48%;}
								.social-span i{position: absolute;left: 1px;top: 1px;height: 35px;background: #eee;line-height: 35px;width: 36px;text-align: center;font-size: 20px;}
								.social-span input{padding-left: 40px;}

.filmclub_rytsec{
	border: 1px solid #ccc;
	margin-top: 40px;
    height: 161px;
}
								.filmclub_rytsec .responsive{}
								.filmclub_rytsec .responsive a{color: #000;
font-size: 12px;
display: block;
background: #f6f6f6;
padding: 11px;
border-top: 1px solid #ccc;
font-weight: 600;text-decoration: none;}


.filmclub_rytsec .responsive a:hover{color:#add8e6;}

.filmclub_rytsec .responsive:nth-child(1) a{border:0;}


							</style>
			
			
			
			
			
		
 
			
		  
        
    
		
		<div class="col-md-9">
			<div class="BxMyLv" style="overflow:unset;float:left;">
			
            <?php if(isset($msg)  && !empty($msg)  ){
                echo $msg;
                echo '<script> setTimeout(function(){ window.location.href = "'.SITE_URL.'edit-filmclub.php?id='.$id.'   "; }, 2000);   </script>';
            
            } ?>           
              <form class="" method="post" enctype="multipart/form-data">
               <div class="col-md-4">
                    <div class="bg-white p20">
                        <div class="text list-features">
                            <br><br>
                            <div class="avatar-upload">
										<div class="avatar-edit">

											<input type='file' name="col1" id="imageUpload"/>
											<label for="imageUpload">Upload Image</label> 
										</div>
										<div class="avatar-preview">
											<div id="imagePreview" style="background-image: url('webimg/<?php echo $userRow['col1'];?>');">
											</div>
										</div>
									</div>
                      
                          
                             </div>
                               </div></div>

                                 <div class="col-md-5 ryt_sec">
                              <div class="bg-white p20">
                              <div class="text list-features">

                            <div class="form-group">
                                <label for="headline">Headline</label>
                                <input type="text" class="field-element" id="headline" name="col2" value="<?php echo $userRow['col2']; ?>" placeholder="headline">
                            </div>
                            <div class="form-group">
                                <label for="about_me">Text</label>
                                <textarea name="col3" placeholder="about me"  rows="3" cols="80" class="field-element"><?php echo $userRow['col3']; ?></textarea>
                            </div>
                              
						

                  
                           
                           
                           
                 
                </div>
                </div>
               </div>

        </div>   
        <button id="fil_club_update" type="submit" class="button medium mat-blue-outline" name="fil_club_update" style="color:#4f9fcf;margin-bottom:20px;">Update</button>
            </form>
            </div>
       
  
   <div class="col-md-3">
        	<div class="table-responsive filmclub_rytsec" style="">
  		          <?php
                	foreach ($userRow_filmclub as $val){
					echo '<div class="responsive">
							<a href="'.SITE_URL.'edit-filmclub.php?id='.$val['id'].'">'.$val['col2'].'</a>
						</div>';
				   }
			   ?>
    </div>
</div>



           </div>
        </div>
	

        </div>
		<br style="clear:both;">
	
</section> 


<?php } ?>                  
        
	<link href="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css" rel="stylesheet"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/js/standalone/selectize.min.js"></script>
    <?php include 'footer.php';?>
    <script>
        document.title = "Film club";
	
    
		$('select').selectize({});
    
</script>
        


<script type="text/javascript">





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
					}
				}

				$("#imageUploadCvr").change(function() {
					readURLCvr(this);
				});
			
			</script>
			
    </body>
</html>
