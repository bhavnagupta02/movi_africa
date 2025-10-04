<?php 
include 'header.php';

if(!$user_home->is_logged_in()){ 
	$user_home->redirect(SITE_URL);
}

{

     
	$user_id = $_SESSION['user_id'];
   
	  $stmts= $user_home->runQuery("SELECT * FROM admin_manage where id=1");
      $stmts->execute();
      $userRow_filmclub=$stmts->fetch(PDO::FETCH_ASSOC);

      $stmtp= $user_home->runQuery("SELECT * FROM admin_manage where id=6");
      $stmtp->execute();
      $userRow_about=$stmtp->fetch(PDO::FETCH_ASSOC);

      $stmt_home= $user_home->runQuery("SELECT * FROM admin_manage where id=7");
      $stmt_home->execute();
      $userRow_home=$stmt_home->fetch(PDO::FETCH_ASSOC);

      $stmt_term= $user_home->runQuery("SELECT * FROM admin_manage where id=8");
      $stmt_term->execute();
      $userRow_term=$stmt_term->fetch(PDO::FETCH_ASSOC);

      $stmt_policy= $user_home->runQuery("SELECT * FROM admin_manage where id=9");
      $stmt_policy->execute();
      $userRow_policy=$stmt_policy->fetch(PDO::FETCH_ASSOC);


      $stmt= $user_home->runQuery("SELECT count(*) as member from users WHERE `admin_control` = 0   ");
      $stmt->execute(array(":user_id"=>$user_id));
      $userRow_count=$stmt->fetch(PDO::FETCH_ASSOC);
    
      $stmt_complete= $user_home->runQuery("SELECT count(*) as complete from films  ");
      $stmt_complete->execute();
      $userRow_complete=$stmt_complete->fetch(PDO::FETCH_ASSOC);
   
    

      $stmt_pending= $user_home->runQuery("SELECT count(*) as pending from films where  f_stg!='complete'");
      $stmt_pending->execute();
      $userRow_pending=$stmt_pending->fetch(PDO::FETCH_ASSOC);

      $stmt_faq= $user_home->runQuery("SELECT * FROM faq where type='faq'");
      $stmt_faq->execute();
      $userRow_faq=$stmt_faq->fetch(PDO::FETCH_ASSOC);

      $stmt_feedback = $user_home->runQuery("SELECT *  FROM feedback");
	  $stmt_feedback->execute();
	  $userrow_feedback = $stmt_feedback->fetchAll( PDO::FETCH_ASSOC );

	  $stmt_contact = $user_home->runQuery("SELECT *  FROM contact ORDER by id DESC");
	  $stmt_contact->execute();
	  $userrow_contact = $stmt_contact->fetchAll( PDO::FETCH_ASSOC );
	  
	  
	  
	  
	  
	  $stmt_script = $user_home->runQuery("SELECT count(*) as script  FROM scripts");
	  $stmt_script->execute();
	  $script_count = $stmt_script->fetch( PDO::FETCH_ASSOC );
	  
	  
	  $stmt_job = $user_home->runQuery("SELECT count(*) as job  FROM jobs");
	  $stmt_job->execute();
	  $job_count = $stmt_job->fetch( PDO::FETCH_ASSOC );
	  
	  
	  $stmt_support = $user_home->runQuery("SELECT count(*) as support  FROM support");
	  $stmt_support->execute();
	  $support_count = $stmt_support->fetch( PDO::FETCH_ASSOC );
	  


echo $BY;


?>

<style>
body{
	background-color:#efefef;
}

.feature_listing{
	padding: 15px 0;
}

.feature_listing h2{
	color:#000;
}

.feature_listing h2::before {
	height:0;
}

.feature_listing .main_div .col-md-6{
	padding: 0px;
}

.feature_listing .main_div .col-md-6 div.BxMyLv{
	background: #f6f6f6;
	margin: 8px 5px 0px;
	border-radius: 4px;
	overflow: hidden;
	border: 1px solid #ddd;
}

h2.HdrProFl,.feature_listing .main_div .col-md-6 h2{
	margin: 0px;
	font-size: 22px;
	text-transform: uppercase;
	line-height: 40px;
	padding: 0;
}

h2.HdrProFl::before,.feature_listing .main_div .col-md-6 h2::before{
	height:0;
}

#CvrBxLd{
	position: relative;
	padding-top: 42px;
}

