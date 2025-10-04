<?php include 'header.php';

    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    

      $user_id = $_SESSION['user_id'];
      $id=$_GET['id'];
      $stmt= $user_home->runQuery("SELECT id,website_link,f_name,film_poster,film_cover,f_plot,f_genre,f_cnty,f_stg,f_procd,f_drct,f_wrtr,f_lng,f_budget,f_amt_raes,f_yt_lnk,created,created_by,url,rating,rating_total,TxtVlu,like_total,f_rtng,f_run,f_actor,film_premiere_venue,film_premiere_date,website_link FROM films WHERE url=:id"); 
      $stmt->execute(array(":id"=>$id));
      $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	  $Ty = json_decode($userRow['TxtVlu'],TRUE);
	  
	      echo $BY;

?>
    <title>Film : <?php echo $userRow['f_name'];?></title>	
</head>
	<body>
<style>	
		*{box-sizing:border-box}html{font-size:13px;line-height:1.4;font-family:helvetica neue,Helvetica,Arial,sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0;color:#333;background-color:#e6e6e6;}table{border-collapse:collapse;border-spacing:0;border:0}td,th{padding:0}td.top,th.top{vertical-align:top}a{background-color:transparent;text-decoration:none}a:hover{text-decoration:underline}a:active,a:hover{outline:0}a,label{cursor:pointer}img{border:0}b,strong,optgroup{font-weight:700}small{font-size:80%}h1{font-size:2em;margin:.67em 0}p{margin:0;padding:0 0 .5em;text-align:justify}hr{box-sizing:content-box;height:0}button,input,optgroup,select,textarea{color:inherit;font:inherit;margin:0}fieldset{border:1px solid silver;margin:0 2px;padding:.35em .625em .75em}legend{border:0;padding:0}textarea{overflow:auto}
		@media (min-width:320px) and (max-width:560px){
			#RatingBox span{display:none;}
			#Desk-Bxr-FlmVw #ProfileTp div.avatar {
				top: 64px;
			}	
			#Desk-Bxr-FlmVw #ProfileTp div.avatar img{
				width: 80px;
				height: 80px;
			}
			#Desk-Bxr-FlmVw #ProfileTp div.avatar span {
				font-size: 14px;
			}
		}
</style>

    <div id="Desk-Bxr-FlmVw">
	

		<div id="Profile" style="margin-top:0;">
									
						
			<div id="ProfileTp" style="background-image:url(<?php echo ($userRow['film_cover'] != '' ? '/film_logo/'.$userRow['film_cover'] : '/film_logo/defualt.jpg');?>);">
				<div id="ShrBt" class="sharethis-inline-share-buttons"></div>
				<div id="FlBck"></div>
				<div class="avatar">
					<img class="img-circle" src="<?php echo ($userRow['film_poster'] != '' ? '/film_banner/'.$userRow['film_poster'] : '/film_banner/defualt.jpg') ;?>"/>
					<span class="avatar-name"><?php echo $userRow['f_name']; ?></span>									
				</div>	
			
			<?Php
				$stmt = $user_home->runQuery("SELECT rating,likes FROM users WHERE user_unq=:user_unq");
				$stmt->execute(array(":user_unq"=>$_SESSION['IdSer']));
				$Rowuser=$stmt->fetch(PDO::FETCH_ASSOC);
					
				if($Rowuser['rating'] != ''){	
					$Rt = json_decode($Rowuser['rating'],TRUE);
				}
				else{
					$Rt = array();
				}	
				
				if($Rowuser['likes'] != ''){	
					$St = json_decode($Rowuser['likes'],TRUE);
				}
				else{
					$St = array();
				}	
					
					
					
				if ('Complete' == $userRow['f_stg']){
					if (array_key_exists($userRow['id'],$Rt)){
						$Ag = $Rt[$userRow['id']]/2;
						$numberAsString = number_format($Ag,2);
						echo '<div style="position: absolute;right: 25px;background: #fff;top: 12px;border-radius: 3px;padding: 1px 8px;">You\'ve given '.number_format($numberAsString,2).'</div>';
					}
					else
					{
						echo '<fieldset id="rating" class="rating">
							<input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
							<input type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
							<input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
							<input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
							<input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
							<input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
							<input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
							<input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
							<input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
							<input type="radio" id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
						</fieldset>';
					}
					
					if($userRow['rating']!= 0){
						$numberAsFloat = $userRow['rating']/$userRow['rating_total'];
						$Ag = $numberAsFloat/2;
						$numberAsString = number_format($Ag,2);
						
						echo '<div style="position: absolute;right: 25px;background: #fff;top:45px;border-radius: 3px;padding: 1px 8px;" id="RatingBox">Avg Rating <b>'.$numberAsString.'</b> <span>/ Total Votes '.$userRow['rating_total'].'</span></div>';
					}
					else{
						echo '<div style="position: absolute;right: 25px;background: #fff;top:45px;border-radius: 3px;padding: 1px 8px;" id="RatingBox">Become First User To Rate This Movie</div>';
					}
				}	
				echo '<div id="FrameBxLki">
						<i id="likes" class="fa fa-thumbs-up" style="transform: scaleX(-1);-webkit-transform: scaleX(-1);color:'.(array_key_exists($userRow['id'],$St) ? 'rgb(230, 88, 88)' : 'rgb(0, 0, 0)').'" aria-hidden="true"></i> 
						<b>'.$userRow['like_total'].'</b>
					</div>';	
					
				if($userRow['created_by'] == $_SESSION['IdSer']){	
					echo '<a id="EditBxr" href="'.SITE_URL.'manage-film.php?id='.$_GET[id].'">Edit</a>';	
				}	
					
			?>	
				
			</div>
			<div id="ProfileBtm">	
				<div id="ProfileBtmB">
                     <div class="RwBxr" style="margin:0;"> 
                      <div class="RwBxr-65" style="margin:0;background: #f6f6f6;padding:0;position: relative;"> 
                      	<div class="ResBxr"> 
                      	<h2> About </h2> 
                          <div style="padding:5px;"><?php echo nl2br($userRow['f_plot']); ?></div>                         
						<?php
							
							preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/",$userRow['f_yt_lnk'],$matches);
							
						?>	 

						<?php 
