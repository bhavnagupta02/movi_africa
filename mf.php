<?php include 'header.php';


    if(!$user_home->is_logged_in()){ 
      echo '<script>window.location.href="'.SITE_URL.'";</script>';
    }


	if($_GET['id'] != ''){
	  $user_id = $_SESSION['IdSer'];
      $id=$_GET['id'];
      $stmt= $user_home->runQuery("SELECT id,f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,rating,rating_total,TxtVlu,like_total,f_rtng,f_run,f_actor FROM films WHERE url=:id"); 
      $stmt->execute(array(":id"=>$id));
      $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	  $_POST=$userRow;
	  $vlss='1';
	}
	else{
	  $vlss='2';
	}


	
		
	if(isset($_POST) && $_POST['f_name'] != ''){

		if (empty($_POST["f_name"])){
          $Err1 = "Film Name Required";
        }
		else{
          $f_name = $_POST["f_name"];
        }
		
		if (empty($_POST["f_plot"])){
          $Err2 = "Film Plot Required";
        }
		else{
          $f_plot = $_POST["f_plot"];
        }

		
		if (empty($_POST["f_genre"])){
          $Err3 = "At Least Film Genre Required";
        }
		else{
          $f_genre = implode (",",$_POST['f_genre']); 
        }
		
		if (empty($_POST["f_cnty"])) {
          $Err4 = "Country Required";
        } 
		else {
          $f_cnty = implode (",",$_POST["f_cnty"]);
        }
		
		if (empty($_POST["f_stg"])) {
          $Err5 = "Film Stage Required";
        } 
		else {
          $f_stg = $_POST["f_stg"];
        }
		
		if (empty($_POST["f_procd"])) {
          $Err6 = "Film Producers Required";
        } 
		else {
          $f_procd = implode (",",$_POST["f_procd"]);
        }
		
		if (empty($_POST["f_drct"])) {
          $Err7 = "Film Directors Required";
        } 
		else {
          $f_drct = implode (",",$_POST["f_drct"]);
        }
		
		if (empty($_POST["f_wrtr"])) {
          $Err8 = "Film Writer Required";
        } 
		else {
          $f_wrtr = implode (",",$_POST["f_wrtr"]);
        }
		
		if (empty($_POST["f_lng"])) {
          $Err9 = "Film Language Required";
        } 
		else {
          $f_lng = implode (",",$_POST["f_lng"]);
        }
	  
		if (empty($_POST["f_budget"])){
          $Err10 = "Film Budget Required";
        } 
		else{
          $f_budget = $_POST["f_budget"];
        }
		
		if (empty($_POST["f_amt_raes"])){
          $f_amt_raes = "0";
        } 
		else {
          $f_amt_raes = $_POST["f_amt_raes"];
        }
		
		if (empty($_POST["f_yt_lnk"])) {
          $f_yt_lnk = "";
        } 
		else {
          $f_yt_lnk = $_POST["f_yt_lnk"];
        }
		
		if (empty($_POST["f_actor"])) {
          $Err1st = "Film Movie Star At Least One";
        } 
		else {
          $f_actor = implode (",",$_POST["f_actor"]);
        }
		
		if (empty($_POST["f_run"])) {
          $Err2nd = "Film Runtime Required";
        } 
		else {
          $f_run = $_POST["f_run"];
        }
		
		if (empty($_POST["f_rtng"])) {
          $Err3rd = "Film Rating Required";
        } 
		else {
          $f_rtng = $_POST["f_rtng"];
        }		
			
		$DeTeC = json_decode($_POST['TxtVlu'],TRUE);
	
	if($_GET['id'] == ''){	
		if(!empty($_FILES['logo']['name'])){
            $target_dir = "film_banner/";
            $logo_up = $target_dir . basename(time().$_FILES["logo"]["name"]);
            $logo =  basename(time().$_FILES["logo"]["name"]);
            $imageFileType = strtolower(pathinfo($logo_up,PATHINFO_EXTENSION));
            $extensions_arr = array("jpg","jpeg","png","gif");
    
            if(! in_array($imageFileType,$extensions_arr) ){
                $msg = 'Please Choose Only JPG,JPEG,PNG,GIF';    
            }else{
                move_uploaded_file($_FILES['logo']['tmp_name'],$logo_up);
            }
        }
		else{
			$logo='';
			$Err='Film Poster Required';
		}
	}
	else{
		if(!empty($_FILES['logo']['name'])){
            $target_dir = "film_logo/";
            $banner_up = $target_dir.''.$userRow['film_poster'];
            $logo =  $userRow['film_poster'];
            $imageFileType = strtolower(pathinfo($banner_up,PATHINFO_EXTENSION));
            $extensions_arr = array("jpg","jpeg","png","gif");

            if(! in_array($imageFileType,$extensions_arr) ){
                $msg = 'Please Choose Only JPG,JPEG,PNG,GIF';    
            }else{
                move_uploaded_file($_FILES['logo']['tmp_name'],$banner_up);
            }
        }
		else{
			$logo=$userRow['film_poster'];
		}
	}
	
	
	
	
	if($_GET['id'] == ''){	
		if(!empty($_FILES['banner']['name'])){
     
            $target_dir = "film_logo/";
            $banner_up = $target_dir . basename(time().$_FILES["banner"]["name"]);
            $banner =  basename(time().$_FILES["banner"]["name"]);
            $imageFileType = strtolower(pathinfo($banner_up,PATHINFO_EXTENSION));
            $extensions_arr = array("jpg","jpeg","png","gif");

            if(! in_array($imageFileType,$extensions_arr) ){
                $msg = 'Please Choose Only JPG,JPEG,PNG,GIF';    
            }else{
                move_uploaded_file($_FILES['banner']['tmp_name'],$banner_up);
            }
        }
		else{
			$banner='';
		}
	}
	else{
		if(!empty($_FILES['banner']['name'])){
            $target_dir = "film_logo/";
            //$banner_up = $target_dir.''.$userRow['film_cover'];
            $banner =  $userRow['film_cover'];
            $imageFileType = strtolower(pathinfo($banner_up,PATHINFO_EXTENSION));
            $extensions_arr = array("jpg","jpeg","png","gif");

            if(! in_array($imageFileType,$extensions_arr) ){
                $msg = 'Please Choose Only JPG,JPEG,PNG,GIF';    
            }else{
                move_uploaded_file($_FILES['banner']['tmp_name'],$banner_up);
            }
        }
		else{
			$banner=$userRow['film_cover'];
		}
	}

		  $created = time();
		  $created_by = $_SESSION['IdSer'];	
		  $url=preg_replace('/[^A-Za-z0-9-]+/', '-',$_POST["f_name"]).'-'.time();
		
	if($Err1 || $Err2 || $Err3 || $Err4 || $Err5 || $Err6 || $Err7 || $Err8 || $Err9 || $Err10 || $Err || $Err3rd || $Err2nd || $Err1st){
		
	}
	else{
		
		if($_GET['id'] != '' && $_POST['f_url_id'] != ''){
			
			$stmt = $user_home->runQuery("UPDATE films SET f_name=:f_name,f_plot=:f_plot,film_poster=:f_poster,film_cover=:f_cover,f_genre=:f_genre,f_cnty=:f_cnty,f_stg=:f_stg,f_procd=:f_procd,f_drct=:f_drct,f_wrtr=:f_wrtr,f_lng=:f_lng,f_budget=:f_budget,f_amt_raes=:f_amt_raes,f_yt_lnk=:f_yt_lnk,f_rtng=:f_rtng,f_run=:f_run,f_actor=:f_actor,TxtVlu=:TxtVlu WHERE url=:url");
	
			$stmt->bindParam(':f_name',$f_name);
			$stmt->bindParam(':f_plot',$f_plot);
			$stmt->bindParam(':f_poster',$logo);
			$stmt->bindParam(':f_cover',$banner);
			$stmt->bindParam(':f_genre',$f_genre);
			$stmt->bindParam(':f_cnty',$f_cnty);
			$stmt->bindParam(':f_stg',$f_stg);
			$stmt->bindParam(':f_procd',$f_procd);
			$stmt->bindParam(':f_drct',$f_drct);
			$stmt->bindParam(':f_wrtr',$f_wrtr);
			$stmt->bindParam(':f_lng',$f_lng);
			$stmt->bindParam(':f_budget',$f_budget);
			$stmt->bindParam(':f_amt_raes',$f_amt_raes);
			$stmt->bindParam(':f_yt_lnk',$f_yt_lnk);
			$stmt->bindParam(':f_rtng',$f_rtng);
			$stmt->bindParam(':f_run',$f_run);
			$stmt->bindParam(':f_actor',$f_actor);
			$stmt->bindParam(':TxtVlu',$_POST['TxtVlu']);
			$stmt->bindParam(':url',$url);		
			
			if($stmt->execute()){
				$Pt = SITE_URL.'view-film.php?id='.$url;
				echo '<script>window.location.href = "'.$Pt.'"; </script>';
			}
		}
		else{
			$stmt = $user_home->runQuery("INSERT INTO films(f_name,f_plot,film_poster,film_cover,f_genre,f_cnty,f_stg,f_procd,f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,f_rtng,f_run,f_actor,TxtVlu) VALUES (:f_name,:f_plot,:f_poster,:f_cover,:f_genre,:f_cnty,:f_stg,:f_procd,:f_drct,:f_wrtr,:f_lng,:f_budget,:f_amt_raes,:f_yt_lnk,:created,:created_by,:url,:f_rtng,:f_run,:f_actor,:TxtVlu)");
	
	
			$stmt->bindParam(':f_name',$f_name);
			$stmt->bindParam(':f_plot',$f_plot);
			$stmt->bindParam(':f_poster',$logo);
			$stmt->bindParam(':f_cover',$banner);
			$stmt->bindParam(':f_genre',$f_genre);
			$stmt->bindParam(':f_cnty',$f_cnty);
			$stmt->bindParam(':f_stg',$f_stg);
			$stmt->bindParam(':f_procd',$f_procd);
			$stmt->bindParam(':f_drct',$f_drct);
			$stmt->bindParam(':f_wrtr',$f_wrtr);
			$stmt->bindParam(':f_lng',$f_lng);
			$stmt->bindParam(':f_budget',$f_budget);
			$stmt->bindParam(':f_amt_raes',$f_amt_raes);
			$stmt->bindParam(':f_yt_lnk',$f_yt_lnk);
			$stmt->bindParam(':created',$created);
			$stmt->bindParam(':created_by',$created_by);
			$stmt->bindParam(':url',$url);
			$stmt->bindParam(':f_rtng',$f_rtng);
			$stmt->bindParam(':f_run',$f_run);
			$stmt->bindParam(':f_actor',$f_actor);
			$stmt->bindParam(':TxtVlu',$_POST['TxtVlu']);
			
			if($stmt->execute()){
				$Pt = SITE_URL.'view-film.php?id='.$url;
				echo '<script>window.location.href = "'.$Pt.'"; </script>';
			}

		}
	 
			
		
	 
		
	} 
	  
	}  
	 



	 
