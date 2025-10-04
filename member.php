<?php include 'header.php';?>
<?php

    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    
    
    $user_unq =$_SESSION['IdSer'];
    $stmt= $user_home->runQuery("SELECT user_unq,user_name,email,headline,occupation,profile_pic,country_id  FROM users WHERE user_unq!=:user_unq AND user_unq!='' AND `delete_status` = 0 ORDER BY `users`.`created_at` DESC LIMIT 0,10");
    $stmt->execute(array(":user_unq"=>$user_unq));
    $userRow=$stmt->fetchAll(PDO::FETCH_ASSOC);
      
      
    echo $BY;

?>

<div class="member-section">
  <div class="container">
    <div class="row">
      <div id="MainDvr" class="col-lg-12 col-md-12 col-sm-12">
        <div id="AppID" class="col-sm-9 AppID-left"> 
          <!--<h1>17 Connections</h1>-->
          <div class="app-top-section">
            <div id="OvrHnL">
              <p>Sort by</p>
              <div class="left-add"> <b><span>Recent Added</span> <i class="fa fa-angle-down" aria-hidden="true"></i></b>
                <ul>
                  <li>Recent Added</li>
                  <li>First Name</li>
                  <li>Last Name</li>
                </ul>
              </div>
            </div>
            <div id="OvrHnR"> <i class="fa fa-search" aria-hidden="true"></i>
              <input type="text" placeholder="Search By Name"/>
            </div>
          </div>
          <div style="clear:both;"></div>
          <div id="MbrBx-Lst">
            <?php 
			if(!empty($userRow)){
			   foreach ($userRow as $val) {					
			?>
            <div class="MbrBx-Lst">
                <div class="MbrBx-LstDv">
                    <img class="profile-pic" src="<?php echo ( $val['profile_pic'] ? '/profile_pic_image/'.$val['profile_pic'].'' : '/profile_pic_image/profile-default.png' ); ?>">
                    <h2><a class="LnkA" href="/@<?php echo $val['user_unq'];?>"><?php echo $val['user_name']; ?></a></h2>
                    <p>
                        <span><?php 
                        $occupation = str_replace(',', ", ", $val['occupation']);
                        if($occupation!=""){ echo $occupation; }else{ echo "N/A";  }    
                        ?>
                        
                        </span> 
                    </p>
                    <h5 class="country">
                        <span><?php if($val['country_id']!=""){ echo $val['country_id']; }else{ echo "N/A"; } ?></span>
                    </h5>
                    <div class="buton-Lst">
                        <a  href="/@<?php echo $val['user_unq'];?>">View</a>
                    </div>
                </div>
            </div>
            <?php }
			}
			else{
				echo '<p style="text-align: center;line-height: 120px;">No Member Yet</p>';
			}	
			?>
          </div>
          <div class="loadmore">
            <div id="LoaDv" class="load-more">Load More</div>
          </div>
        </div>
       <!-- <div id="AppIed" class="col-sm-3 AppIed-right">
           <div id="MyProfile"  style="display:none">
				<div class="img" style="background-image:url('/profile_pic_image/<?php // echo ( $_SESSION['profile_pic'] ? $_SESSION['profile_pic'] : 'profile-default.png' ) ?>');">
				</div>
				<span><?php // echo $_SESSION['user_name'];?></span>
				<div class="AbTns">
					<a href="/@<?php // echo $_SESSION['IdSer'];?>">Edit Profile</a>	
					<a href="/my-connections">My Network</a>	
				</div>	
			</div>
			<div id="LnkHdr" style="display:none">
				<a href="/aboutus">About</a> <a href="/terms">Terms</a> 
				<a href="/privacy">Privacy</a>	<a href="/contact">Contact</a>			
			</div> 
          
          <?php /*
          <div id="Right-Side-Section">
              
               <h4>  Recent Project</h4>
                 <?php 
                    //WHERE `del` = 1 
			            $stmt = $user_home->runQuery("
			                SELECT
			                    * 
			                FROM 
			                    films 
			                
			                ORDER BY id DESC LIMIT 5
			             ");
			            $status = 0;
			            $stmt->execute();
			            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
			            
			 ?>
               <?php if(!empty($projects)){
               ?>
               
                <ul id="Right-Side-Ajax">
                  
                    
                      <?php
	                $i = 1;
	                foreach($projects as $project){ 
	                
	                
	                $film_name = $project['f_name'];
	                $country = $project['f_cnty'];
	                $language = str_replace(',', ", ", $project['f_lng']);
	                $stage = $project['f_stg'];
	                $genre = str_replace(',', ", ", $project['f_genre']);
	                
			    ?>
                
                        <li>
                            
                             <a href="view-film.php?id=<?php echo $project['url']; ?>">
                                 <h3> <strong>Title</strong> : <?php echo $film_name; ?> </h3>
                                 <h3> <strong>Country </strong>:  <?php echo $country; ?> </h3>
                                 <h3><strong>Language </strong>:<?php echo $language; ?></h3>
                                 <h3><strong>Stage </strong>:<?php echo $stage; ?></h3>
                                 <h3><strong>Genre </strong>:<?php echo $genre; ?></h3>
                                 
                             </a>
                        </li> 
                <?php  } ?>       
                </ul>
                <?php }else{  ?> 
                
                	<div class="data_blank">			
        				<span  class="mess">Film Not Available</span>
        			</div>
                
               <?php } ?>
          </div>  */?>
          
          
          
          
        </div>-->
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
<script>
	    document.title = "Member";
		var Page = "<?php echo SITE_URL; ?>";
		var PageCurnt=1,Mytype='',ty='SoMbr';
		Mytype={type:'SoMbr',vlu:'Recent Added',usr:'<?php echo $_SESSION['IdSer'];?>','page':2};    
		
		/*
		var pos = $("#LnkHdr").position().top - 60;
			var PageCurnt=1,Mytype='',ty='SoMbr';
			Mytype={type:'SoMbr',vlu:'Recent Added',usr:'<?php //echo $_SESSION['IdSer'];?>','page':2};
			
			jQuery(function($){
			  function fixDiv() {
				var $cache = $('#LnkHdr');
				if ($(window).scrollTop() > pos){
				  $cache.css({
					'position': 'fixed',
					'top': '60px',
					'width':'320px'
				  });
				}  
				else{
				  $cache.css({
					'position': 'relative',
					'top': 'auto'
				  });
				}
			  }	
			  $(window).scroll(fixDiv);
			  fixDiv();
			});		
		*/
		
		$("#OvrHnL div b").on('click',function(){
			var c = $("#OvrHnL div ul");
			c.show();
			$("#OvrHnL div ul li").off().on('click', function() {
				var txt = $(this).html();
				
					var myKeyVals = {type:'SoMbr',vlu:txt,usr:'<?php echo $_SESSION['IdSer'];?>'};
				
					var saveData = $.ajax({
						  type: 'POST',
						  url: Page,
						  data: myKeyVals,
						  dataType: "text",
						  success: function(resultData) { 
								$("#MbrBx-Lst").html('');
								var Jsn = JSON.parse(resultData);
								var Js=Jsn['js'];
								for(var i=0;i<Js.length;i++) $("#MbrBx-Lst").append('<div class="MbrBx-Lst"><div class="MbrBx-LstDv"><img class="profile-pic" src="'+(Js[i]['profile_pic'] ? '/profile_pic_image/'+Js[i]['profile_pic'] : "/profile_pic_image/profile-default.png")+'"><h2><a class="LnkA" href="/@'+Js[i]['user_unq']+'">'+Js[i]['user_name']+'</a></h2><p><span>'+(Js[i]['occupation'] ? Js[i]['occupation'].replace(/,/g, ", ") : "N/A")+'</span><span>'+(Js[i]['country_id'] ? Js[i]['country_id'] : "N/A")+'</span></p><div class="buton-Lst"><a href="profile_info.php?id='+Js[i]['user_unq']+'">VIEW</a></div></div></div>');
							
								PageCurnt=Jsn['cnt']['c'];
								PageCurnt=+PageCurnt + 1;
								ty='SoMbr';
								Mytype={type:ty,vlu:txt,usr:'<?php echo $_SESSION['IdSer'];?>','page':PageCurnt};

							
						  }
					});
					saveData.error(function() { alert("Something went wrong"); });
				
				
				$("#OvrHnL div b span").html(txt);
				c.hide();
			});
		
			$(document).mouseup(function(e){		
				if (!c.is(e.target) && c.has(e.target).length === 0) c.hide();
			});
		});

	
		
		
	
		
		$("#LoaDv").on('click',function(){
					PageCurnt=1;

					var myKeyVals = Mytype;
					var saveData = $.ajax({
						  type: 'POST',
						  url: Page,
						  data: myKeyVals,
						  dataType: "text",
						  success: function(resultData) { 
								var Jsn = JSON.parse(resultData);
								var Js=Jsn['js'];
								var v='';
								
								for(var i=0;i<Js.length;i++) $("#MbrBx-Lst").append('<div class="MbrBx-Lst"><div class="MbrBx-LstDv"><img class="profile-pic" src="'+(Js[i]['profile_pic'] ? '/profile_pic_image/'+Js[i]['profile_pic'] : "/profile_pic_image/profile-default.png")+'"><h2><a class="LnkA" href="/@'+Js[i]['user_unq']+'">'+Js[i]['user_name']+'</a></h2><p><span>'+(Js[i]['occupation'] ? Js[i]['occupation'].replace(/,/g, ", ") : "N/A")+'</span><span>'+(Js[i]['country_id'] ? Js[i]['country_id'] : "N/A")+'</span></p><div class="buton-Lst"><a href="profile_info.php?id='+Js[i]['user_unq']+'">VIEW</a></div></div></div>');
								PageCurnt=Jsn['cnt']['c'];
								PageCurnt=+PageCurnt+1;
								if(ty == 'SoMbr'){
									v = $("#OvrHnL div b span").html();
								}
								else if(ty == 'SrKy'){
									v = $("#OvrHnR input").val();
								}
								else{
								
								}
								Mytype={type:ty,vlu:v,usr:'<?php echo $_SESSION['IdSer'];?>','page':PageCurnt};
								if(Js.length > 0) $("#LoaDv").show();
								else $("#LoaDv").hide();
						  }
					});
					saveData.error(function() { alert("Something went wrong"); });
		});
		
		
		
		$("#OvrHnR input").on('keyup',function(){
			PageCurnt=1;
			var v = $(this).val();
			var myKeyVals = {type:'SrKy',vlu:v,usr:'<?php echo $_SESSION['IdSer'];?>'};
			var saveData = $.ajax({
				  type: 'POST',
				  url: Page,
				  data: myKeyVals,
				  dataType: "text",
				  success: function(resultData) { 
						$("#MbrBx-Lst").html('');
						var Jsn = JSON.parse(resultData);
						var Js=Jsn['js'];
						
						for(var i=0;i<Js.length;i++) $("#MbrBx-Lst").append('<div class="MbrBx-Lst"><div class="MbrBx-LstDv"><img class="profile-pic" src="'+(Js[i]['profile_pic'] ? '/profile_pic_image/'+Js[i]['profile_pic'] : "/profile_pic_image/profile-default.png")+'"><h2><a class="LnkA" href="/@'+Js[i]['user_unq']+'">'+Js[i]['user_name']+'</a></h2><p><span>'+(Js[i]['occupation'] ? Js[i]['occupation'].replace(/,/g, ", ") : "N/A")+'</span><span>'+(Js[i]['country_id'] ? Js[i]['country_id'] : "N/A")+'</span></p><div class="buton-Lst"><a href="profile_info.php?id='+Js[i]['user_unq']+'">VIEW</a></div></div></div>');
						PageCurnt=Jsn['cnt']['c'];
						PageCurnt=+PageCurnt + 1;
						ty='SrKy';
						Mytype={type:ty,vlu:v,usr:'<?php echo $_SESSION['IdSer'];?>','page':PageCurnt};
				  }  
			});
			saveData.error(function() { alert("Something went wrong"); });
		});
	</script>
</body></html>