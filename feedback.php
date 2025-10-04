<?php include 'header.php';


    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    
    echo $BY;


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
 $user_unq= $_SESSION['IdSer'];
    if(isset($_POST['info_submit'])){
        $use_platform = $_POST['use_platform'];
        $reason_for_use = $_POST['reason_for_use'];     
        $platform_goals = $_POST['platform_goals'];
        $favtool_platform =$_POST['favtool_platform']; 
        $dislike =$_POST['dislike'];    
        $satisfied =$_POST['satisfied'];  
        $what_improve = $_POST['what_improve'];
        $recommend = $_POST['recommend'];
        $survey_again = $_POST['survey_again'];
        $add_comment = $_POST['add_comment'];
        $created= date('Y-m-d h:i:s');

        $stmt = $user_home->runQuery("INSERT INTO feedback(use_platform,reason_for_use,platform_goals,favtool_platform,dislike,satisfied,what_improve,recommend,survey_again,add_comment,created,user_id,user_unq) VALUES (:use_platform, :reason_for_use,:platform_goals,:favtool_platform,:dislike,:satisfied,:what_improve,:recommend,:survey_again,:add_comment,:created,:user_id,:user_unq)");


        $stmt->bindParam(':use_platform',$use_platform);
        $stmt->bindParam(':reason_for_use',$reason_for_use);
        $stmt->bindParam(':platform_goals',$platform_goals);
        $stmt->bindParam(':favtool_platform',$favtool_platform);
        $stmt->bindParam(':dislike',$dislike);
         $stmt->bindParam(':satisfied',$satisfied);
        $stmt->bindParam(':what_improve',$what_improve);
        $stmt->bindParam(':recommend',$recommend);
        $stmt->bindParam(':survey_again',$survey_again);
        $stmt->bindParam(':add_comment',$add_comment);
        $stmt->bindParam(':created',$created);
        $stmt->bindParam(':user_id',$user_id);
        $stmt->bindParam(':user_unq',$user_unq);
        if($stmt->execute()){
        	$_SESSION['success_msg'] = 'Thank You';

        }
		else{
            $_SESSION['error_msg'] = 'something went wrong';
        }
    }
	

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

.feature_listing h2::before {
    background: #6a5a7e;
    bottom: 0;
    content:none;
    height: 2px;
    left: 38%;
    position: static;
    right: 38%;
}

</style>




<section class="feature_listing">
    <div class="container">

        <div class="row">

    <div class="main_div">
	
	<h2>Your opinion is important to us.</h2>
		
	 <p class="feed_text">Please take a minute to rate your experience that way we can keep improving our website and continue to serve you efficiently and effectively.</p> 
	
	      <span class="success_message">
                        <?php if(isset($_SESSION["success_msg"])) { echo $_SESSION["success_msg"]; unset($_SESSION["success_msg"]); }?> 
                    </span>
                    <span class="error_message">
                        <?php if(isset($_SESSION["error_msg"])) { echo $_SESSION["error_msg"]; unset($_SESSION["error_msg"]);}?> 
                    </span>
		<style>		

.feed_text {
    margin: 0 0 30px;
    font-size: 16px;
    text-align: center;
    font-family: roboto;
}

span.success_message {
    color: green;
    text-align: center;
}
span.error_message {
    color: green;
}
#ProHmbxr{position: absolute;
margin-top: 4px;
padding: 8px;
left: 0;
right: 0;bottom: -44px;}

