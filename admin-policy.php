<?php include 'header.php';

if(!$user_home->is_logged_in()){ 
	$user_home->redirect(SITE_URL);
}

$stmts= $user_home->runQuery("SELECT * FROM admin_manage WHERE id=9");
      $stmts->execute();
      $userRow=$stmts->fetch(PDO::FETCH_ASSOC);


   $id=9;

    if(isset($_POST['term_update'])){
        $type = $_POST['type'];
        $col1 = $_POST['col1'];
       
        
    
        
       $stmt = $user_home->runQuery("UPDATE admin_manage SET type=:type,col1=:col1 WHERE id=:id");

        $stmt->bindParam(':type',$type);
        $stmt->bindParam(':col1',$col1);
      
       

        $stmt->bindParam(':id',$id);
        if($stmt->execute()){
        	$msg = 'Update successfully';
        }
		else{
            $msg = 'Something went wrong';
        }
    }

	

	 $stmts= $user_home->runQuery("SELECT * FROM admin_manage WHERE id=9");
      $stmts->execute();
      $userRow=$stmts->fetch(PDO::FETCH_ASSOC);

     

	echo $BY;

      

  
?>

<style>
body{background-color:#efefef;}
.col-md-6{
        width: 100%;
}

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
		<h2>Manage Privacy Content Page</h2>
	</div>	
</div>

<section class="feature_listing">
    <div class="container">
        <div class="row">
    <div class="main_div">
	

		<style>	

#film-banner{
/*    background-image:url('/images/DSC100486335.jpg');*/
height:160px;width:100%;background-size: cover;
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
width: 80px;}

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
					overflow: hidden;
					width: 148px;
				}
				
				.avatar-upload .avatar-edit{
					left: 110px;
					position: absolute;
					top: 10px;
					z-index: 1;
				}
				
				.avatar-upload .avatar-edit input {
					display: none;
				}
				
				.avatar-upload .avatar-edit input + label {
					background: #ffffff none repeat scroll 0 0;
					border: 3px solid #fc5c0f;
					border-radius: 100%;
					box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.12);
					cursor: pointer;
					display: inline-block;
					font-weight: normal;
					height: 34px;
					margin-bottom: 0;
					transition: all 0.2s ease-in-out 0s;
					width: 34px;
				}
				
				.avatar-upload .avatar-edit input + label::after {
					content: "\f040";
					font-family: 'FontAwesome';
					color: #757575;
					position: absolute;
					top: 10px;
					left: 0;
					right: 0;
					text-align: center;
					margin: auto;
				}
				
				.avatar-upload .avatar-preview {
					border: 4px solid #fc5c0f;
					border-radius: 100%;
					box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
					height: 140px;
					position: relative;
					width: 140px;
					float: left;
				}
				
				.avatar-upload .avatar-preview > div {
					width: 100%;
					height: 100%;
					border-radius: 100%;
					background-size: cover;
					background-repeat: no-repeat;
					background-position: center;
				}
			</style>
				<style>
								.social-span{position: relative;display: inline-block;width: 48%;}
								.social-span i{position: absolute;left: 1px;top: 1px;height: 35px;background: #eee;line-height: 35px;width: 36px;text-align: center;font-size: 20px;}
								.social-span input{padding-left: 40px;}
							</style>
			
			
			
			
			
		
 
			
		  
        
    
		
		<div class="col-md-6">
			<div class="BxMyLv" style="overflow:unset;float:left;width: 100%;padding-top:15px;">
            <?php if(isset($msg)  && !empty($msg)  ){
                echo $msg;
            
            } ?>           
              <form class="" method="post" enctype="multipart/form-data">
                <div class="col-md-8">
                    <div class="bg-white p20">
                        <div class="text list-features">
                            
                            

                            <div class="form-group" style="display:none;">
                                <label for="company_name">Type</label>
                                <input style="" style="background:#eee;" type="text" name="type"  class="field-element" size="80" value="<?php echo $userRow['type']; ?>">
                            </div>
                           
                     
                            <div class="form-group">
                                <textarea id="col1" name="col1" placeholder="about me"  rows="3" cols="80" class="field-element"><?php echo $userRow['col1']; ?></textarea>
                            </div>
                              
			

                           
                    <button id="term_update" type="submit" class="button medium mat-blue-outline" name="term_update" style="color:#4f9fcf;margin-bottom:20px;">update</button>
                </div>
                </div>
               </div>
            </form>
        </div>   
        
            </div>
       





           </div>
        </div>
	

        </div>
		<br style="clear:both;">
	
</section> 

    
        
	
    <?php include 'footer.php';?>
    
     <script src="https://cdn.ckeditor.com/4.11.2/standard/ckeditor.js"></script>
    <script>
        document.title = "Admin Policy Manage Page";
	</script>
        
         <script>

            CKEDITOR.replace('col1');
          </script>

    </body>
</html>
