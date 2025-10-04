<?php include 'header.php';?>

<?php       

    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    

    if($user_home->is_logged_in()){ 
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
    if($_SESSION['admin_control']==0){
   
     echo '<script>window.location.href="'.SITE_URL.'feedback.php";</script>';
    }


    echo $BY;

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
//$user_id = $_SESSION['user_id'];
 $user_unq= $_SESSION['IdSer'];
  
 $read_status=0;
    $stmt = $user_home->runQuery("SELECT *  FROM feedback where read_status=0");

	$stmt->execute(array(':read_status'=>$read_status));
	$userrow = $stmt->fetchAll( PDO::FETCH_ASSOC );





?>
  <style type="text/css">
.bg-green{
background-color: Green;
}
.bg-red{
background-color: darkgoldenrod;
}
</style>
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




<section class="feature_listing">
    <div class="container">

        <div class="row">

    <div class="main_div">
	
	<h2>Feedback List</h2>
		
	
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
				/*.pending_list{
					float: right;
				}*/
			</style>
			
          
			<div class="table-responsive">
  		<table id="example" class="table table-striped table-bordered">
			<thead>
				<tr>
					
					<th scope="col">Sr No.</th>
					<th scope="col">Platform Use</th>
					<th scope="col">Reason For Use</th>
					<th scope="col">Satisfied</th>
					<th scope="col">By</th>
					<th scope="col">Status</th>
					<th scope="col">Action</th>
					
				</tr>
			</thead>
            <tbody>
                <?php
                 $i=1;
                foreach ($userrow as $val){
                	$user_id=$val['user_id'];
                	$stmts = $user_home->runQuery("SELECT user_name,user_unq FROM users where user_id=:user_id");

					$stmts->execute(array(':user_id'=>$user_id));
					$userrow_name = $stmts->fetch( PDO::FETCH_ASSOC );
					
                  ?>
                 
                <tr >
                 	
                  	<td><?php echo $i; ?></td>
                  	<td><?php echo $val['use_platform']; ?></td>
                  	<td><?php echo $val['reason_for_use']; ?></td>
                  	<td><?php echo $val['satisfied']; ?></td>
                  	<td><a href="<?php echo SITE_URL.'profile_info.php?id='.$userrow_name['user_unq'];?>"><?php echo $userrow_name['user_name']; ?></a></td>
                  	<td><?php if($val['read_status']==1){ ?>
                  		  <span class="badge bg-green">Read</span>
                  		 <?php }else{ ?>
                             <span class="badge bg-red">Pending</span>
                  		<?php } ?> 	
                  	</td>
                    <td><a href="<?php echo SITE_URL.'view_feedback.php?id='.$userrow_name['user_unq'];?>"><i class="fa fa-eye" aria-hidden="true"></i>view</a></td>
                	</tr>
               <?php
               $i++;
               }
               ?>
            

                
            </tbody>
        </table>
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

 $(document).ready(function() {
    $('#example').DataTable();
} );


</script>
        
    </body>
</html>