if ( $userRow['film_premiere_date'] != '' && ($userRow['film_premiere_venue'] != '' || $userRow['website_link'] != '')){

        $date =  $userRow['film_premiere_date'];
        $date_time = date('j F, Y, g:i A', strtotime($date));
        
        
		$DT = explode(" ",$userRow['film_premiere_date']);
		
            
    
		$D = explode("/",$DT[0]);
		$T = explode(":",$DT[1]);

		if($T[0] > 12){
			$T[2]='PM';
			$T[0]=$T[0] - 12;
		}
		else{
			$T[2]='AM';
			if($T[0] == 0 || $T[0] == 00){
				$T[0] = 12;
			}
		}
		
		
		echo '<br>';

		
			$M = array(
				'01'=>'January',
				'02'=>'February',
				'03'=>'March',
				'04'=>'April',
				'05'=>'May',
				'06'=>'June',
				'07'=>'July ',
				'08'=>'August',
				'09'=>'September',
				'10'=>'October',
				'11'=>'November',
				'12'=>'December',
			);
	
	echo '<div id="PremiereBx">
			<span><i>Film</i> Premiere</span>
		<div id="PremiereBxT">
			<div id="PremiereBxTR">
				<!--<i class="fa fa-calendar" aria-hidden="true"></i><b>'.$D[2].' '.$M[$D[1]].' '.$D[0].'</b> <i class="fa fa-clock-o" aria-hidden="true"></i><b>'.$T[0].':'.$T[1].' '.$T[2].'</b>	-->
				
				<i class="fa fa-calendar" aria-hidden="true"></i><b>'.$date_time.'</b>
			</div>
		</div>
		<div id="PremiereBxC">
				<b>Address : </b> '.$userRow['film_premiere_venue'].'
			</div>		
			<div id="PremiereBxB">
			    <b>Website Link : </b> </b> <a  target="_blank" href="'.$userRow['website_link']. '"> '.$userRow['website_link']. '</a>
		</div>
		
	</div>';
	
	
}


?>		
				 
            <iframe width="560" height="315" style="width: 100%;margin: 0;margin-bottom: 30px;" src="https://www.youtube.com/embed/<?php echo $matches[1];?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>							 
							<div id="TaCatg">
									<?php
										$array = explode(',',$userRow['f_genre']);
										foreach($array as $ay){
											if($userRow['f_stg'] == 'Complete'){
												echo '<a href="javascript:void(0);">'.$ay.'</a>';	
											}
											else if($userRow['f_stg'] != 'Complete'){
												echo '<a href="javascript:void(0);">'.$ay.'</a>';	
											}
										}
									?>	
							</div>
                      </div>
                       </div>
                        <div class="RwBxr-35" style="margin:0 0 0 8px;background:#f6f6f6;padding:0;">
                         <div class="ResBxr" id="DtaBx" >
                          <h2 style="margin-bottom: 5px;">Film Crew</h2>
                            <div style="border-bottom: 1px solid #ccc;overflow:hidden;"> 
							<span style="float:left;width:60px;color: #3ebeac;font-weight: 600;">Producer</span> 
								<div style="float: left;width: 215px;margin: 0;padding: 0;">
									<?php 
										foreach(explode(',',$userRow['f_procd']) as $ay){
											//echo '<a href="/@'.$ay.'">'.$Ty[$ay].'</a>';
											
											echo '<a href="javascript:void(0);">'.$Ty[$ay].'</a>';
											
											
										}  
									?>
								</div>
								
							</div>	
							<div style="border-bottom: 1px solid #ccc;overflow:hidden;"> 
							<span style="float:left;width:60px;color: #3ebeac;font-weight: 600;">Director</span>
								<div style="float: left;width: 215px;margin: 0;padding: 0;">
									<?php 
										foreach(explode(',',$userRow['f_drct']) as $ay){
											//echo '<a href="/@'.$ay.'">'.$Ty[$ay].'</a>';	
							
											echo '<a href="javascript:void(0);">'.$Ty[$ay].'</a>';
										}  
									?>
								</div>
							</div>	
							<div style="overflow:hidden;"> 
							<span style="float:left;width:60px;color: #3ebeac;font-weight: 600;">Writer</span>
								<div style="float: left;width: 215px;margin: 0;padding: 0;">
									<?php 
										foreach(explode(',',$userRow['f_wrtr']) as $ay){
											//echo '<a href="/@'.$ay.'">'.$Ty[$ay].'</a>';
											echo '<a href="javascript:void(0);">'.$Ty[$ay].'</a>';
										}  
									?>
								</div>
							</div>
						
						
						
						<h2 style="margin-bottom: 5px;border-top: 1px solid #ddd;
