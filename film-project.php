<?php include 'header.php';
{ 
    if(!$user_home->is_logged_in()){ 
        $user_home->redirect(SITE_URL);
    }
    
 
	echo $BY;
?>

<?php 
// ar


  /////////////////////////////////// pagination //////////////////////////////////////
  

    $item_per_page  = 8; //item to display per page
    $page_url       = SITE_URL."project";


    if(isset($_GET["page"])){ //Get page number from $_GET["page"]
      $page_number = filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
      if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
      $page_number = 1; //if there's no page number, set it to 1
    }

    $sql = "SELECT count(*) FROM `films` WHERE `del` = 0 "; 
    $count_sql = $user_home->runQuery($sql); 
    //$count_sql->bindParam(':user_id', $user_id);

    $count_sql->execute();
    $get_total_rows = $count_sql->fetchColumn(); 
    $total_pages = ceil($get_total_rows/$item_per_page);
    

    /////////////////////////////////// pagination end //////////////////////////////////////

    $page_position = (($page_number-1) * $item_per_page); //get starting position to fetch the records

    $stmt = $user_home->runQuery("SELECT * FROM `films` WHERE `del` = 0 ORDER BY id DESC LIMIT ".$page_position." , ".$item_per_page." ");

    //$stmt->bindParam(':user_id', $user_id);

    $stmt->execute();

    $userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<style>
    #StagSde{background: #f6f6f6;
    border-radius: 4px;
    border: 1px solid #dedede;}
    #StagSde li:first-child{border: 0;}
    #StagSde li{line-height: 28px;
    font-size: 14px;
    border-top: 1px solid #dedede;}
    #StagSde li a{text-decoration: none;}
    #StagSde li a:hover{background: #e9e9e9;}
    #StagSde li a p{margin: 0;
    padding: 2px 5px;
    color: #666;}
</style>
<!--<link href="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/js/standalone/selectize.min.js"></script>-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css">
</script><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js"></script>

   <div class="cover" style="display:none;">
		<h2 style="text-transform: capitalize;"> 
			
		</h2>
		<div></div>
   </div>



<div class="film-banner">
	<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
		<h2>Projects</h2>
		
	</div>	
</div>
</div>
</div>
<div class="filmProject-section">
	<div class="container">
        <div class="row">
            <div id="Desk-Bxr" class="col-lg-12 col-md-12 col-sm-12">

            	<div class="col-md-9">
                   <section class="feature_listing" >
            		<!--	<div id="PadBxr">
            				<div id="OvrDta"> 
            				   <b>Stage</b>
            					<div id="OvrHnLsnd"> <div class="stage"><b><span><?php //echo ($_GET['OvrHnLsnd'] ? $_GET['OvrHnLsnd'] : 'All');?></span> <i class="fa fa-angle-down" aria-hidden="true"></i></b>  <ul><li>All</li><li>Script</li><li>Pre-Production</li><li>Production</li><li>Post-Production</li></ul></div></div>
            				</div>	
            					
            				<div id="OvrHnR"> <i class="fa fa-search" aria-hidden="true"></i> <input value="<?php //echo $_GET['OvrHnR'];?>" type="text" placeholder="<?php //echo $_GET['OvrHnR'];?>"/> </div>
            				<div id="OvrHnL"> <div> <b><span><?php //echo ($_GET['OvrHnL'] ? $_GET['OvrHnL'] : 'Film Name');?></span> <i class="fa fa-angle-down" aria-hidden="true"></i></b>  <ul><li>Film Name</li><li>Country</li><li>Language</li><li>Producer</li><li>Director</li><li>Writer</li></ul></div> </div>
            				
            				<div id="UP-Bxr">	
            					<b>Upcoming Premieres</b>
            						<div id="toggles">
            						  	<div class="switch switch--horizontal switch--no-label switch--expanding-inner">
            								  <input value="3" id="radio-m" type="radio" name="seventh-switch" <?php //echo ($_GET['FltSg'] == '3' ? 'checked="checked"' : '');?>/>
            								  <label for="radio-m">Off</label>
            								  <input id="radio-n" value="2" type="radio" name="seventh-switch" <?php //echo ($_GET['FltSg'] == '2' ? 'checked="checked"' : '');?>/>
            								  <label for="radio-n">On</label>
            								  <span class="toggle-outside"><span class="toggle-inside"></span></span>
            							</div>
              						</div>
            				</div>
            			</div>
            			-->
            			
            			
            			<div style="clear:both;"></div>
            			
            			<div class="filter">
                            <h2>Filter by</h2>
                            <div class=" filter-form">
                                <form>
                                    <div class="form-group ">
                                        <label>Title</label>
                                        <input type="text" class="form-control" id="f_name" name="f_name"  placeholder="Title">
                                    
                                    </div>
                                    <div class="form-group">
                                        <label>Country</label>
                                        <?php
                                            //$countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
                                        
                                            $countries = array('Algeria','Angola','Benin','Botswana','Burkina Faso','Burundi','Cameroon','Cape Verde','Central African Republic','Chad','Comoros','Congo-Brazzaville','Congo-Kinshasa','Cote d\'Ivoire','Djibouti','Egypt','Equatorial Guinea','Eritrea','Ethiopia','Gabon','Gambia','Ghana','Guinea','Guinea Bissau','Kenya','Lesotho','Liberia','Libya','Madagascar','Malawi','Mali','Mauritania','Mauritius','Morocco','Mozambique','Namibia','Niger','Nigeria','Rwanda','Senegal','Seychelles','Sierra Leone','Somalia','South Africa','South Sudan','Sudan','Swaziland','São Tomé and Príncipe','Tanzania','Togo','Tunisia','Uganda','Western Sahara','Zambia','Zimbabwe');
                                        
                                        
                                        ?>
                                        <select id="f_cnty" name="f_cnty[]" class="form-control" multiple placeholder="Choose Country">
                                            <!--<option value="">All</option>-->
                                        <?php
                                            foreach($countries as $v){
                                                
                                                echo '<option   value="'.$v.'">'.$v.'</option>';
                                            }
                                        ?>
                
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Language</label>
                                        <?php
                                            $Language = array("English","French","Spanish","Portuguese","Arabic","Other") ?>
                                        <select id="f_lng" name="f_lng[]" class="form-control" multiple placeholder="Choose Language">
                                            <!--<option value="">All</option>-->
                                        <?php
                                            foreach($Language as $v){
                                                
                                                echo '<option   value="'.$v.'">'.$v.'</option>';
                                            }
                                        ?>
                
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Stage</label>
                                        <?php
                                            //$Stage = array("Script","Pre-Production","Production","Post-Production","Complete");
                                            
                                        $Stage = array("Pre-Production","Production","Post-Production","Distribution");  
                                            
                                        ?>
                                            
                                            
                                            
                                        <select id="f_stg" name="f_stg[]" class="form-control" multiple placeholder="Choose Stage">
                                            <!--<option value="">All</option>-->
                                        <?php
                                            foreach($Stage as $v){
                                                
                                                echo '<option   value="'.$v.'">'.$v.'</option>';
                                            }
                                        ?>
                
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Genre</label>
                                       
                                        <select id="f_genre" name="f_genre[]" class="form-control" multiple placeholder="Choose Genre">
                                            <!--<option value="">All</option>-->
                                        	<?php	foreach(array("Action","Crime","Music","Suspense","Adventure","Documentary","Mystery","Thriller","Animation","Drama","Romance","True","story","Biography","Family","Sci-Fi","War","Comedy","Horror","Sport","Western") as $v){ echo '<option value="'.$v.'">'.$v.'</option>';} ?>
                
                                        </select>
                                    </div>
                                
                                
                                
                                <div class="form-group submit-buttons">
                                    <button id="film_fltr" type="button" class="btn btn-primary" onclick="filter()">Submit</button>
                                    <button id="clear_filter" type="button" class="btn btn-primary" onclick="clear_filter()">Clear</button>
                                    </div>
                                </form>  
            
                            </div>
                        </div>
            			
            			
            			
                       <div class="main_div" id="FlmBx" style="max-width:100%;">
                            <?php 
                                if(!empty($userRow)){ 
            					foreach ($userRow as $userRows) {   
            						$Ls = json_decode($userRows['TxtVlu'],TRUE);
            
            				?>
            				<div class="col-sm-12 BxDvr" style="padding:0;">
            					<div class="BxDvrIn">
            						<a class="ABack" href="view-film.php?id=<?php echo $userRows['url']; ?>">
            						    <div class="relative" style="height:180px;position: relative;background-size:cover;background-position:center;background-image:url('<?php if($userRows['film_cover'] == ''){echo '/film_logo/defualt.jpg';} else{echo '/film_logo/'.$userRows['film_cover'];}?>');">
            
                                            <?php
                                                
                                                if($userRows['film_premiere_date'] >= date("Y-m-d H:i:s")){
                                                	$DT = explode(" ",$userRows['film_premiere_date']);
                                                	
                                                	$D = explode("/",$DT[0]);
                                                	$T = explode(":",$DT[1]);
                                                
                                                	if($T[0] > 12){$T[2]='PM';$T[0]=$T[0] - 12;}
                                                	else{ $T[2]='AM'; if($T[0] == 0 || $T[0] == 00){ $T[0] = 12; }}
                                                													
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
                                                
                                                	//echo '<div id="FPD"><span>Film Premiere</span><i class="fa fa-calendar" aria-hidden="true"></i><b>'.$D[2].' '.$M[$D[1]].' '.$D[0].'</b> <i class="fa fa-clock-o" aria-hidden="true"></i><b>'.$T[0].':'.$T[1].' '.$T[2].'</b></div>';
                                                }
            								?>
            							</div>
            						</a>
            						
            						<div class="DvrBx">
            							<div class="DvrBxT">
            								<a href="/film/<?php echo $userRows['url']; ?>"><?php echo  $userRows['f_name'];?></a>
            							
            								<?php 
            									if($_SESSION['IdSer'] == $userRows['created_by']){ echo '<a style="float: right;font-size: 13px;font-weight: 600;" href="/manage-film?id='.$userRows['url'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>'; } ?>
            							</div>
            						  
            						    <div class="DvrBxR">
            						        
            						        <?php /*
            								<div class="DvrBxRT">
            									<div class="DvrBxRTT">
            										
            										<b>Producer:</b>
            										<?php 
            											$i=0;
            											foreach(explode(',',$userRows['f_procd']) as $ay){
            												$i++;
            												if($i < 2){
            													echo '<a href="/@'.$ay.'">'.$Ls[$ay].'</a>';	
            												}	
            											}  
            										?>
            									</div>
            									<div class="DvrBxRTT"> 
            									    <b>Writer:</b>
            											<?php 
            												$i=0;
            												foreach(explode(',',$userRows['f_drct']) as $ay){
            													$i++;
            													if($i < 2){
            														echo '<a href="/@'.$ay.'">'.$Ls[$ay].'</a>';	
            													}	
            												}  
            											?>
            									</div>
            									<div class="DvrBxRTT"> 
            									    <b>Director:</b>
            											<?php 
            												$i=0;
            												foreach(explode(',',$userRows['f_wrtr']) as $ay){
            													$i++;
            													if($i < 2){
            														echo '<a href="/@'.$ay.'">'.$Ls[$ay].'</a>';	
            													}	
            												}  
            											?>
            									</div>
            								</div> */ ?>
            								<div class="DvrBxRB">
            									<div class="V-bottom-C">
            										<b>Country : </b>
            											<?php 
                                						
                                							foreach(explode(',',$userRows['f_cnty']) as $ay){
                            									echo '<p>'.$ay.'</p>';	
                                							}  
                                						?>
            								
            									</div>
            									
            									
            									<div  class="V-bottom-C">
            										<b>Length : &nbsp;</b>
            											<?php 
            											    echo $userRows['f_run']." min";  
            											?>
            									</div>
            								<div  class="V-bottom-C Language">
            										<b>Language : </b>
            											<?php 
            												
            						   /* foreach(explode(',',$userRows['f_lng']) as $ay){
            													
            							    echo '<p>'.$ay.'</p>';	
            														
            							}*/  
            												
            								$f_lng = str_replace(',', ", ", $userRows['f_lng']);
                                            echo $f_lng;  				
            											?>
            									</div>
            								<?php /*
            								<div  class="V-bottom-C">
            									<b>Stage:</b>
            									<p><?php echo $userRows['f_stg'];?></p>
            								</div>
            								<div  class="V-bottom-C">
            									<b>Budget (USD):</b>
            									<p><?php echo $userRows['f_budget'];?></p>
            								</div>
            								<div  class="V-bottom-C">
            									<b>Money Raised (USD):</b>
            									<p><?php echo $userRows['f_amt_raes'];?></p>
            								</div>
            								 */ ?>
            							</div>
            
            						</div>	
            						    <div class="DvrBxL">
            						
            								<div class="DvrBxC">
            									<?php
            										/*$array = explode(',',$userRows['f_genre']);
            										$i=0;
            										$y=0;
            										foreach($array as $ay){
            										$i++;
            											if($i < 4){	
            												echo '<a href="javascript:void(0);">'.$ay.'</a>';
            											}else{
            												$y++;	
            											}	
            										}
            										$sum = $x+$y;*/
            										
                                                    foreach(explode(',',$userRows['f_genre']) as $ay){
                                                        echo  '<a href="javascript:void(0);">'.$ay.'</a>';   
                                                    }
            									?>
            								</div>
            								<div class="DvrBxB">
            							       <p><?php 
            										echo ($userRows['f_plot'] != '' ? $userRows['f_plot'] : '' ); 
            									?></p> 
            								</div>
            						    </div> 
            					    </div>
            				    </div>
            			    </div>
            	
            						
                    <?php 	}
            
            		
            		
            				}else{ 	?>		
            			<div style="text-align:center;">			
            				<span style="display: block;font-weight: 600;font-size: 22px;margin-top: 10px;text-transform: uppercase;" class="mess">Film Not Available</span>
            			</div>
                    <?php } ?>
            		
            		
                         </div>
            			 			 
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
                        <div style="display:none;" id="mess"></div>
                        <div id="pagination" class="pagination-main"> </div>
                        
                    </section> 
                </div> 
                <div class="col-sm-3">
                    <div id="Right-Side-Section">
                            <div class="new_film">
                                <a href="/manage-film">New Project</a> 
                            </div>
                           <h4>Latest Projects</h4>
                             <?php 
                                //WHERE `del` = 1 
            			            $stmt = $user_home->runQuery("
            			                SELECT
            			                    * 
            			                FROM 
            			                    films 
            			                WHERE `del` = 0
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
                                             <h3><strong>Language </strong>: <?php echo $language; ?></h3>
                                             <h3><strong>Stage </strong>: <?php echo $stage; ?></h3>
                                             <h3><strong>Genre </strong>: <?php echo $genre; ?></h3>
                                             
                                         </a>
                                    </li> 
                            <?php  } ?>       
                            </ul>
                            <?php }else{  ?> 
                            
                            	<div class="data_blank">			
                    				<span  class="mess">Film Not Available</span>
                    			</div>
                            
                           <?php } ?>
                    </div>
                </div>
    
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php';?>

<script>
    document.title = "Film Project";
</script>	


<script>

////  pagination

function go_to_page(page_num) {
    var show_per_page = parseInt($('#show_per_page').val(), 0);

    start_from = page_num * show_per_page;

    end_on = start_from + show_per_page;

    $('.mypagi').children().css('display', 'none').slice(start_from, end_on).css('display', 'block');

    $('.page[longdesc=' + page_num + ']').addClass('active').siblings('.active').removeClass('active');

    $('#current_page').val(page_num);
}



function previous() {

    new_page = parseInt($('#current_page').val(), 0) - 1;
    //if there is an item before the current active link run the function
    if ($('.active').prev('.page').length == true) {
        go_to_page(new_page);
    }

}

function next() {
    new_page = parseInt($('#current_page').val(), 0) + 1;
    //if there is an item after the current active link run the function
    if ($('.active').next('.page').length == true) {
        go_to_page(new_page);
    }

} 
	
function filter() {
    
    var f_name = $('#f_name').val();
    
    var selected_f_cnty = [];
    $("#f_cnty option:selected").each(function() {
    	selected_f_cnty.push($(this).val());
    });
    
    var selected_f_lng = [];
    $("#f_lng option:selected").each(function() {
    	selected_f_lng.push($(this).val());
    });
    
    var selected_f_stg = [];
    $("#f_stg option:selected").each(function() {
    	selected_f_stg.push($(this).val());
    });
    
    var selected_genres = [];
    $("#f_genre option:selected").each(function() {
    	selected_genres.push($(this).val());
    });
    
    //$('#loading-image').show();
    //$('#loading-image').hide();
    
    
    $('#FlmBx').html('');
    $('#php_pagination').html('');
    $(".controls").hide();
    
    
    $('#FlmBx').html("<div style='text-align:center;'><img style='margin: 0 auto;display: inline-block;width: 148px;' src='/images/loading.gif'/></div>");
    
 
    
    $.ajax ({
        type: "POST",
        url:  '<?php echo SITE_URL;?>film_filter.php',
        data:{ f_name:f_name,f_cnty:selected_f_cnty,f_lng:selected_f_lng,f_stg:selected_f_stg,f_genre:selected_genres},
      
        dataType: 'json',
        success: function(data) {
            //console.log(data);
            
            if(data.status==1){
                $('#mess').hide();
                
                $('#FlmBx').html(data.html);
    
                //var show_per_page = data.pagination.item_per_page;
                var show_per_page = 8;
                //var number_of_items = $('#search_serv_data').children('#page').size();
                var number_of_items = $('.mypagi').length;
                //alert(number_of_items);
                var number_of_pages = Math.ceil(number_of_items / show_per_page);
    		
    		    $('#pagination').append('<div class="controls"></div><input id="current_page" type="hidden"><input id="show_per_page" type="hidden">');
                $('#current_page').val(0);
                $('#show_per_page').val(show_per_page);
            
                var navigation_html = '<ul class="pagination">';
                
                //navigation_html += '<a class="prev" onclick="previous()">Prev</a>';
                var current_link = 0;
                while (number_of_pages > current_link) {
                    navigation_html += '<li><a class="page" onclick="go_to_page(' + current_link + ')" longdesc="' + current_link + '">' + (current_link + 1) + '</a></li>';
                    current_link++;
                }
                //navigation_html += '<a class="next" onclick="next()">Next</a>';
                
                navigation_html += '</ul>';
            
                $('.controls').html(navigation_html);
                $('.controls .page:first').addClass('active');
                
            
                $('.mypagi').children().css('display', 'none');
                $('.mypagi').children().slice(0, show_per_page).css('display', 'block'); 

            }else{
                $('#FlmBx').html("");
                $('#mess').show();
                $('#mess').html(data.html);
                $(".controls").hide(); 
            }    
            
        },
        error: function(data) {
            console.log('Error: ');
            return false;
        }
    });
}

$( "#clear_filter" ).click(function() {
  window.location.href="<?php echo SITE_URL; ?>project";
});



$("select").SumoSelect({search: true, searchText: 'Enter here.'});

</script>
</body>
</html>
<?php } ?>