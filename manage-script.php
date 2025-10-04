<?php include 'header.php';


    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    $user_id = $_SESSION['IdSer'];


	if(isset($_POST) && $_POST['f_name']){

	    $id = $_GET['id'];
        $stmt= $user_home->runQuery("SELECT * FROM scripts WHERE url=:id"); 
        $stmt->execute(array(":id"=>$id));
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
	        
		$vlss='2';

		$f_name = $_POST["f_name"];
		$summary = $_POST["summary"];
		$f_genre = implode (",",$_POST['f_genre']);
	    $f_stg = $_POST["f_stg"];
		
        $created = time();
	

        if($_GET['id'] == ''){  
            $url= preg_replace('/[^A-Za-z0-9-]+/', '-',$_POST["f_name"]).'-'.time();
        }else{
            $url = $_GET['id'];
        }


			if($_GET['id'] != ''){
			
		
				
				$stmt = $user_home->runQuery("UPDATE scripts SET 
				    f_name=:f_name,
				    summary=:summary,
				    f_genre=:f_genre,
				    f_stg=:f_stg
				
				    WHERE url=:url");

				$stmt->bindParam(':f_name',$f_name);
				$stmt->bindParam(':summary',$summary);
				$stmt->bindParam(':f_genre',$f_genre);
				$stmt->bindParam(':f_stg',$f_stg);
	            $stmt->bindParam(':url',$url);	

				if($stmt->execute()){
		
					$Pt = SITE_URL.'manage-script?id='.$url.'&smsg=update';
					echo '<script>window.location.href = "'.$Pt.'"; </script>';
				}
			}else{
				$stmt = $user_home->runQuery("INSERT INTO scripts(f_name,summary,f_genre,f_stg,user_id,created_at,url) VALUES (:f_name,:summary,:f_genre,:f_stg,:user_id,:created_at,:url)");
	
				$stmt->bindParam(':f_name',$f_name);
				$stmt->bindParam(':summary',$summary);
				$stmt->bindParam(':f_genre',$f_genre);
				$stmt->bindParam(':f_stg',$f_stg);
			
				$stmt->bindParam(':user_id',$user_id);
				$stmt->bindParam(':created_at',$created);
	            $stmt->bindParam(':url',$url);
	            
				if($stmt->execute()){
				
					$Pt = SITE_URL.'manage-script?id='.$url.'&smsg=added';
					echo '<script>window.location.href = "'.$Pt.'"; </script>';
				}

			}

	  
	}  
	else{
		if($_GET['id'] != ''){
		  $user_id = $_SESSION['IdSer'];
		  $id = $_GET['id'];
		  $stmt= $user_home->runQuery("SELECT * FROM scripts WHERE url=:id"); 
		  $stmt->execute(array(":id"=>$id));
		  $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
	
		
			  if($userRow['user_id'] != $_SESSION['IdSer']){
				  echo '<script>window.location.href="'.SITE_URL.'manage-script";</script>';
			  }
		  
		  
		  $_POST = $userRow;
		  $vlss ='1';
		 
		}
		else{
		  $vlss ='2';
		}
		
	} 

	
    echo $BY;

	 
?>  

<?php
    if($_POST['f_stg'] == 'Complete'){
    	$Sg['Complete']='Complete';
    }
    else{	
    	$Sg['In Progress']='In Progress';
    	$Sg['Complete']='Complete';
    }	
?>

<link href="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/css/datepicker.min.css"/>

<style>

.avatar-upload .avatar-edit input + label{
    border: 1px solid #32517c;
}

.avatar-upload .avatar-edit{
    left: 114px;
position: absolute;
top: 3px;
z-index: 1;
}

#CvrBxLd #imageUploadCvr{
	display: none;
}
#CvrBxLd #imageUploadCvr + label{
	position: absolute;
	left: 120px;
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

.selectize-control.single .selectize-input, .selectize-dropdown.single{
    min-height:36px;
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

#avatar-upload{
position: absolute;
left: 50%;
top: 50%;
margin-top: -70px;
margin-left: -70px;
width: 140px;
height: 140px;
}

.avatar-edit{
position: absolute;
bottom: -12px;
left: 50%;

width: 26px;

margin-left: -13px;

border-radius: 100%;

height: 26px;
}
	  
#avatar-upload input{
	display: none;
}

#avatar-upload input + label{
background:#fc5c0f;
border-radius: 100%;
cursor: pointer;

display: inline-block;

font-weight: normal;

height: 24px;

margin-bottom: 0;

transition: all 0.2s ease-in-out 0s;

width: 100%;
}

#avatar-upload input + label::after{
	content: "\f040";
	font-family: 'FontAwesome';
	color: #fff;
	position: absolute;
	top: 3px;
	left: 0;
	right: 0;
	text-align: center;
	margin: auto;
}


#avatar-upload #imagePreview{
	width:140px;height:140px;border-radius:100%;background-position:center center;background-size:cover;
}

.form-group{position:relative;}
.form-group label{}
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
.form-group span.error{position: absolute;
right: 4px;
top: 5px;
color: red;
font-weight: 600;
font-size: 11px;}

.form-group .Col-50{display: inline-block;width: calc(50% - 2px);}
.form-group .Col-70{display: inline-block;width: calc(70% - 2px);}
.form-group .Col-30{display: inline-block;width: calc(30% - 2px);}

/*--------RESPONSIVE----------------*/
@media (min-width:320px) and (max-width:639px) {
.form-group .Col-50{display: inline-block;width: calc(100% - 2px);}
 .form-group .Col-70{display: inline-block;width: calc(100% - 2px);}
.form-group .Col-30{display: inline-block;width: calc(100% - 2px);}   
}