#CvrBxLd #imageUploadCvr{
	display: none;
}

#CvrBxLd #imageUploadCvr + label{
	position: absolute;
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
	width: 34px;
}

#CvrBxLd #imagePreviewCvr{
	width: 100%;
	height: 240px;
	background-size: cover;
	background-position: center;
}


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

#HelloCvr{
	background: rgba(1,1,1,.4);
	left: 0;
	right: 0;
	top: 0;
	bottom: 0;
	position: absolute;
}

#HelloCvr .DvBoxr{
	position: absolute;
	right: 20px;
	bottom: 25px;
}

#HelloCvr .DvBoxr button{
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
	background: #f5f6f7;
	color: #4b4f56;
	width: 80px;
}
</style>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
<div id="film-banner">
	<div>
		<h2>Admin Panel</h2>
	</div>	
</div>

    <section class="feature_listing">
	  <div class="container">
       <div class="row">
        <div class="main_div">
         <div class="tnumb">
		  <div class="box1"><img src="<?php echo SITE_URL; ?>images/member_icon.png" class="img_first" >
			   <span class="bx-text"> Members<br></span>
			   <span class="bx-text" style="top:60px;"><?php echo $userRow_count['member']; ?></span>
               <a href="/admin-people-list"><span class="bx-view">view</span></a>
		  </div>		
		 </div>

		 <div class="tnumb">
            <div class="box1"><img src="<?php echo SITE_URL; ?>images/film_pend.png" class="img_first" >
            <span class="bx-text">Projects<br></span>
            <span class="bx-text" style="top:60px;"><?php echo $userRow_pending['pending']; ?></span>
            <a href="/admin-project-list"><span class="bx-view">view</span></a>
            </div>
		 </div>
		 
		 
		 <div class="tnumb">
            <div class="box1"><img src="<?php echo SITE_URL; ?>images/film_pend.png" class="img_first" >
            <span class="bx-text">Scripts<br></span>
            <span class="bx-text" style="top:60px;"><?php echo $script_count['script']; ?></span>
            <a href="/admin-script-list"><span class="bx-view">view</span></a>
            </div>
		 </div>
		 
		 
		 <div class="tnumb">
            <div class="box1"><img src="<?php echo SITE_URL; ?>images/film_pend.png" class="img_first" >
            <span class="bx-text">Jobs<br></span>
            <span class="bx-text" style="top:60px;"><?php echo $job_count['job']; ?></span>
            <a href="/admin-job-list"><span class="bx-view">view</span></a>
            </div>
		 </div>
		 
		 <div class="tnumb">
            <div class="box1"><img src="<?php echo SITE_URL; ?>images/film_pend.png" class="img_first" >
            <span class="bx-text">Support<br></span>
            <span class="bx-text" style="top:60px;"><?php echo $support_count['support']; ?></span>
            <a href="/admin-support-list"><span class="bx-view">view</span></a>
            </div>
		 </div>

        </div>
       </div>
      </div>
    </section>

