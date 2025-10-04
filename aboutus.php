<?php include 'header.php';
    /*if(!$user_home->is_logged_in()){ 
    	$user_home->redirect(SITE_URL);
    }*/
	echo $BY;
	
	
    $stmts= $user_home->runQuery("SELECT * FROM manage_about_us WHERE id=1");
    $stmts->execute();
    $userRow=$stmts->fetch(PDO::FETCH_ASSOC);
?>



<?php /*		
		
 <div class="about-banner" style="background: url(<?php echo SITE_URL;?>webimg/<?php echo $userRow['section_1_background_image']; ?>) no-repeat center top;">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="col-lg-6 about-content">
            <h4> <?php echo $userRow['section_1_heading_1'] ?></h4>
       
            <h1><?php echo $userRow['section_1_heading_2'] ?></h1>
        </div>
        <div class="col-lg-6 about-image">
            
            <?php 
                if ($userRow['section_1_image']!="") {  ?>
             
                        <img src="<?php echo SITE_URL;?>webimg/<?php echo $userRow['section_1_image']; ?>">
                    
                    
            <?php  } ?>
            
      
            </div>
      </div>
    </div>
  </div>
</div>   */ ?>

 <div class="about-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
         
         <div class="col-lg-6">
             <h2><?php echo $userRow['section_2_title'] ?></h2>
             <?php echo $userRow['section_2_description'] ?>    
         </div>
        <div class="col-lg-6">
            <?php 
                if ($userRow['section_2_image']!="") {  ?>
             
                        <img src="<?php echo SITE_URL;?>webimg/<?php echo $userRow['section_2_image']; ?>">
                    
                    
            <?php  } ?>
            
             
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
$stmt = $user_home->runQuery("SELECT film_poster,film_cover,f_name,film_premiere_link,url FROM `films` ORDER BY id DESC LIMIT 4 ");
$stmt->execute();

$fl_Row = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>



 <div class="about-trailer">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
         <h2>Latest Projects</h2>
         </div>
         <div class="col-lg-12 col-md-12 col-sm-12">
       
        <?php foreach($fl_Row as $fl){ ?>
        
        
        
         <div class="col-lg-3">
             <?php if($fl['film_cover']!=""){ ?>
             
             <div class="trailer-image">  <a href="film/<?php echo $fl['url'] ?>">   <img src="film_logo/<?php echo $fl['film_cover'] ?>" alt=""> </a>   </div>
             
             <?php }else{  ?>
                <div class="trailer-image"><a href="film/<?php echo $fl['url'] ?>">  <img src="film_logo/defualt.jpg" alt=""> </a> </div>
            <?php } ?>
             <h3><a href="film/<?php echo $fl['url'] ?>"> <?php echo ucfirst($fl['f_name']); ?></a></h3>
         </div>
          <?php } ?>
       
      </div>
    </div>
  </div>
</div>
			
		  
        
    
		

    <?php include 'footer.php';?>
    

    <script>
        document.title = "About Us";
	</script>
        
     
    </body>
</html>