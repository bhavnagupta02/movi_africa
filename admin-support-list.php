<?php 
include 'header.php';

if(!$user_home->is_logged_in()){ 
	$user_home->redirect(SITE_URL);
}

{

    $stmt_films = $user_home->runQuery("SELECT users.user_name,users.user_unq,support.title,support.description,support.category,support.location,support.url,support.created_at,support.del,support.id,support.status
        FROM support
        INNER JOIN users
        ON support.user_id = users.user_unq ORDER by support.id DESC ");

    $stmt_films->execute();
    $films = $stmt_films->fetchAll( PDO::FETCH_ASSOC );


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


	
    <section class="feature_listing">
	  <div class="container">
       <div class="row">

        <div class="col-sm-12">
        	<h2>Support List</h2>
       		<div class="table-responsive">
  	
            <div id="msg"></div>    
            <table id="example" class="table table-striped table-bordered" style="width:100%">
            	<thead>
            		<tr>
            		
            			<th>Sr No.</th>
        				<th>Organisation Name</th>
        				<th>Country</th>
        				<th>Category</th>
        				<th>Description</th>
        				<th>Created By</th>
        				<th>Date</th>
            			<th>Action</th>
            		</tr>
            	</thead>
                 <tbody>
                    <?php
                     $i=1;
                    foreach ($films as $val){
    					
                      ?>
                     
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $val['title']; ?></td>
                        <td><?php echo $val['location']; ?></td>
                        <td><?php echo str_replace(',', ", ", $val['category']); ?></td>
                        <td><?php echo $val['description']; ?></td>

                        <td><?php if(!empty($val['user_name'])){ echo $val['user_name']; }else{ echo 'N/A'; }  ?></td>
    
              
                        
                        <td><?php echo date('j F, Y' ,$val['created_at']); ?></td>
                        
                        <td>
                   
                            <?php   if($val['del']=="1"){  ?>
                                        <button  type="button" class="btn btn-primary" onclick="changestatus(<?php echo $val['id']; ?>,'0')" ><span style="color:#6a46d4;"> Undo(Deleted)</span></span></button>
                          
                                        
                            <?php   }else{  ?>
                                <button type="button" class="btn btn-danger" onclick="changestatus(<?php echo $val['id']; ?>,'1')" >  <i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                   
                                        
                             <?php  }   ?>
                        
                        </td>
                    </tr>
                   <?php
                   $i++;
                   }
                   ?>
                
    
                    
                  </tbody>
             
            </table>
            </div>

         </div>



		 
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
        document.title = "Support List";
		$('select').selectize({});
    </script>
    
    <script>
function changestatus(id,status){
    var status = status;
    var id = id;
    $("#msg").val('');
    
   

    var r = confirm("Are you sure");
    if (r){
            
        $.ajax('/change_support_status', {
            dataType: 'text', // type of response data
            data:{"id":id,"status":status},
            type: "POST",
    
            success: function (data) {   // success callback function
                
                if(data==1){
               
                    $("#msg").text('Support status updated successfully');
                    $('#msg').css({ 'color': 'green'});
                    setTimeout(function(){ 
                        location.reload();
                    }, 1000);
                }else{
                    
                    $("#msg").text('Please try again');
                    $('#msg').css({ 'color': 'red'});
                    setTimeout(function(){ 
                        location.reload();
                    }, 1000);
                }
            },
            error: function () { // error callback 
                console.log();
            }
        });
    }else{
        return false;
    }

}
</script>
    </body>
</html>