</style>


<section class="jobAdd-Section script-manage">
    <div class="container">
        <div class="row">
           
            
			<div class="col-md-12">	
			
			<span class="success_message">
                    <?php 
                    if($_GET['smsg'] == 'added'){
                        echo "Script added successfully";
                        echo "<script>setTimeout(function() { $('.success_message').fadeOut('slow'); }, 5000);</script>";
                    }
                     
                    if($_GET['smsg'] == 'update'){
                        echo "Script updated successfully";
                        echo "<script>setTimeout(function() { $('.success_message').fadeOut('slow'); }, 5000);</script>";    
                        
                    }
                    
                    ?> 
                </span>
                <span class="error_message">
                    <?php 
                    if(isset($succ_message)){
                        echo $error_message;
                        echo "<script>setTimeout(function() { $('.error_message').fadeOut('slow'); }, 5000);</script>"; 
                    }
                        
                    ?> 
                </span>
			
			<h2>Script Details</h2>
			
	
				<form method="post" enctype="multipart/form-data">
				<div class="form-group">
                    <label for="company_name">Title</label>
                    <input type="text" class="field-element" name="f_name" value="<?php echo $_POST['f_name'];?>" id="f_name" placeholder="Enter Script Title" required>
              
                </div>
			
				<div class="form-group">
                    <label for="company_name">Film Genre</label>
                    <select required multiple name="f_genre[]" id="f_genre" placeholder="Choose Film Genre">
						<?php	foreach(array("Action","Crime","Music","Suspense","Adventure","Documentary","Mystery","Thriller","Animation","Drama","Romance","True","story","Biography","Family","Sci-Fi","War","Comedy","Horror","Sport","Western") as $v){ echo '<option value="'.$v.'">'.$v.'</option>';} ?>
					</select>
                      
                </div>
				
				<div class="form-group">
                    <label for="company_name">Stage</label>
                   <select required name="f_stg" id="f_stg" placeholder="Choose Stage">
						<?php	
							foreach($Sg as $ky => $vl){ echo '<option value="'.$ky.'">'.$vl.'</option>';} 
						?>
					</select>
      
                </div>
                
                
                <div class="form-group input-area">
                    <label for="company_name">Summary</label>
                    <textarea required class="field-element"  placeholder="Enter Summary" name="summary"><?php echo $_POST['summary'];?></textarea>
               
                </div>
                

				<div class="form-group">	

					<button id="info_contact" type="submit" name="info_contact" >Submit</button>

				</div>	
					

				</form>
			</div>   
			
        </div>
    </div>
</section>  


    <?php include 'footer.php';?>
    <script>
        document.title = "Film Script";
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/js/standalone/selectize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.min.js"></script>
    
    <script>
		var lsv = [];
		var vl = "<?php echo $vlss;?>";
		var Us=  <?php echo json_encode($Psh,TRUE);?>;
	if(1 == vl){	
		lsv[0] = "<?php echo $_POST['f_genre'];?>";
		lsv[1] = "<?php echo $_POST['f_stg'];?>";
		
		var ls =['f_genre','f_stg'];
		for(var i=0;i<ls.length;i++){
			$("#"+ls[i]).val(lsv[i].split(','));
		}
	}
	else if(2 == vl){
		lsv[0] = <?php echo json_encode($_POST['f_genre']);?>;
		lsv[1] = "<?php echo $_POST['f_stg'];?>";
		
		
		var ls =['f_genre','f_stg'];
		
		for(var i=0;i<ls.length;i++){
			$("#"+ls[i]).val(lsv[i]);
		}
	}	
		



		(function($) {
		  $.fn.inputFilter = function(e) {
			return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
			  if (e(this.value)) {
				this.oldValue = this.value;
				this.oldSelectionStart = this.selectionStart;
				this.oldSelectionEnd = this.selectionEnd;
			  } else if (this.hasOwnProperty("oldValue")) {
				this.value = this.oldValue;
				this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
			  }
			});
		  };
		}($));
		

		$("#f_run").inputFilter(function(value) {
		  if(value < 301) return /^\d*$/.test(value);
		});
		
		
		
		var Jsk={},Asj={},JsR={},Td=[];	
		$('#TxtVlu').val(JSON.stringify(<?php echo json_encode($DeTeC,TRUE);?>));
		$('#JsR').val(JSON.stringify(<?php echo json_encode($JsR,TRUE);?>));
		
	var ls =['f_genre','f_cnty','f_stg','f_procd','f_drct','f_wrtr','f_lng','f_actor','f_rtng','f_amt_raes','f_budget'];	
	var Ya =['f_procd','f_drct','f_wrtr','f_actor'];



	
	$("select").on('change',function(e){
		Asj={};JsR={};Td=[];
		for(var i=0;i<ls.length;i++){
			var Dt = $("#"+ls[i]).val();
			if(Dt){
				  JsR[ls[i]]=Dt;
				  Td=[];
					for(var l=0;l<Dt.length;l++){
							if(Us[Dt[l]]){ 	
								if(!Asj[Dt[l]]){
									Asj[Dt[l]]=Us[Dt[l]]['n']; 
								}
								Td.push(Us[Dt[l]]['n']);
							}
															
					}
					JsR[ls[i]]=Td;
				}
	
		}
			$('#TxtVlu').val(JSON.stringify(Asj));
			$('#JsR').val(JSON.stringify(JsR));
			
	});
		
		
		for(var i=0;i<ls.length;i++){
			$('#'+ls[i]).selectize();
		}
		

	
	

	
   </script>   
  
    
    </body>
</html>