<section class="feature_listing">
	  <div class="container">
       <div class="row">
        <div class="main_div">
         <div class="col-md-12" style="text-align:center;">
        	<h2>Manage Website</h2>
         <div class="tnumb1">
		   <div class="box1"><img src="<?php echo SITE_URL; ?>images/home_icon.png"><span>HOME</span>		
            <a href="<?php echo SITE_URL.'admin-home.php?id='.$userRow_home['id'];?>"> <span class="bx-manage">manage</span></a>
		   </div>		
		 </div>

         <div class="tnumb1">
		  <div class="box1"><img src="<?php echo SITE_URL; ?>images/aboutus_icon.png"><span>ABOUTUS</span>
               <a href="<?php echo SITE_URL.'admin-about-us'; ?>"> <span class="bx-manage">manage</span></a>
		  </div>
		 </div>
		 <div class="tnumb1">
		  <div class="box1"><img src="<?php echo SITE_URL; ?>images/film_icon.png"><span>FILM CLUB</span>
		  	   <a href="<?php echo SITE_URL.'edit-filmclub.php?id='.$userRow_filmclub['id'];?>"> <span class="bx-manage">manage</span></a>
		  </div>
		 </div>
    
         <div class="tnumb1">
		   <div class="box1"><img src="<?php echo SITE_URL; ?>images/term_icon.png"><span>TERM</span>		
            <a href="<?php echo SITE_URL.'admin-term.php?id='.$userRow_term['id'];?>"> <span class="bx-manage">manage</span></a>
		   </div>		
		 </div>

         <div class="tnumb1">
		  <div class="box1"><img src="<?php echo SITE_URL; ?>images/privacy_icon.png"><span>POLICY</span>
               <a href="<?php echo SITE_URL.'admin-policy.php?id='.$userRow_policy['id'];?>"> <span class="bx-manage">manage</span></a>
		  </div>
		 </div>
		 <div class="tnumb1">
		  <div class="box1"><img src="<?php echo SITE_URL; ?>images/faq_icon.png"><span>FAQ</span>
		  	   <a href="<?php echo SITE_URL.'admin-faq.php'.$userRow_faq['id'];?>"> <span class="bx-manage">manage</span></a>
		  </div>
		 </div>
        </div>

         
        </div>
       </div>
      </div>
    </section>
	
    <section class="feature_listing">
	  <div class="container">
       <div class="row">

        <div class="col-sm-12">
        	<h2>Contact Form</h2>
       		<div class="table-responsive">
  		     <?php /*   <table id="example" class="table table-striped table-bordered">
    			<thead>
    				<tr>
    					
    					<th scope="col">Sr No.</th>
    					<th scope="col">Email</th>
    					<th scope="col">Subject</th>
    					<th scope="col">Message</th>
    					<th scope="col">Date</th>
    				<!-- 	<th scope="col">Status</th>
    					<th scope="col">Action</th> -->
    					
    				</tr>
    			</thead>
            <tbody>
                <?php
                 $i=1;
                foreach ($userrow_contact as $val){
					
                  ?>
                 
                <tr >
                   <td><?php echo $i; ?></td>
                   <td><?php echo $val['email']; ?></td>
                  	<td><?php echo $val['subject']; ?></td>
                  	 <td><?php echo $val['message']; ?></td>
                  	  <td><?php echo date('j F, Y' ,strtotime($val['created'])); ?></td>
                </tr>
               <?php
               $i++;
               }
               ?>
            

                
              </tbody>
             </table> */ ?>
             
             <table id="example" class="table table-striped table-bordered" style="width:100%">
            	<thead>
            		<tr>
            		
            			<th>Sr No.</th>
        				<th>Email</th>
        				<th>Subject</th>
        				<th>Message</th>
        				<th>Date</th>
            			
            		</tr>
            	</thead>
                 <tbody>
                    <?php
                     $i=1;
                    foreach ($userrow_contact as $val){
    					
                      ?>
                     
                    <tr >
                       <td><?php echo $i; ?></td>
                       <td><?php echo $val['email']; ?></td>
                      	<td><?php echo $val['subject']; ?></td>
                      	 <td><?php echo $val['message']; ?></td>
                      	  <td><?php echo date('j F, Y' ,strtotime($val['created'])); ?></td>
                    </tr>
                   <?php
                   $i++;
                   }
                   ?>
                
    
                    
                  </tbody>
             
            </table>
            </div>

         </div>


		<?php /* <div class="col-md-5">
        	<h2>Feedback LIst</h2>
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
                foreach ($userrow_feedback as $val){
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
                    <td><a href="<?php echo SITE_URL.'view_feedback.php?id='.$val['id'];?>"><i class="fa fa-eye" aria-hidden="true"></i>view</a></td>
                </tr>
               <?php
               $i++;
               }
               ?>
            

                
              </tbody>
             </table>
            </div>

         </div>*/ ?>

		 
       </div>
      </div>
    </section>


<style>	

		.box1 {
			width: 100%;
			height: 114px;
			display: table-cell;
			vertical-align: middle;
			text-align: center;
			background-color: #32517c;
			color: #fff;
			position: relative;
			border-radius: 5px;
			max-width: 314px;
        }
		.tnumb {
		    float: left;
		    width: 33.3%;
		    padding: 0 15px;
		    display: table;
		    padding-top: 13px;
		}
		.tnumb1 {
			width: 180px;
			display: inline-block;
			margin: 7px 2px;
		}
		
		.tnumb1 .box1{display:block;}
		.tnumb1 .box1 img{position: absolute;

left: 50%;

width: 48px;

margin-left: -24px;

top: 5px;}
		.tnumb1 .box1 a{position: absolute;

left: 30px;text-decoration:none;

bottom: 10px;

right: 30px;

border: 2px solid #fff;

border-radius: 4px;}