?>  

<link href="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>

<style>
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
	width:140px;height:140px;border-radius:100%;background-position:center center;background-size:cover;border: 1px solid #fc5c0f;
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

.form-group .Col-50{display: inline-block;
width: calc(50% - 2px);}
</style>

<section>
    <div class="container">
        <div class="row">
            <div class="main_div" style="margin:0 auto 140px">
           
            
			<div class="col-md-10" style="float:none;margin:0 auto 140px;">
				<form method="post" enctype="multipart/form-data">
							
				<div class="col-md-12" id="imagePreviewCvr" style="background-image: url('webimg/35562c7854049dc.jpg');margin: 5px;width: calc(100% - 10px);border-radius: 4px;display: block;height: 260px;background-position: center;background-size: cover;position:relative;background-color: #f6f6f6;border: 1px solid #ddd;">
				
				<h2 class="HdrProFl" style="margin: 0;position: absolute;left: 0;background: #fff;border:solid #fc5c0f;border-width: 1px 1px 1px 0px;line-height: 26px;top: 12px;padding: 1px 4px;font-size: 13px;border-radius: 0 2px 2px 0;width: 140px;text-align: left;">Profile cover</h2>
					
											<div id="CvrBxLd">
												<input type='file' name="banner" id="imageUploadCvr"/>
												<label for="imageUploadCvr"></label>
											</div>	
											
											
											
									<div class="avatar-upload" id="avatar-upload">
										<div class="avatar-edit">
											<input type='file' name="logo" id="imageUpload"/>
											<label for="imageUpload"></label>
										</div>
										<div class="avatar-preview">
											<div id="imagePreview" style="background-image: url('webimg/film-or-movie-camera-logo-design-vector-20451057.jpg');">
											</div>
										</div>
									</div>					
											
				<?php
					if($Err){	
						echo '<span class="ErrDv" style="position: absolute;left: 0px;right: 0;background: rgba(234, 41, 41, 0.68);bottom: 0px;height: 28px;line-height: 28px;text-align: center;font-weight: 600;text-transform: uppercase;border-radius: 0 0 2px 2px;">'.$Err.'</span>';
					}	



						$user_unq = $_SESSION['IdSer'];$status='1';
						$stmt= $user_home->runQuery("SELECT f_unique,t_unique FROM friends WHERE (f_unique=:f_unique OR  t_unique=:t_unique) AND status=:status");
						$stmt->execute(array(":f_unique"=>$user_unq,":t_unique"=>$user_unq,":status"=>$status));
						$Ar=array();$Dta='';
						while($userRow=$stmt->fetch( PDO::FETCH_ASSOC )){
							
							
							if($userRow['f_unique'] == $user_unq){
								array_push($Ar,$userRow['t_unique']);
								$Dta.="'".$userRow['t_unique']."',";
							}
							else if($userRow['t_unique'] == $user_unq){
								array_push($Ar,$userRow['f_unique']);
								$Dta.="'".$userRow['f_unique']."',";
							}
						}
			
						$lst = implode (",",$Ar);
						$Lf = rtrim($Dta,",");
						$user_unq =$_GET['id'];
						
						if($Lf){
    						$stmt= $user_home->runQuery("SELECT user_unq,user_name,email,profile_pic FROM users WHERE user_unq IN ($Lf)");
    						$stmt->execute();$Psh=array();
    						while($userRow=$stmt->fetch( PDO::FETCH_ASSOC )){
    							$Psh[$userRow['user_unq']]=array('n'=>$userRow['user_name'],'e'=>$userRow['email'],'p'=>$userRow['profile_pic']);
    						}
 						    $Psh[$_SESSION['IdSer']] = array(
															'n'=>$_SESSION['user_name'],
															'e'=>$_SESSION['email'],
															'p'=>$_SESSION['profile_pic']
													);    
						}
						else{
						   $Psh[$_SESSION['IdSer']] = array(
															'n'=>$_SESSION['user_name'],
															'e'=>$_SESSION['email'],
															'p'=>$_SESSION['profile_pic']
													);    
						}
						$Sg['Complete']='Complete';
						$Sg['Production']='Production';
					
				?>
				</div>
			
			<div class="col-md-12" style="background: #f6f6f6;border-radius: 4px;border: 1px solid #ddd;padding-top: 5px;margin: 0 5px;width: calc(100% - 10px);">	
				<div class="form-group">
                    <label for="company_name">Film Name</label>
                    <input type="text" class="field-element" name="f_name" value="<?php echo $_POST['f_name'];?>" id="f_name" placeholder="Enter Film Name"/>
                    <span class="error"><?php echo $Err1;?></span>
                </div>
				<div class="form-group">
                    <label for="company_name">Film Plot</label>
                    <textarea class="field-element"  placeholder="Enter Film Plot ...." name="f_plot"><?php echo $_POST['f_plot'];?></textarea>
                    <span class="error"><?php echo $Err2;?></span>
                </div>
				
				<input type="hidden" name="f_url_id" value="<?php echo $_GET['id'];?>"/>
				
				<div class="form-group">
                    <label for="company_name">Film Genre</label>
                    <select multiple name="f_genre[]" id="f_genre" placeholder="Choose Film Genre">
						<?php	foreach(array("Action","Crime","Music","Suspense","Adventure","Documentary","Mystery","Thriller","Animation","Drama","Romance","True","story","Biography","Family","Sci-Fi","War","Comedy","Horror","Sport","Western") as $v){ echo '<option value="'.$v.'">'.$v.'</option>';} ?>
					</select>
                      <span class="error"><?php echo $Err3;?></span>
                </div>
				
				<div class="form-group">
                    <label for="company_name">Stage</label>
                   <select name="f_stg" id="f_stg" placeholder="Choose Stage">
						<?php	
							foreach($Sg as $ky => $vl){ echo '<option value="'.$ky.'">'.$vl.'</option>';} 
						?>
					</select>
                     <span class="error"><?php echo $Err5;?></span>
                </div>
				<div class="form-group">
                    <label for="company_name">Producers</label>
                   <select multiple name="f_procd[]" id="f_procd" placeholder="Choose Producers">
						<?php	
							foreach($Psh as $key => $value){ echo '<option value="'.$key.'">'.$value['n'].' - '.$value['e'].'</option>';} 
						?>
					</select>
                     <span class="error"><?php echo $Err6;?></span>
                </div>
				
				<div class="form-group">
                    <label for="company_name">Directors</label>
                   <select multiple name="f_drct[]" id="f_drct" placeholder="Choose Directors">
						<?php	
							foreach($Psh as $key => $value){ echo '<option value="'.$key.'">'.$value['n'].' - '.$value['e'].'</option>';} 
						?>
					</select>
                     <span class="error"><?php echo $Err7;?></span>
                </div>
				<div class="form-group">
                    <label for="company_name">Writers</label>
                    <select multiple name="f_wrtr[]" id="f_wrtr" placeholder="Choose Writers">
						<?php	
							foreach($Psh as $key => $value){ echo '<option value="'.$key.'">'.$value['n'].' - '.$value['e'].'</option>';} 
						?>
					</select>
                     <span class="error"><?php echo $Err8;?></span>
                </div>

				<div class="form-group">
                    <label for="company_name">Actor</label>
                    <select multiple name="f_actor[]" id="f_actor" placeholder="Choose Movie Star">
						<?php	
							foreach($Psh as $key => $value){ echo '<option value="'.$key.'">'.$value['n'].' - '.$value['e'].'</option>';} 
						?>
					</select>
                    <span class="error"><?php echo $Err1st;?></span>
                </div>
				
				<div class="form-group">
                    <label for="company_name">Country</label>
                    <select name="f_cnty[]" multiple placeholder="Choose Country" id="f_cnty">
						<?php
							foreach(array('Algeria','Angola','Benin','Botswana','Burkina Faso','Burundi','Cameroon','Cape Verde','Central African Republic','Chad','Comoros','Congo-Brazzaville','Congo-Kinshasa','Cote d\'Ivoire','Djibouti','Egypt','Equatorial Guinea','Eritrea','Ethiopia','Gabon','Gambia','Ghana','Guinea','Guinea Bissau','Kenya','Lesotho','Liberia','Libya','Madagascar','Malawi','Mali','Mauritania','Mauritius','Morocco','Mozambique','Namibia','Niger','Nigeria','Rwanda','Senegal','Seychelles','Sierra Leone','Somalia','South Africa','South Sudan','Sudan','Swaziland','São Tomé and Príncipe','Tanzania','Togo','Tunisia','Uganda','Western Sahara','Zambia','Zimbabwe') as $v){
								echo '<option value="'.$v.'">'.$v.'</option>';
							}
							
						?>
					</select>
                    <span class="error"><?php echo $Err4;?></span>
                </div>
				
				<div class="form-group">
                    <label for="company_name">Language</label>
                    <select multiple name="f_lng[]"  id="f_lng" placeholder="Choose Language">
						<?php	foreach(array("English","French","Spanish","Mandarin","Arabic","Malay","Russian","Bengali","AMHARIC","SHONA","OROMO","SWAHILI","YORUBA") as $v){ echo '<option value="'.$v.'">'.$v.'</option>';} ?>
					</select>
                     <span class="error"><?php echo $Err9;?></span>
                </div>
				

				<div class="form-group">
					<div class="Col-50" style="float: left;margin-right: 4px;">
						<label for="company_name">Run Time</label>
						<input type="text" style="height: 36px;line-height: 36px;" class="field-element" name="f_run" value="<?php echo $_POST['f_run'];?>" placeholder="Film Run Time In Minute"/>
						<span class="error" style="right: auto;left: 254px;"><?php echo $Err2nd;?></span>
						
					</div>
					<div class="Col-50">
						<label for="company_name">PG Movie Rating</label>
						<select style="display:none;" name="f_rtng" id="f_rtng" placeholder="Select Your Movie Rating">
							<option value="G">G – General Audiences</option>
							<option value="PG">PG – Parental Guidance Suggested</option>
							<option value="PG-13">PG-13 – Parents Strongly Cautioned</option>
							<option value="R">R – Restricted</option>
							<option value="NC-17">NC-17 – Adults Only</option>
						</select>
						<span class="error"><?php echo $Err3rd;?></span>
					</div>
				</div>
				
				<div class="form-group">
					<div class="Col-50">
						<label for="company_name">Budget(USD)</label>
						<input type="text" class="field-element" name="f_budget" value="<?php echo $_POST['f_budget'];?>" placeholder="Budget(USD)"/>
						  <span class="error" style="right: auto;left: 254px;"><?php echo $Err10;?></span>
					</div>
					<div class="Col-50">
						<label for="company_name">Amount Raised(USD)</label>
						<input type="text" class="field-element" name="f_amt_raes"  value="<?php echo $_POST['f_amt_raes'];?>" placeholder="Amount Raised(USD)"/>
					</div>
				</div>
				<input type="hidden" id="TxtVlu" name="TxtVlu"/>
				
				
				<div class="form-group">
                    <label for="company_name">Film Trailer <sub>Youtube Link</sub></label>
					<input type="text" class="field-element" value="<?php echo $_POST['f_yt_lnk'];?>" name="f_yt_lnk" placeholder="Youtube Film Trailer Link"/>
					<span class="error"> </span>
                </div>
				<div style="text-align:center;">	
							
					
					
						<button id="info_contact" type="submit" name="info_contact" style="font-size: 12px;font-weight: 600;z-index: 2;position: relative;display: inline-block;border-radius: 3px;text-align: center;border: 0;height: 25px;line-height: 24px;background: #d8d8d8;color: #4b4f56 !important;width: 80px;margin: 0 auto 12px;">Add Film</button>


				</div>	
			</div>		
				
				
				
				</form>
			</div>   
				<br style="clear:both;"/>
            </div>
        </div>
    </div>
