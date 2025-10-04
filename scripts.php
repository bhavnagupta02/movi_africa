<?php include 'header.php';
if(!$user_home->is_logged_in()){ 
	$user_home->redirect(SITE_URL);
}
	echo $BY;
	
    $user_id = $_SESSION['IdSer'];

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>
<?php 

    
    if(isset($_GET['name'])){
        
    
    
       //echo  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        /////////////////////////////////// pagination //////////////////////////////////////
  
    
        $item_per_page  = 8; //item to display per page
        $page_url       = SITE_URL."scripts";
        
        //$actual_link_chng = str_replace("?","/",$actual_link);
        //$page_url = $actual_link_chng;
        //$page_url       = $actual_link;
    
    
        if(isset($_GET["page"])){ //Get page number from $_GET["page"]
          $page_number = filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
            if(!is_numeric($page_number)){        
      
                echo '<script> window.location.href = "'.SITE_URL.'scripts";  </script>';
              //die('Invalid page number!');  
            } //incase of invalid page number
        }else{
          $page_number = 1; //if there's no page number, set it to 1
        }
        
         /////////////////////////////////// pagination end //////////////////////////////////////
        
        if($_GET['name']!=""){
            $filter['f_name'] = $_GET['name'];
        }else{
            $filter['f_name'] = "";
        }
        
        if($_GET['f_stg']!=""){
            $filter['f_stg'] = $_GET['f_stg'];
        }else{
            $filter['f_stg'] = "";
        }
        
        if($_GET['genre']!=""){
            $f_genre = $_GET['genre'];
            if(count($f_genre) > 1){
                $filter['f_genre'] = implode(",",$f_genre);
            }
            else{
                $filter['f_genre'] = $f_genre[0];
            }
        }else{
            $filter['f_genre'] = "";
        }
        
        
        $WHERE = "WHERE del = 0 AND";
     


        foreach($filter as $k => $v){
        
            if($v != ''){
               
                if($k=="f_name"){
                    $WHERE.= " `f_name` LIKE '%".$v."%' AND";
                }
                
                if($k=="f_stg"){
                    $WHERE.= " `f_stg` LIKE '%".$v."%' AND";
                }
                if($k=="f_genre"){
                    $r = str_replace(",","|",$v);;
                    if(count($f_genre) > 1){
                        $WHERE.= " f_genre REGEXP \"($r)\" AND";
                    }
                    else{                
                        $WHERE.= " `f_genre` LIKE '%".$v."%' AND";
                    }
                }
              
            }
         
        }
        $WHERE   =  rtrim($WHERE,"AND");
        
        /* count */
        
        $sql = "SELECT count(*) FROM `scripts` $WHERE  "; 

        $count_sql = $user_home->runQuery($sql); 
        $count_sql->execute();
        $get_total_rows = $count_sql->fetchColumn(); 
             
        
        $total_pages = ceil($get_total_rows/$item_per_page);
        
        /* count end */
    
        $page_position = (($page_number-1) * $item_per_page); //get starting position to fetch the records
         
         //echo "<br>";
        $sql2 = "SELECT * FROM `scripts` $WHERE ORDER BY id DESC LIMIT $page_position , $item_per_page "; 
        
        //echo $stmt = $user_home->runQuery("SELECT * FROM scripts '.$WHERE. ' ORDER BY id DESC LIMIT '.$page_position.' , '.$item_per_page.' "); 
        $stmt = $user_home->runQuery($sql2); 
         
        $stmt->execute();
        $scriptRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    }else{
        
        /////////////////////////////////// pagination //////////////////////////////////////
  

        $item_per_page  = 8; //item to display per page
        $page_url       = SITE_URL."scripts";
    
    
        if(isset($_GET["page"])){ //Get page number from $_GET["page"]
          $page_number = filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
            if(!is_numeric($page_number)){        
      
                echo '<script> window.location.href = "'.SITE_URL.'scripts";  </script>';
              //die('Invalid page number!');  
            } //incase of invalid page number
        }else{
          $page_number = 1; //if there's no page number, set it to 1
        }
        
         /////////////////////////////////// pagination end //////////////////////////////////////
        
        
        
        /* count start  */
        $sql = "SELECT count(*) FROM `scripts` WHERE del = 0 "; 
        $count_sql = $user_home->runQuery($sql); 
    
        $count_sql->execute();
        $get_total_rows = $count_sql->fetchColumn(); 
        
        $total_pages = ceil($get_total_rows/$item_per_page);
        
            /* count end  */
        
        
        $page_position = (($page_number-1) * $item_per_page); //get starting position to fetch the records
        
        $stmt = $user_home->runQuery("SELECT * FROM scripts WHERE del = 0 ORDER BY id DESC LIMIT ".$page_position." , ".$item_per_page." "); 
        $stmt->execute();
        $scriptRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

?>

<div class="jobs-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2>Script Portal</h2>
                <form action="/scripts" method="GET">
                    <div class="input-group">
                        <input type="text" name="name" value="<?php if(isset($_GET['name'])){ echo $_GET['name']; } ?>" placeholder="script name">
                    </div>
                    <div class="input-group select-group">
                        
                        <?php 
                        $genre_data = [];
                        if(isset($_GET['genre'])){ 
                            $genre_data = $_GET['genre']; 
                        }
                        ?>
                        <select name="genre[]" class="form-input select"  multiple placeholder="Select Genre" >
                            <?php
                            $genre_all = array("Action","Crime","Music","Suspense","Adventure","Documentary","Mystery","Thriller","Animation","Drama","Romance","True","Story","Biography","Family","Sci-Fi","War","Comedy","Horror","Sport","Western");
                             	foreach($genre_all as $v){ 
                             	    $selected = "";
                                    if (in_array("$v", $genre_data)){
                                        $selected = "selected";
                                    }
                             	    echo '<option '.$selected.' value="'.$v.'">'.$v.'</option>';
                             	}
                             	?>
                        </select>
                    </div>
                    
                    <div class="input-group select-group">
                        <select name="f_stg" class="form-input  select" >
                            <option value=""> Select Stage</option>
                         	<?php
                         	    $f_stg_all = array("Complete","In Progress");
                             	foreach($f_stg_all as $v){ 
                             	    $selected = "";
                             	    if(isset($_GET['f_stg']) &&  $_GET['f_stg']==  $v){ 
                                        $selected = "selected"; 
                                    }
                             	    echo '<option '.$selected.' value="'.$v.'">'.$v.'</option>';
                             	}
                         	?>
                        </select>
                    </div>
                    
                    <div class="input-group input-button">
                        <button class="button-form" id="search" type="submit">Search</button>
                    </div>
                    <!--<div class="input-group input-button">
                        <button class="button-form" type="submit">Clear</button>
                    </div>-->
                </form>
            
            </div>
        </div>
    </div>
</div>
<!--<div class="job-top-section">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
          
        <h2>Popular Genre</h2>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12">
        
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="wpb-wrapper"> <img class="company_logo" src="images/job1.jpg" alt="">
          <h5>Action</h5>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="wpb-wrapper"> <img class="company_logo" src="images/job2.jpg" alt="">
          <h5>Crime</h5></div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12"><div class="wpb-wrapper"> <img class="company_logo" src="images/job3.jpg" alt="">
          <h5>Music</h5></div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12"><div class="wpb-wrapper"> <img class="company_logo" src="images/job4.jpg" alt="">
          <h5>Suspense</h5></div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12"><div class="wpb-wrapper"> <img class="company_logo" src="images/job5.jpg" alt="">
          <h5>Adventure</h5></div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="wpb-wrapper"> <img class="company_logo" src="images/job6.jpg" alt="">
          <h5>Documentary</h5>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12"><div class="wpb-wrapper"><img class="company_logo" src="images/job7.jpg" alt="">
          <h5>Mystery</h5>
          </div>
        </div>
        
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="wpb-wrapper">
                    <img class="company_logo" src="images/job8.jpg" alt="">
                    <h5>Thriller</h5>
                </div>
            </div>

         
        </div>
      </div>
    </div>
  </div>-->

<div class="job-listing" id="list">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 jobs">
        <div class="a_button"> 
            <a href="manage-script">Add Script</a>
        </div> 
        <h4 >Latest Scripts</h4>
        
        <ul>
            
            
            <?php 
  
            $data_count = count($scriptRow);
            if($data_count > 0){    ?>
                <?php foreach($scriptRow as $script) {  
                        $script_user_id = $script["user_id"];
                        $stmt = $user_home->runQuery("SELECT user_unq,user_name,facebook_username,tweeter_username,instagram_username,email FROM users WHERE user_unq = '$script_user_id'  "); 

                        $stmt->execute();
                        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
                
                
                ?>
                    <li> 
                       
                            <div class="job-image">
                                <img class="company_logo" src="images/script_logo.png" alt="The Library">
                            </div>
                            
                            <div class="script-user-right"> 
                               <?php if($userRow['user_unq']!=$user_id){  ?>
                             <h5 class="user-name-title"><a href="@<?php echo $userRow['user_unq']; ?> "><i class="fa fa-envelope"></i></a></h5>
                             
                             <?php }  ?>
                               <?php if($userRow['user_unq']==$user_id){  ?>
                                
                                    <div class="a_button script-page-btn-edit"> 
                                        <a href="manage-script?id=<?php echo $script['url'];?>"><i class="fa fa-pencil"></i> Edit</a> 
                                    </div>
                                <?php }  ?>
                          
                            </div>
                            
                            <div class="job-inforamation">
                                <h3><?php echo ucfirst($script['f_name']); ?></h3>
                                
                             
                                <h5 class="script-name-title">
                                    
                                    <?php 
                                echo $genre = str_replace(',', ", ", $script['f_genre']);    
                                     ?></h5>
                                <h5 class="script-name-title"><?php echo ucfirst($script['f_stg']); ?></h5>
                                <p><?php echo $script['summary']; ?></p>
                            </div>
                        
                    </li>
            
                <?php }    ?></ul> 
            <?php }else{
                echo "<div class='no_data'>
                    <span>No Script Found </span>
                </div>";
                
            }
            
            ?>
            
        
            <?php
                if(isset($_GET['name'])){  ?>
                    	<div id="php_pagination" class="pagination-main">
                            <?php
                            
                                $user_home->pagination_style();
                
                                //create pagination 
                                echo '<div class="pagination-inner" align="center">';
                                // We call the pagination function here. 
                                echo $user_home->paginate_filter_in_same_page_scripts($item_per_page, $page_number, $get_total_rows, $total_pages, $_GET);
                                echo '</div>';     
                              
                
                              ?>
                        </div>
             <?php   }else{ ?>
                    	<div id="php_pagination" class="pagination-main">
                            <?php
                            
                                $user_home->pagination_style();
                
                                //create pagination 
                                echo '<div class="pagination-inner" align="center">';
                                // We call the pagination function here. 
                                echo $user_home->paginate($item_per_page, $page_number, $get_total_rows, $total_pages, $page_url);
                                echo '</div>';     
                              
                
                              ?>
                        </div>
             <?php   }
            ?>
            
         
      </div>
    </div>
  </div>
</div>
			

    <?php include 'footer.php';?>

    <script>
        document.title = "Script";
        var GetPar = <?=($_GET['page'] ? $_GET['page'] : 0)?>;    
        if(GetPar > 0){
            $('html, body').animate({
                scrollTop: $("#list").offset().top
            }, 500);
        }
        <?php if($_GET['name']!="" || $_GET['genre']!="" || $_GET['f_stg']!="" ){ ?>
      
            $('html, body').animate({
                scrollTop: $("#list").offset().top
            }, 500);
        <?php } ?> 
        
        $(".select").SumoSelect({search: true, searchText: 'Enter here.'});
        
        
	</script>
      

    </body>
</html>