.tnumb1 .box1 a:hover{color:#000;background:#fff;}
.tnumb1 .box1 a:hover span{color:#000;}

		.tnumb1 .box1 a span{position: unset;

border: 0;

padding: 0;

line-height: 18px;

font-size: 14px;

text-transform: capitalize;}
		.tnumb1 .box1 span{position: absolute;

left: 0px;

right: 0px;

text-align: center;

top: 52px;

font-size: 18px;}
		
		
		span.bx-view {
			position: absolute;
			top: 42px;
			right: 15px;
			color: #fff;
			font-size: 14px;
			border: 2px solid #fff;
			border-radius: 5px;
			padding: 3px 12px;
			font-weight: 600;
			line-height: 20px;
		}

		span.bx-view:hover{color:#000;background:#fff;}
		
		span.bx-manage {
		    position: absolute;
			bottom: 10px;
		    right: 50px;
		    color: #fff;
	        border: 1px solid #fff;
		    border-radius: 0px;
		    padding: 2px 3px;
		}

		img.img_first {
			position: absolute;
			left: 6px;
			top: 24px;
			width: 64px;
        }

		.bg-green{
	    	background-color: Green;
		}

		.bg-red{
	    	background-color: darkgoldenrod;
		}

		.box1 span.bx-text {
			position: absolute;
			left: 75px;
			top: 35px;
			font-size: 16px;
        }

		#film-banner{
			/*background-image:url('/images/DSC100486335.jpg');*/
			height:160px;
			width:100%;
			background-size: cover;
		    background-position: center 380px;
		    position: relative;
		}

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

		#film-banner div h2{
		margin: 0;
		padding: 0;
		font-size: 28px;
		font-weight: 600;
		text-transform: capitalize;
		}

		#film-banner div a{
			transition: all ease-in-out .3s;
			color: #fff;
			border: 1px solid #fff;
			border-radius: 4px;
			font-size: 14px;
			text-decoration: none;
			padding: 1px 16px;
			cursor: pointer;
			font-weight: 600;
			display: inline-block;
		    margin-top: 18px;
		}
		
		#ProHmbxr{
			position: absolute;
			margin-top: 4px;
			padding: 8px;
			left: 0;
			right: 0;bottom: -44px;
		}

		button,#ProHmbxr button{
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
			background:#d8d8d8;
			color: #4b4f56 !important;
			width: 80px;
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
							
		.main_div{
			max-width:100%;
		}
			
		.social-span{
			position: relative;
			display: inline-block;
			width: 48%;
		}

		.social-span i{
			position: absolute;left: 1px;
			top: 1px;
			height: 35px;
			background: #eee;
			line-height: 35px;
			width: 36px;
			text-align: center;
			font-size: 20px;
		}

		.social-span input{
			padding-left: 40px;
		}
										
		.filmclub_rytsec{
			border: 1px solid #ccc;
		}
		.filmclub_rytsec .responsive{}

		.filmclub_rytsec .responsive a{
			color: #000;
			font-size: 12px;
			display: block;
			background: #f6f6f6;
			padding: 5px;
			border-top: 1px solid #ccc;
			font-weight: 600;text-decoration: none;
		}


		.filmclub_rytsec .responsive a:hover{
			color:#add8e6;
		}

		.filmclub_rytsec .responsive:nth-child(1) a{
			border:0;
		}

		.table-responsive {
		    min-height: .01%;
		    overflow-x: auto;
		    margin: 14px;
		}
</style>
<?php } ?>                  






	<link href="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css" rel="stylesheet"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/js/standalone/selectize.min.js"></script>
	
	
	<script>
	    $(document).ready(function() {
            $('#example').DataTable();
        } );
	</script>
	
	
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>

	
	
    <?php include 'footer.php';?>
    <script>
        document.title = "Admin";
		$('select').selectize({});
    </script>
    </body>
</html>
