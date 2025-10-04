<?php include 'header.php';


    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    $user_id = $_SESSION['IdSer'];
   
	if(isset($_POST) && $_POST['title']){

	    $id = $_GET['id'];
        $stmt= $user_home->runQuery("SELECT * FROM support WHERE url=:id"); 
        $stmt->execute(array(":id"=>$id));
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
	        
		$vlss='2';

		$title = $_POST["title"];
		$description = $_POST["description"];
	    
	    $location = $_POST["location"];
	    
	    if(!empty($_POST["category"])){
	        $category = implode(',', $_POST["category"]); 
	    }else{
	        $category = "";
	    }
	    

        $created = time();

        if($_GET['id'] == ''){  
            $url= preg_replace('/[^A-Za-z0-9-]+/', '-',$_POST["title"]).'-'.time();
        }else{
            $url = $_GET['id'];
        }


			if($_GET['id'] != ''){
			
		
				
				$stmt = $user_home->runQuery("UPDATE support SET 
				    title=:title,
				    description=:description,
				    category=:category,
			        location=:location
				    WHERE url=:url");

				$stmt->bindParam(':title',$title);
				$stmt->bindParam(':description',$description);
				$stmt->bindParam(':category',$category);
		        $stmt->bindParam(':location',$location);
	            $stmt->bindParam(':url',$url);	

				if($stmt->execute()){
				    
				    
					$Pt = SITE_URL.'manage-support?id='.$url.'&smsg=update';
					
					echo '<script>window.location.href = "'.$Pt.'"; </script>';
				}else{
				    $error_message = "Please try again";
				}
			}else{
	
				$stmt = $user_home->runQuery("INSERT INTO support(title,description,category,created_at,user_id,url,location) VALUES (:title,:description,:category,:created_at,:user_id,:url,:location)");
	 
				$stmt->bindParam(':title',$title);
				$stmt->bindParam(':description',$description);
				$stmt->bindParam(':category',$category);
			    $stmt->bindParam(':location',$location);
				$stmt->bindParam(':user_id',$user_id);
				$stmt->bindParam(':created_at',$created);
	            $stmt->bindParam(':url',$url);


				if($stmt->execute()){
					$Pt = SITE_URL.'manage-support?id='.$url.'&smsg=added';
					//echo $Pt."<br>";
					//die('hi');
					echo '<script>window.location.href = "'.$Pt.'"; </script>';
				}

			}

	  
	}  
	else{
		if($_GET['id'] != ''){
		  $user_id = $_SESSION['IdSer'];
		  $id = $_GET['id'];
		  $stmt= $user_home->runQuery("SELECT * FROM support WHERE url=:id"); 
		  $stmt->execute(array(":id"=>$id));
		  $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
	
		
			  if($userRow['user_id'] != $_SESSION['IdSer']){
				  echo '<script>window.location.href="'.SITE_URL.'manage-support";</script>';
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


<section class="jobAdd-Section jobs-manage">
    <div class="container">
        <div class="row">
			<div class="col-md-12">	
			
			    
			    <span class="success_message">
                    <?php 
                    if($_GET['smsg'] == 'added'){
                        echo "Support added successfully";
                        echo "<script>setTimeout(function() { $('.success_message').fadeOut('slow'); }, 5000);</script>";
                    }
                     
                    if($_GET['smsg'] == 'update'){
                        echo "Support updated successfully";
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
			
			    <h2>Support Details</h2>
			
				<form method="post" enctype="multipart/form-data">
	
				<div class="form-group">
                    <label for="company_name">Organisation</label>
                    <input type="text" class="field-element" name="title" value="<?php echo $_POST['title'];?>" id="Title" placeholder="Organisation Name"/ required>
              
                </div>
			
				<div class="form-group">
                    <label for="company_name">Description</label>
                    <textarea required class="field-element" name="description" placeholder="Enter Description" ><?php echo $_POST['description'];?></textarea>
                </div>

                <div class="form-group">
                    <label for="company_country_id">Country</label>
                    <select name="location" id="select-country" required>
                        <option value=""> - Country - </option>
                    </select>
                </div>        



                
                <div class="form-group">
                    <label for="company_name">Category </label>
                    <select name="category[]" id="category" required="" multiple>
                        <option value=""> - Category - </option>
                        <?php 
                        $categories = array('Acting','Script Writing','Film Financing','Film Production','Film Distribution'); 
                   
                        ?>
                        
                        <?php 
                        $category_list = array();
                        $category_list = explode(",",$_POST['category']); ?>
                        
                        <?php foreach($categories as $category){ 
                        
                                $selected = "";
                            if (in_array("$category", $category_list))
                                {
                                    $selected = "selected";
                                }
        
                        ?>
                        <option <?php echo $selected; ?> value="<?php echo $category; ?>"> <?php echo $category; ?> </option>
                        
                        <?php } ?>
                        
                    </select>
              
                </div>
                
                
				<div class="form-group">	

					<button id="info_contact" type="submit" name="info_contact">Submit</button>

				</div>	
			

				</form>
			</div>   

        </div>
    </div>
</section>  


    <?php include 'footer.php';?>
    <link href="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css" rel="stylesheet"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/js/standalone/selectize.min.js"></script>
    <script>
        document.title = "Manage Support";
    </script>
<!--    <script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/js/standalone/selectize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/air-datepicker/2.2.3/js/i18n/datepicker.en.min.js"></script>-->
    

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    
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
		

        
        
        
        var Cnty=["Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bonaire","Bosnia and Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Cote D'Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador ","Egypt ","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands (Malvinas)","Fed States of Micronesia","Fiji","Finland","France","French Guiana","French Polynesia","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Holy See (Vatican City State)","Honduras","Hungary","Iceland","India","Indonesia","Iran (Islamic Republic of)","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mexico","Moldova, Republic of","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","North Korea","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland ","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russian Federation","Rwanda","Saint Barthelemy","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Martin","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia ","Scotland","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates ","United Kingdom","United States","United States Virgin Islands","Uruguay","Uzbekistan","Vanuatu","Venezuela","Vietnam","Wallis and Futuna Islands","Western Sahara","Yemen","Zambia","Zimbabwe"];
			
        for(var i=0;i<Cnty.length;i++) $('#select-country').append('<option value="'+Cnty[i]+'">'+Cnty[i]+'</option>');

		$("#select-country").val("<?php echo $userRow['location'];?>");
    
		$('select').selectize({});

	
   </script>   
  
    
    </body>
</html>