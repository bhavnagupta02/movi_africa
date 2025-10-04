<?php include 'header.php';

if(!$user_home->is_logged_in()){ 
    $user_home->redirect(SITE_URL);
}
 
  
  
  $stmts= $user_home->runQuery("SELECT * FROM manage_about_us WHERE id=1");
  $stmts->execute();
  $userRow=$stmts->fetch(PDO::FETCH_ASSOC);

    if(isset($_POST['about'])){
        
                
        $section_1_heading_1 = $_POST['section_1_heading_1'];
        $section_1_heading_2 = $_POST['section_1_heading_2'];
        
        
        if(!empty($_FILES['section_1_background_image']['name'])){
     
            $target_dir = "webimg/";
    
            $file_upload = $target_dir . basename(time().$_FILES["section_1_background_image"]["name"]);
            $section_1_background_image =  basename(time().$_FILES["section_1_background_image"]["name"]);
           
            $imageFileType = strtolower(pathinfo($file_upload,PATHINFO_EXTENSION));
            $extensions_arr = array("jpg","jpeg","png","gif");
    
             // Check extension
            if(! in_array($imageFileType,$extensions_arr) ){
                $_SESSION['error_message'] = 'Please choose only jpg,jpeg,png,gif';    
            }else{
                move_uploaded_file($_FILES['section_1_background_image']['tmp_name'],$file_upload);
            }
      
        }else{
            $section_1_background_image = $userRow['section_1_background_image'];
        }
        
        
        if(!empty($_FILES['section_1_image']['name'])){
     
            $target_dir = "webimg/";
    
            $file_upload2 = $target_dir . basename(time().$_FILES["section_1_image"]["name"]);
            $section_1_image =  basename(time().$_FILES["section_1_image"]["name"]);
           
            $imageFileType = strtolower(pathinfo($file_upload2,PATHINFO_EXTENSION));
            $extensions_arr = array("jpg","jpeg","png","gif");
    
             // Check extension
            if(! in_array($imageFileType,$extensions_arr) ){
                $_SESSION['error_message'] = 'Please choose only jpg,jpeg,png,gif';    
            }else{
                move_uploaded_file($_FILES['section_1_image']['tmp_name'],$file_upload2);
            }
      
        }else{
            $section_1_image = $userRow['section_1_image'];
        }
        
        
        
        
        $section_2_title = $_POST['section_2_title'];
        $section_2_description = $_POST['section_2_description'];
        
        
        
        if(!empty($_FILES['section_2_image']['name'])){
     
            $target_dir = "webimg/";
    
            $file_upload3 = $target_dir . basename(time().$_FILES["section_2_image"]["name"]);
            $section_2_image =  basename(time().$_FILES["section_2_image"]["name"]);
           
            $imageFileType = strtolower(pathinfo($file_upload3,PATHINFO_EXTENSION));
            $extensions_arr = array("jpg","jpeg","png","gif");
    
             // Check extension
            if(! in_array($imageFileType,$extensions_arr) ){
                $_SESSION['error_message'] = 'Please choose only jpg,jpeg,png,gif';    
            }else{
                move_uploaded_file($_FILES['section_2_image']['tmp_name'],$file_upload3);
            }
      
        }else{
            $section_2_image = $userRow['section_2_image'];
        }
        
       $stmt = $user_home->runQuery("UPDATE manage_about_us SET 
       section_1_heading_1=:section_1_heading_1,
       section_1_heading_2=:section_1_heading_2,
       section_1_background_image=:section_1_background_image,
       section_1_image=:section_1_image,
       section_2_title=:section_2_title,
       section_2_description=:section_2_description,
       section_2_image=:section_2_image
       
        WHERE id=1");

        $stmt->bindParam(':section_1_heading_1',$section_1_heading_1);
        $stmt->bindParam(':section_1_heading_2',$section_1_heading_2);
        $stmt->bindParam(':section_1_background_image',$section_1_background_image);
        $stmt->bindParam(':section_1_image',$section_1_image);
        $stmt->bindParam(':section_2_title',$section_2_title);
        $stmt->bindParam(':section_2_description',$section_2_description);
        $stmt->bindParam(':section_2_image',$section_2_image);

        if($stmt->execute()){
           
            $_SESSION['succ_message'] = "About us updated successfully";
         
        }
        else{
     
           $_SESSION['error_message'] = "Something went wrong";
   
        }
    }

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
        <h2>Manage About Us</h2>
    </div>  
</div>

<section class="feature_listing">
    <div class="container">
        <div class="row">
    <div class="main_div">
    

<style> 
        
#film-banner{background-image:url('http://school298.spb.ru/images/400/DSC100486335.jpg');height:160px;width:100%;background-size: cover;
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
margin-left: 457px;
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
.field-element-btn {
    width: 50%;
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
top: -30px;
height: 24px;left:0;
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
padding-left: 24px;
margin-bottom: 0;
transition: all 0.2s ease-in-out 0s;
width: 200px;
text-align: left;border-radius:3px;
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
height: 224px;
position: relative;
background-color: skyblue;
width: 460px;
float: left;border-radius:3px;
}

.avatar-upload .avatar-preview > div {
width: 100%;
height: 100%;

background-size: contain;
background-repeat: no-repeat;
background-position: center;
}
</style>
<style>
.social-span{position: relative;display: inline-block;width: 48%;}
.social-span i{position: absolute;left: 1px;top: 1px;height: 35px;background: #eee;line-height: 35px;width: 36px;text-align: center;font-size: 20px;}
.social-span input{padding-left: 40px;}


span.success_message {
    color: #50d8af;
}
span.error_message {
    color: red;
}
</style>
            

        
        <div class="col-md-12">
            <div class="BxMyLv" style="overflow:unset;float:left;">
        
              
              <form class="" method="post" enctype="multipart/form-data">
                <span class="success_message">
                    <?php if(isset($_SESSION["succ_message"])) { echo $_SESSION["succ_message"]; unset($_SESSION["succ_message"]);  echo '<script> setTimeout(function(){ window.location.href = "'.SITE_URL.'admin-about-us"; }, 2000);   </script>'; }?> 
                </span>
                <span class="error_message">
                    <?php if(isset($_SESSION["error_message"])) { echo $_SESSION["error_message"]; unset($_SESSION["error_message"]);  echo '<script> setTimeout(function(){ window.location.href = "'.SITE_URL.'admin-about-us"; }, 2000);   </script>'; }?> 
                </span> 
                               
                <div class="col-md-12 ryt_sec">
                    <div class="bg-white p20">
                        <div class="text list-features">

                            <div class="form-group">
                                <label for="headline"> Section First Title First</label>
                                <input type="text" class="field-element" id="headline" name="section_1_heading_1" value="<?php echo $userRow['section_1_heading_1']; ?>" placeholder="Section First Title First">
                            </div>
                           <div class="form-group">
                                <label for="headline"> Section First Title Second</label>
                                <input type="text" class="field-element" id="headline" name="section_1_heading_2" value="<?php echo $userRow['section_1_heading_2']; ?>" placeholder="Section First Title Second">
                            </div>

                            <?php 
                            if ($userRow['section_1_background_image']!="") {  ?>
                                <div class="form-group">
                                    <label for="headline"> Section First Current Background Image </label>
                                    <img src="<?php echo SITE_URL;?>webimg/<?php echo $userRow['section_1_background_image']; ?>">
                                </div> 
                                
                           <?php  } ?>

                            


                            <div class="form-group">
                                <label for="headline">Section First Background Image </label>
                                <input type="file" class="field-element" id="section_1_background_image" name="section_1_background_image" >
                            </div>

                               <?php 
                            if ($userRow['section_1_image']!="") {  ?>
                                <div class="form-group">
                                    <label for="headline"> Section First Current Image </label>
                                    <img src="<?php echo SITE_URL;?>webimg/<?php echo $userRow['section_1_image']; ?>">
                                </div> 
                                
                           <?php  } ?>

                            <div class="form-group">
                                <label for="headline">Section First Image </label>
                                <input type="file" class="field-element" id="section_1_image" name="section_1_image" >
                            </div>
                           
                           <div class="form-group">
                                <label for="headline"> Section Second Title </label>
                                <input type="text" class="field-element" id="headline" name="section_2_title" value="<?php echo $userRow['section_2_title']; ?>" placeholder="Section Second Title">
                            </div>
                            
                           <div class="form-group">
                                <label for="headline"> Section Second Description</label>
                              <!--  <input type="text" class="field-element" id="headline" name="section_2_description" value="<?php //echo $userRow['section_2_description']; ?>" placeholder="Section Second Title Description">-->
                                
                               <textarea class="field-element" placeholder="Section Second Description" name="section_2_description"><?php echo $userRow['section_2_description']; ?></textarea>
                            </div>


                            <?php 
                            if ($userRow['section_2_image']!="") {  ?>
                                <div class="form-group">
                                    <label for="headline"> Section Second Current Image </label>
                                    <img src="<?php echo SITE_URL;?>webimg/<?php echo $userRow['section_2_image']; ?>">
                                </div> 
                                
                           <?php  } ?>
                            
                            <div class="form-group">
                                <label for="headline">Section Second Image </label>
                                <input type="file" class="field-element" id="section_2_image" name="section_2_image" >
                            </div>
                   
                </div>
              </div>  
              </div>
             
        </div>   
        
            </div>
       

            <button id="fil_club_update" type="submit" class="button medium mat-blue-outline" name="about" style="color:#4f9fcf;margin-bottom:20px;">Update</button>
            </form>



           </div>
        </div>
    

        </div>
        <br style="clear:both;">
    
</section> 

    <?php include 'footer.php';?>
    <script>
        document.title = "About Us";
    </script>
        

            
    </body>
</html>
