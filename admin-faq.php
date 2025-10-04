<?php include 'header.php';


if(!$user_home->is_logged_in()){ 
	$user_home->redirect(SITE_URL);
}


{ 
    if(isset($_POST['faq_submit'])){
        $type = $_POST['type'];
        $faq_ques = $_POST['faq_ques'];
        $faq_ans = $_POST['faq_ans'];
        $stmt = $user_home->runQuery("INSERT INTO faq(type,faq_ques,faq_ans) VALUES (:type,:faq_ques,:faq_ans)");
        $stmt->bindParam(':type',$type);
        $stmt->bindParam(':faq_ques',$faq_ques);
        $stmt->bindParam(':faq_ans',$faq_ans);
       
        if($stmt->execute()){
        	$msg = 'Save Successfully';
        }
		else{
            $msg = 'something went wrong';
        }
    }

	  $stmts= $user_home->runQuery("SELECT * FROM faq");
      $stmts->execute();
      $userRow=$stmts->fetchAll(PDO::FETCH_ASSOC);
     
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
		<h2>Manage FAQ</h2>
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
				
				.main_div{
					max-width:100%;
				}
			
								.social-span{position: relative;display: inline-block;width: 48%;}
								.social-span i{position: absolute;left: 1px;top: 1px;height: 35px;background: #eee;line-height: 35px;width: 36px;text-align: center;font-size: 20px;}
								.social-span input{padding-left: 40px;}
								
								.filmclub_rytsec{border: 1px solid #ccc;}
								.filmclub_rytsec .responsive{}
								.filmclub_rytsec .responsive a{color: #000;
font-size: 12px;
display: block;
background: #f6f6f6;
padding: 5px;
border-top: 1px solid #ccc;
font-weight: 600;text-decoration: none;}


.filmclub_rytsec .responsive a:hover{color:#add8e6;}

.filmclub_rytsec .responsive:nth-child(1) a{border:0;}
							</style>
			
			
			
			
			
		
 
			
		  
        
    
		
		<div class="col-md-9">
			<div class="BxMyLv" style="overflow:unset;float:left;margin:0;background: #f6f6f6;border-radius: 4px;width:100%;padding-top:15px;">
			
            <?php if(isset($msg)  && !empty($msg)  ){
                echo $msg;
            
            } ?>           
              <form class="" method="post" enctype="multipart/form-data">
                <div class="col-md-8">
                    <div class="bg-white p20">
                        <div class="text list-features">
                            
                            

                            <div class="form-group" style="display:none">
                                <label for="company_name">Type</label>
                                <input style="" style="background:#eee;" type="text" name="type"  class="field-element" size="80" value="">
                            </div>
                           
                         
							<div class="form-group">
                                <label for="headline">FAQ Header</label>
                                <input type="text" class="field-element" id="faq_ques" name="faq_ques" value="" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="about_me">FAQ Content</label>
                                <textarea name="faq_ans" placeholder=""  rows="3" cols="80" class="field-element"></textarea>
                            </div>
                              
						

                  
                           
                           
                           
                    <button id="faq_submit" type="submit" class="button medium mat-blue-outline" name="faq_submit" style="color:#4f9fcf;margin-bottom:20px;">Save</button>
                </div>
                </div>
               </div>
            </form>
        </div>   
        
            </div>
        <div class="col-md-3">
        	<div class="table-responsive filmclub_rytsec" style="margin:0;">
  		        <?php
                	foreach ($userRow as $val){
					echo '<div class="responsive">
							<a href="'.SITE_URL.'update-faq.php?id='.$val['id'].'">'.$val['faq_ques'].'</a>
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
        document.title = "Faq";
	
    
		$('select').selectize({});
    
</script>




			
    </body>
</html>