button,#ProHmbxr button{font-size: 15px;
font-weight: 600;
z-index: 2;
position: relative;
display: inline-block;
border-radius: 3px;
text-align: center;
border: 0;
height: 40px;
line-height: 24px;
background:#d8d8d8;
color: #4b4f56 !important;
width: 100px;}

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
			.bg-white label {
                   font-size: 13px;
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
			</style>
			

		
		<div class="col-md-12">
			<div class="BxMyLv" style="overflow:unset;float:left;">
			
                    
              <form class="" method="post" enctype="multipart/form-data">
                <div class="col-md-6">
                    <div class="bg-white p20">
                        <div class="text list-features">
                            
                            <div class="form-group">
                                <label for="use_platform">How often do you use our platform?</label>
                                
                                <select name="use_platform" required="">
									
									  <option value="first time">First time</option>
									  <option value="every day">Every day</option>
									  <option value="a few times a week">A few times a week</option>
									  <option value="once in a while">Once in a while</option>
									 </select> 
							   
                            </div>

                            
                                <div class="form-group">
                                <label for="satisfied">How satisfied were you with your experience today?</label>
                                <select name="satisfied" required="">
									
									  <option value="Extremely satisfied">Extremely satisfied</option>
									  <option value="Very satisfied">Very satisfied</option>
									  <option value="Somewhat satisfied">Somewhat satisfied</option>
									  <option value="Somewhat dissatisfied">Somewhat dissatisfied</option>
									  <option value="Very dissatisfied">Very dissatisfied</option>
									  <option value="Extremely dissatisfied">Extremely dissatisfied</option>
									 </select> 
                            </div>
                             
                               <div class="form-group">
                                <label for="favtool_platform">What tool or portion of the platform do you like?</label>
                                <textarea name="favtool_platform" required="" placeholder="" rows="3" cols="80" class="field-element"></textarea>
                            </div>

                             <div class="form-group">
                                <label for="recommend">How likely are you to recommend our platform to a friend or colleague?</label>
                                <select name="recommend" required="">
									  <option value="Highly likely">Highly likely</option>
									  <option value="Somewhat likely">Somewhat likely</option>
									  <option value="Somewhat unlikely">Somewhat unlikely</option>
									  <option value="High unlikely">High unlikely</option>
									 </select> 
                            </div>

                              <div class="form-group">
                                <label for="what_improve">What would you improve if you could?</label>
                                 <textarea name="what_improve" required="" placeholder=""  rows="3" cols="80" class="field-element"></textarea>
                            </div>
                               
                             
                           
         
              
                </div>
            </div>
        </div>

        <div class="col-md-6">
                    <div class="bg-white p20">
                        <div class="text list-features">
                            
                            <div class="form-group">
                                <label for="reason_for_use">What is your main reason for using our platform today?</label>
                                <select name="reason_for_use" required="">
									  <option value="promote a film">Promote a film</option>
									  <option value="find films">Find films</option>
									  <option value="looking to invest">Looking to invest</option>
									  <option value="network">Network</option>
									  <option value="just browsing">Just browsing</option>
									 </select> 
                            </div>

                              <div class="form-group">
                                <label for="platform_goals">Do you find our platform easy to navigate and understand?</label>
                                 <select name="platform_goals" required="">
									
									  <option value="Extremely easy">Extremely easy</option>
									  <option value="Very easy">Very easy</option>
									  <option value="Somewhat easy">Somewhat easy</option>
									  <option value="Somewhat difficult">Somewhat difficult</option>
									  <option value="Very difficuly">Very difficuly</option>
									  <option value="Extremely difficult">Extremely difficult</option>
									 </select> 
                            </div>   
                               
  
                             <div class="form-group">
                                <label for="dislike">What tool or portion of the platform do you dislike?</label>
                                 <textarea name="dislike" required="" placeholder=""  rows="3" cols="80" class="field-element"></textarea>
                            </div>
                              
                               <div class="form-group">
                                <label for="survey_again">How likely are you to take this survey again?</label>
                                <select name="survey_again" required="">
									  <option value="Highly likely">Highly likely</option>
									  <option value="Somewhat likely">Somewhat likely</option>
									  <option value="Somewhat unlikely">Somewhat unlikely</option>
									  <option value="High unlikely">High unlikely</option>
									 </select> 
                            </div>

                            <div class="form-group">
                                <label for="add_comment">Do you have any additional comments or feedback for us</label>
                                <textarea name="add_comment" required="" placeholder=""  rows="3" cols="80" class="field-element"></textarea>
                            </div>
                              
         
                           
                  
                </div>
            </div>
        </div>
                <button id="info_submit" type="submit" class="button medium mat-blue-outline" name="info_submit" style="color:#4f9fcf;margin-bottom:20px;">Send</button> 
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
        document.title = "Feedback";
        $('select').selectize({});
</script>
        
    </body>
</html>