background: #eee;">Film Cast</h2>
						
	<div>
		<?php 
			foreach(explode(',',$userRow['f_actor']) as $ay){
				//echo '<a href="/@'.$ay.'">'.$Ty[$ay].'</a>';
				echo '<a href="javascript:void(0);">'.$Ty[$ay].'</a>';
			}  
		?>
	</div>					
						
<h2 style="margin-bottom: 5px;border-top: 1px solid #ddd;
background: #eee;margin-top: 5px;">Film Details</h2>
						
							<div id="DvrBxRBNw" style="padding:0;">
								<div style="border-bottom: 1px solid #a8a8a8;padding: 0 5px !important;">
									<b>Stage</b>
									<span><?php 
										foreach(explode(',',$userRow['f_stg']) as $ay){
									
											
											echo '<a href="javascript:void(0);">'.$ay.'</a>';
										}
									?>	</span>
								</div>
								<div style="border-bottom: 1px solid #a8a8a8;padding: 0 5px !important;">
									<b>Country</b>
									<span><?php 
										foreach(explode(',',$userRow['f_cnty']) as $ay){
											echo '<a href="javascript:void(0)">'.$ay.'</a>';	
										}
									?>	
									</span>
								</div>
								<div style="border-bottom: 1px solid #a8a8a8;margin-bottom:8px;padding: 0 5px !important;">
									<b>Language</b>
									<span><?php 
										foreach(explode(',',$userRow['f_lng']) as $ay){
											echo '<a href="javascript:void(0)">'.$ay.'</a>';	
										}  
									?>
								</span>
								</div>
								
							<?php	
								if($userRow['f_stg'] != 'Complete'){
							?>	
								<div>
									<div style="display:inline-block;width:48%;padding-left: 5px !important;">
										<b style="line-height: 13px;">Budget(USD)</b>
										<span style="float: left;"><?php echo $userRow['f_budget'];?></span>
									</div>
								
									<div style="display:inline-block;width:48%;">
										<b style="line-height: 13px;">Fundraising</b>
										<span style="float: left;"><?php echo $userRow['f_amt_raes'];?></span>
									</div>
								</div>
							<?php } else{ ?>
								<div>
									<div style="display:inline-block;width:48%;padding-left: 5px !important;">
										<b style="line-height: 13px;">Budget(USD)</b>
										<span style="float: left;"><?php echo $userRow['f_budget'];?></span>
									</div>
								</div>
							<?php } ?>	
								
								<div>
									<div style="display:inline-block;width:48%;padding-left: 5px !important;">
										<b style="line-height: 13px;">PG (Certificate)</b>
										<span style="float: left;"><?php echo $userRow['f_rtng'];?></span>
									</div>
									<div style="display:inline-block;width:48%;">
										<b style="line-height: 13px;">Movie Run Time</b>
										<span style="float: left;"><?php echo $userRow['f_run'];?></span>
									</div>
									
								</div>
							</div>
							
						 </div> 
                        </div> 
                         </div>
                </div>
			</div>
		</div>	

	
</div>	

	</body>
<?php include 'footer.php';?>
	
<script>
var id="<?php echo $userRow['id']; ?>";
var js={"half":"1","1":"2","2":"4","3":"6","4":"8","5":"10","1 and a half":"3","2 and a half":"5","3 and a half":"7","4 and a half":"9"};
var url="<?php echo $_GET['id'];?>";
$("#rating input").on('click',function(){
	var r = js[$(this).val()];
		$.ajax({
		type: 'POST',
		url: Page,
		data: {type:'rating','r':r,'id':id},
		dataType: "text",
		success: function(resultData){
			window.location.href='/film/'+url+'';
		}
	});	
});

$("#likes").on('click',function(){
		var r = $(this).css("color");
		var s='';
		if(r == 'rgb(0, 0, 0)'){
			s='ad';
		}
		else if(r == 'rgb(230, 88, 88)'){
			s='udt';
		}
		
		$.ajax({
		type: 'POST',
		url: Page,
		data: {type:'likes','r':s,'id':id},
		dataType: "text",
		success: function(resultData){
			 window.location.href='/film/'+url+'';
		}
	});	
});
</script>	
	
</html>