</section>  


    <?php include 'footer.php';?>
    <script>
        document.title = "Film Manage";
    </script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/js/standalone/selectize.min.js"></script>
    
    <script>
		var lsv = [];
		var vl = "<?php echo $vlss;?>";
		var Us=  <?php echo json_encode($Psh,TRUE);?>;
	if(1 == vl){	
		lsv[0] = "<?php echo $_POST['f_genre'];?>";
		lsv[1] = "<?php echo $_POST['f_cnty'];?>";
		lsv[2] = "<?php echo $_POST['f_stg'];?>";
		lsv[3] = "<?php echo $_POST['f_procd'];?>";
		lsv[4] = "<?php echo $_POST['f_drct'];?>";
		lsv[5] = "<?php echo $_POST['f_wrtr'];?>";
		lsv[6] = "<?php echo $_POST['f_lng'];?>";
		lsv[7] = "<?php echo $_POST['f_actor'];?>";
		lsv[8] = "<?php echo $_POST['f_rtng'];?>";
		
		var ls =['f_genre','f_cnty','f_stg','f_procd','f_drct','f_wrtr','f_lng','f_actor','f_rtng'];
		for(var i=0;i<ls.length;i++){
			$("#"+ls[i]).val(lsv[i].split(','));
		}
	}
	else if(2 == vl){
		lsv[0] = <?php echo json_encode($_POST['f_genre']);?>;
		lsv[1] = <?php echo json_encode($_POST['f_cnty']);?>;
		lsv[2] = "<?php echo $_POST['f_stg'];?>";
		lsv[3] = <?php echo json_encode($_POST['f_procd']);?>;
		lsv[4] = <?php echo json_encode($_POST['f_drct']);?>;
		lsv[5] = <?php echo json_encode($_POST['f_wrtr']);?>;
		lsv[6] = <?php echo json_encode($_POST['f_lng']);?>;
		lsv[7] = <?php echo json_encode($_POST['f_actor']);?>;
		lsv[8] = "<?php echo $_POST['f_rtng'];?>";
		
		
		var ls =['f_genre','f_cnty','f_stg','f_procd','f_drct','f_wrtr','f_lng','f_actor','f_rtng'];
		
		for(var i=0;i<ls.length;i++){
			$("#"+ls[i]).val(lsv[i]);
		}
	}	
		
		
		
		
		var Jsk={},Asj={};	
		$('#TxtVlu').val(JSON.stringify(<?php echo json_encode($DeTeC,TRUE);?>));
		function ca(e,f){
		       
				Jsk[f] = e;
				Asj={};
				
				for(var i in Jsk){
					for(var l=0;l<Jsk[i].length;l++){
						if(Us[Jsk[i][l]]) if(!Asj[Jsk[i][l]]) Asj[Jsk[i][l]]=Us[Jsk[i][l]]['n']; 
					}
				}
				$('#TxtVlu').val(JSON.stringify(Asj));
		}
		
	for(var i=0;i<ls.length;i++){	
		$('#'+ls[i]).selectize({
			onChange: function(value){
				var obj = $(this)[0];
				var id = obj.$input["0"].id;
					if(value) ca(value,id);
			}
		});
	}	

		$("#HelloCvr").hide();$("#ProHmbxr").hide();
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