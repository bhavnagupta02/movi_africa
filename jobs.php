<?php include 'header.php';
if(!$user_home->is_logged_in()){ 
	$user_home->redirect(SITE_URL);
}
	echo $BY;
	$user_id = $_SESSION['IdSer'];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>

<style>
    .input-group{
        margin-right:2px;
    }
</style>

<?php 

    
    if(isset($_GET['name'])){
        
    
    
       //echo  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        /////////////////////////////////// pagination //////////////////////////////////////
  
    
        $item_per_page  = 8; //item to display per page
        $page_url       = SITE_URL."jobs";
        
        //$actual_link_chng = str_replace("?","/",$actual_link);
        //$page_url = $actual_link_chng;
        //$page_url       = $actual_link;
    
    
        if(isset($_GET["page"])){ //Get page number from $_GET["page"]
          $page_number = filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
            if(!is_numeric($page_number)){        
      
                echo '<script> window.location.href = "'.SITE_URL.'jobs";  </script>';
              //die('Invalid page number!');  
            } //incase of invalid page number
        }else{
          $page_number = 1; //if there's no page number, set it to 1
        }
        
         /////////////////////////////////// pagination end //////////////////////////////////////
        
        if($_GET['name']!=""){
            $filter['title'] = $_GET['name'];
        }else{
            $filter['title'] = "";
        }
        
        if($_GET['status']!=""){
            $filter['status'] = $_GET['status'];
        }else{
            $filter['status'] = "";
        }
        
        if($_GET['location']!=""){
            $location = $_GET['location'];
            if(count($location) > 1){
                $filter['location'] = implode(",",$location);
            }
            else{
                $filter['location'] = $location[0];
            }
        }else{
            $filter['location'] = "";
        }

        $WHERE = "WHERE del = 0 AND";


        foreach($filter as $k => $v){
        
            if($v != ''){
               
                if($k=="title"){
                    $WHERE.= " `title` LIKE '%".$v."%' AND";
                }
                if($k=="status"){
                    $WHERE.= " `status` = ".$v." AND";
                }
                
                
                if($k=="location"){
                    $r = str_replace(",","|",$v);;
                    if(count($location) > 1){
                        $WHERE.= " location REGEXP \"($r)\" AND";
                    }
                    else{                
                        $WHERE.= " `location` LIKE '%".$v."%' AND";
                    }
                }
              
            }
         
        }
        $WHERE   =  rtrim($WHERE,"AND");
        
        /* count */
        
        $sql = "SELECT count(*) FROM `jobs` $WHERE  "; 

        $count_sql = $user_home->runQuery($sql); 
        $count_sql->execute();
        $get_total_rows = $count_sql->fetchColumn(); 
             
        
        $total_pages = ceil($get_total_rows/$item_per_page);
        
        /* count end */
    
         $page_position = (($page_number-1) * $item_per_page); //get starting position to fetch the records
         
        // echo "<br>";
        $sql2 = "SELECT * FROM `jobs` $WHERE ORDER BY id DESC LIMIT $page_position , $item_per_page "; 
     
        $stmt = $user_home->runQuery($sql2); 
         
        $stmt->execute();
        $scriptRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    }else{
        
        /////////////////////////////////// pagination //////////////////////////////////////
  

        $item_per_page  = 8; //item to display per page
        $page_url       = SITE_URL."jobs";
    
    
        if(isset($_GET["page"])){ //Get page number from $_GET["page"]
          $page_number = filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
            if(!is_numeric($page_number)){        
      
                echo '<script> window.location.href = "'.SITE_URL.'jobs";  </script>';
              //die('Invalid page number!');  
            } //incase of invalid page number
        }else{
          $page_number = 1; //if there's no page number, set it to 1
        }
        
         /////////////////////////////////// pagination end //////////////////////////////////////
        
        
        
        /* count start  */
        $sql = "SELECT count(*) FROM `jobs` WHERE del = 0 "; 
        $count_sql = $user_home->runQuery($sql); 
    
        $count_sql->execute();
        $get_total_rows = $count_sql->fetchColumn(); 
        
        $total_pages = ceil($get_total_rows/$item_per_page);
        
            /* count end  */
        
        
        $page_position = (($page_number-1) * $item_per_page); //get starting position to fetch the records
        
        $stmt = $user_home->runQuery("SELECT * FROM jobs WHERE del = 0 ORDER BY id DESC LIMIT ".$page_position." , ".$item_per_page." "); 
        $stmt->execute();
        $scriptRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
    

?>



		
		
 <div class="jobs-banner">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12">
          <h2>Job Portal </h2>
          <form>
            <div class="input-group">
                <input type="text" name="name" value="<?php if(isset($_GET['name'])){ echo $_GET['name']; } ?>" placeholder="Job title">
            </div>
            
            
           <?php  
            $countries = array("Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bonaire","Bosnia and Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Cote D'Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador ","Egypt ","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands (Malvinas)","Fed States of Micronesia","Fiji","Finland","France","French Guiana","French Polynesia","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Holy See (Vatican City State)","Honduras","Hungary","Iceland","India","Indonesia","Iran (Islamic Republic of)","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mexico","Moldova, Republic of","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","North Korea","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland ","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russian Federation","Rwanda","Saint Barthelemy","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Martin","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia ","Scotland","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates ","United Kingdom","United States","United States Virgin Islands","Uruguay","Uzbekistan","Vanuatu","Venezuela","Vietnam","Wallis and Futuna Islands","Western Sahara","Yemen","Zambia","Zimbabwe");   ?>
		
            
            	<div class="input-group form-group">
            	      <?php 
                        $country = [];
                        if(isset($_GET['location'])){ 
                            $country = $_GET['location']; 
                        }
                        ?>
                    <select name="location[]" class="form-input  select" placeholder="Select Location"  multiple  >
					
						<?php	foreach($countries as $v){ 
                             	    $selected = "";
                                    if (in_array("$v", $country))
                                    {
                                        $selected = "selected";
                                    }
                             	    echo '<option '.$selected.' value="'.$v.'">'.$v.'</option>';
                             	}
						
						?>
					</select>
                </div>
                <div class="input-group select-group">
                    <select name="status" class="form-input  select" >
                        <option <?php  if(isset($_GET['status']) &&  $_GET['status']==""){ echo "selected"; } ?> value=""> Select Status</option>
                     	<option <?php  if(isset($_GET['status']) &&  $_GET['status']=='1'){ echo "selected"; } ?> value="1"> Open</option>
                     	<option <?php  if(isset($_GET['status']) &&  $_GET['status']=='0'){ echo "selected"; } ?> value="0"> Expired</option>
                    </select>
                </div>
            
            <div class="input-group input-button">
              <button class="button-form" type="submit">Search</button>
            </div>
          </form>
        
      </div>
    </div>
  </div>
</div>

<div class="job-listing" id="list">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 jobs">
                <div class="a_button"> 
                    <a href="/manage-job">Add Job</a>
                </div> 
                <h4 >Latest Jobs</h4>
                <ul>
                    
                    <?php if(count($scriptRow >0)){    ?>
                        <?php foreach($scriptRow as $script) {  
                        $script_user_id = $script["user_id"];
                        $stmt = $user_home->runQuery("SELECT mobile_no,email,user_unq,user_name FROM users WHERE user_unq = '$script_user_id'  "); 

                        $stmt->execute();
                        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        ?>
                        <li> 
                            <div class="job-image">
                                <img class="company_logo" src="images/Job-Icon.png" alt="The Library"></div>
                                <div class="script-user-right">
                                    <?php if($userRow['user_unq']!=$user_id){  ?>
                                    <h5 class="user-name-title"><a href="@<?php echo $userRow['user_unq']; ?> "><i class="fa fa-envelope"></i></a></h5>
                                    <?php }  ?>
                                 
                                    <?php if($userRow['user_unq']==$user_id){  ?>
                                        <div class="a_button"> 
                                            <a href="manage-job?id=<?php echo $script['url'];?>"><i class="fa fa-pencil"></i> Edit</a> 
                                        </div>
                                    <?php }  ?>
                                    
                                </div>
                                <div class="job-inforamation">
                                    <h3><?php echo ucfirst($script['title']); ?></h3>
               
                                    
                                    <h5 class="script-name-title"><?php echo $script['location']; ?></h5>
                                    <p><?php echo $script['description']; ?></p>
                                    <p> <?php 
                                 
                                   /*     $current_date =  date('Y-m-d');
                                       if($current_date>$script['end_date']){
                                           echo "<span class='danger'>Expired</span>";
                                       }else{
                                           echo "<span class='info'>Open</span>";
                                       }*/
                                       
                                       if($script['status']==1){
                                           echo "<span class='info'>Open</span>";
                                       }else{
                                           echo "<span class='danger'>Expired</span>";
                                       }
                                       
                                    
                                    
                                    ?>
                                    
                                    
                                    
                                    </p>
                                    
                                    
                                    <p>Posted : <?php echo date('F j, Y', $script['created_at']); ?></p>
                                </div>
                            
                        </li>
                        <?php }    ?>
                    <?php }else{
                        echo "no job found";
                    }
                    
                    ?>
                     
                    
                
                </ul>
                
                <?php
                        if(isset($_GET['name'])){  ?>
                            	<div id="php_pagination" class="pagination-main">
                                    <?php
                                    
                                        $user_home->pagination_style();
                        
                                        //create pagination 
                                        echo '<div class="pagination-inner" align="center">';
                                        // We call the pagination function here. 
                                        echo $user_home->paginate_filter_in_same_page_jobs($item_per_page, $page_number, $get_total_rows, $total_pages, $_GET);
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
        document.title = "Jobs";
	</script>
        
    <script>
        
        var GetPar = <?=($_GET['page'] ? $_GET['page'] : 0)?>;    
        if(GetPar > 0){
            $('html, body').animate({
                scrollTop: $("#list").offset().top
            }, 500);
        }
        
        <?php if($_GET['name']!="" || $_GET['location']!="" || $_GET['status']!="" ){ ?>
      
            $('html, body').animate({
                scrollTop: $("#list").offset().top
            }, 500);
        <?php } ?> 
        
        $(".select").SumoSelect({search: true, searchText: 'Enter here.'});
	</script>
    </body>
</html>